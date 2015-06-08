<?php

namespace BoomCMS\Installer;

use BoomCMS\COre\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request, Auth\Auth $auth)
    {
        // On HTTP Post request check for install data in $_POST and complete install if required.

        $installer = new Installer();

        if ( ! $installer->isInstalled()) {
            $this->dispatch('Illuminate\Database\Console\Migrations\InstallCommand');
            $this->dispatch('Illuminate\Database\Console\Migrations\MigrateCommand');

            $person = $this->dispatch('BoomCMS\Core\Commands\CreatePerson', [$request->input('user_name'), $request->input('user_email'), []]);
            $auth->login($person);

            $this->dispatch('BoomCMS\Core\Commands\CreatePage', $this->app['boomcms.page.provider'], $auth);
            $installer->markInstalled();
        }
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

        $this->publishes([
          __DIR__.'/../../../public' => public_path('vendor/boomcms/boom-installer'),
        ], 'boomcms');
    }
}
