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

    protected array $styles = [
        'plugin-landing-builder' => __DIR__.'/../resources/dist/landing-builder.css',
    ];

    protected array $scripts = [
        'plugin-landing-builder' => __DIR__.'/../resources/dist/landing-builder.js',
    ];

    // protected array $beforeCoreScripts = [
    //     'plugin-landing-builder' => __DIR__ . '/../resources/dist/landing-builder.js',
    // ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
        $package->hasRoutes(__DIR__ . '/../routes/web.php');
    }
}
