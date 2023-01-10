<?php

namespace Calima\LandingBuilder;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class LandingBuilderServiceProvider extends PluginServiceProvider
{
    public static string $name = 'landing-builder';

    protected array $resources = [
        // CustomResource::class,
    ];

    protected array $pages = [
        // CustomPage::class,
    ];

    protected array $widgets = [
        // CustomWidget::class,
    ];

    // protected array $beforeCoreScripts = [
    //     'plugin-landing-builder' => __DIR__ . '/../resources/dist/landing-builder.js',
    // ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
        $package->hasRoutes('/../routes/web');
        $package->hasViews('calima-builder');
        $package->hasMigrations('2022_09_18_150122_create_builder_files_table');
        $package->hasConfigFile('pagebuilder');
    }

    protected function getStyles(): array
    {
        return [
            'grapesjs' => __DIR__.'/../resources/dist/css/grapes.min.css',
            url('/css/grapesjseditor.css'),
        ];
    }

    protected function getScripts(): array
    {
        return [
            'grapesjs' => __DIR__.'/../resources/dist/js/grapes.min.js',
            url('/js/grapesjseditor.js'),
        ];
    }
}
