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

        if ( ! $installer->isInstalled()) {
            require __DIR__ . '/../../install.php';
            exit;
        }
    }
}
