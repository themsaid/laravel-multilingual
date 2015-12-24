<?php
namespace Themsaid\Multilingual;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;

class MultilingualServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $systemLocales = config('multilingual.locales');

        $this->publishes([
            __DIR__ . '/config/multilingual.php' => config_path('multilingual.php'),
        ]);


        $this->app['validator']->extendImplicit('translatable_required', function ($attribute, $value, $parameters) use ($systemLocales) {
            if ( ! is_array($value)) return false;

            // Get only the locales that has a value and exists in
            // the system locales array
            $locales = array_filter(array_keys($value), function ($locale) use ($value, $systemLocales) {
                return @$value[$locale] && in_array($locale, $systemLocales);
            });

            foreach ($systemLocales as $systemLocale) {
                if ( ! in_array($systemLocale, $locales))
                    return false;
            }

            return true;
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/multilingual.php', 'multilingual'
        );
    }
}