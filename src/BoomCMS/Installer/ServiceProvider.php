<?php

namespace BoomCMS\Installer;

use BoomCMS\Core\Auth;

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
        $installer = new Installer();

        if ( ! $installer->isInstalled()) {
            $this->dispatch('Illuminate\Database\Console\Migrations\InstallCommand');
            $this->dispatch('Illuminate\Database\Console\Migrations\MigrateCommand');

            $installer->saveSiteDetails($request->input('site_name'), $request->input('site_email'));

            $person = $this->dispatch('BoomCMS\Core\Commands\CreatePerson', [$request->input('user_name'), $request->input('user_email'), []]);
            $auth->login($person);

            $page = $this->dispatch('BoomCMS\Core\Commands\CreatePage', $this->app['boomcms.page.provider'], $auth);
            $this->dispatch('BoomCMS\Core\Commands\CreatePagePrimaryUri', $this->app['boomcms.page.provider'], $page, '', '');
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

        $this->publishes([__DIR__.'/../../../public' => public_path('vendor/boomcms/boom-installer')], 'boomcms');
    }
}
