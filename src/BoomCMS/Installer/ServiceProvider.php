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
    public function boot()
    {
        // On HTTP Post request check for install data in $_POST and complete install if required.

        // $this->dispatch('BoomCMS\Core\Commands\CreatePerson', [$config['user_name'], $config['user_email'], []]);
        // $installer->install($_POST);
    }

    /**
	 *
	 * @return void
	 */
    public function register()
    {
        $installer = new Installer();

        if (php_sapi_name() !== 'cli' && ! $installer->isInstalled()) {
            require __DIR__ . '/../../install.php';
        }

        $this->publishes([__DIR__.'/../../../public' => public_path('vendor/boomcms/boom-installer')], 'boomcms');
    }
}
