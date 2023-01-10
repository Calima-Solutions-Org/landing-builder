<?php

namespace Calima\LandingBuilder\Grapesjs;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class Block implements Arrayable {
    protected Attributes $attributes;

    public function __construct(
        public readonly string $path,
    ) {
        $this->attributes = Attributes::from($path);
    }

    public static function all(): array
    {
        if (!File::exists(resource_path('views' . DIRECTORY_SEPARATOR . 'builder'))) {
            return [];
        }

        return collect(File::allFiles(resource_path('views' . DIRECTORY_SEPARATOR . 'builder')))
            ->map(fn (SplFileInfo $file) => str_replace(DIRECTORY_SEPARATOR, '.', Str::before(Str::after($file->getPathname(), resource_path('views' . DIRECTORY_SEPARATOR . 'builder' . DIRECTORY_SEPARATOR)), '.blade.php')))
            ->map(fn (string $path) => new static($path))
            ->toArray();
    }

    public function name(): string
    {
        return $this->attributes->name ?? Str::title(Str::replace('-', ' ', Str::afterLast($this->path, '.')));
    }

    public function id(): string
    {
        return Str::replace('.', '-', $this->path);
    }

    public function category(): string
    {
        return $this->attributes->category ?? Str::title(Str::replace('-', ' ', Str::beforeLast($this->path, '.')));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'label' => $this->name(),
            'category' => $this->category(),
            'content' => view('builder.' . $this->path)->render(),
        ];
    }
}
