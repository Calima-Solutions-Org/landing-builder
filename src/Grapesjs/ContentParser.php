<?php

namespace Calima\LandingBuilder\Grapesjs;

use Illuminate\Support\Str;

class ContentParser {
    public function parse(string $content): string
    {
        $content = $this->componentShortcodes($content);
        return $content;
    }

    private function componentShortcodes(string $content): string
    {
        $regex = '/\[(builder:[^\]]+)\]/';
        $content = preg_replace_callback($regex, function ($matches) {
            // shortcodes have the following format:
            // builder:component-name :variable1="value" :variable2.each="\App\Models\SomeModel::all()"
            $sharedVariables = [];
            $iterable = [
                'variable' => null,
                'value' => null,
            ];
            $componentName = Str::before(Str::after($matches[1], 'builder:'), ' ');
            $variables = html_entity_decode(Str::after($matches[1], ' '));

            $modifiers = [
                'each' => true,
            ];

            $regex = '/(?<variable>[:\w\-._]+)\s*=\s*("?)(?<value>[^"]+)("?)/';
            preg_match_all($regex, $variables, $variableMatches, PREG_SET_ORDER, 0);
            foreach ($variableMatches as $match) {
                $modifiers = collect(explode('.', $match['variable']), 1)
                    ->slice(1)
                    ->filter(fn ($name, $key) => ! isset($modifiers[$key]))
                    ->mapWithKeys(fn ($name) => [$name => true])
                    ->toArray();

                $variableName = $match['variable'];
                foreach ($modifiers as $modifier => $value) {
                    $variableName = Str::replace('.' . $modifier, '', $variableName);
                }

                $variableName = Str::after($variableName, ':');

                if (isset($modifiers['each'])) {
                    $iterable['variable'] = $variableName;
                    $iterable['value'] = eval('return ' . Str::finish($match['value'], ';'));
                } else {
                    if (Str::startsWith($match['variable'], ':')) {
                        $sharedVariables[$variableName] = eval('return ' . Str::finish($match['value'], ';'));
                    } else {
                        $sharedVariables[$variableName] = $match['value'];
                    }
                }
            }

            if (is_null($iterable['value'])) {
                $content = view('components.' . $componentName, $sharedVariables)->render();
            } else {
                $items = $iterable['value'];
                if (! is_iterable($items)) {
                    $items = [$items];
                }

                $content = '';
                foreach ($items as $item) {
                    $content .= view('components.' . $componentName, array_merge([
                        $iterable['variable'] => $item,
                    ], $sharedVariables))->render();
                }
            }
            return $content;
        }, $content);
        return $content;
    }
}
