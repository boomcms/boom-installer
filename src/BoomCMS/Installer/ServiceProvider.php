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
        $installer = new Installer();

        if (php_sapi_name() !== 'cli' && ! $installer->isInstalled()) {
            require __DIR__ . '/../../install.php';
            exit;
        }

        $this->publishes([
          __DIR__.'/../../../public' => public_path('vendor/boomcms/boom-installer'),
        ], 'boomcms');
    }
}
