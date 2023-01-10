<?php

namespace Calima\LandingBuilder\Grapesjs;

use Illuminate\Support\Str;

class Attributes {
    public function __construct(
        private string $comments,
        private array $attributes = [],
    ) {
        $this->parseComments();
    }

    public static function from(string $path)
    {
        if ($path === 'features') {
            $comments = self::getComments($path);
        }

        return new static($comments ?? '');
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    private static function getComments(string $path): ?string
    {
        $view = view('builder.' . $path);
        $contentTags = ['{{', '}}'];
        $pattern = sprintf('/%s--(.*?)--%s/s', $contentTags[0], $contentTags[1]);
        $comments = [];
        preg_match($pattern, file_get_contents($view->getPath()), $comments);

        if (empty($comments)) {
            return null;
        }

        return $comments[1];
    }

    private function parseComments()
    {
        if (empty($this->comments)) {
            return;
        }

        $removeLinesThatAreNotAttributes = function (string $line) {
            return Str::startsWith($line, '@') && preg_match('/@([\w._-]+)/', $line);
        };

        $getAttribute = function (string $line) {
            preg_match('/@([\w]+)/', $line, $attribute);
            $attribute = $attribute[1];
            return [
                $attribute => trim(Str::after($line, $attribute)),
            ];
        };
        $comments = collect(explode("\n", trim($this->comments)))
            ->map(fn (string $line) => trim($line))
            ->filter($removeLinesThatAreNotAttributes)
            ->values()
            ->mapWithKeys($getAttribute)
            ->toArray();

        $this->attributes = $comments;
    }
}
