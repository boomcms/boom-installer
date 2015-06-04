<?php

namespace BoomCMS\Installer;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
    public function boot() {}

    /**
	 *
	 * @return void
	 */
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views/boom/installer', 'boom.installer');

        $this->app->singleton('boomcms.installer', function ($app) {
            return new Installer();
        });
    }
}
