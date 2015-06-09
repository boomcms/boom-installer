<?php

namespace BoomCMS\Installer;

use BoomCMS\Core\Auth;
use BoomCMS\Core\Commands\CreatePerson as CreatePersonCommand;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Foundation\Bus\DispatchesCommands;

class ServiceProvider extends BaseServiceProvider
{
    use DispatchesCommands;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request, Auth\Auth $auth)
    {
        $installer = new Installer();

        if (php_sapi_name() !== 'cli' && ! $installer->isInstalled()) {
            if ( ! $this->app['migration.repository']->repositoryExists()) {
                $this->app['migration.repository']->createRepository();
            }

            $this->app['migrator']->run(database_path('/migrations'));
            $installer->saveSiteDetails($request->input('site_name'), $request->input('site_email'));

            $person = $this->dispatch(new CreatePersonCommand(
                $request->input('user_name'),
                $request->input('user_email'),
                [],
                $auth,
                $this->app['boomcms.person.provider'],
                $this->app['boomcms.group.provider']
            ));

            $auth->login($person);

            $page = $this->dispatch(new \BoomCMS\Core\Commands\CreatePage($this->app['boomcms.page.provider'], $auth));
            $this->dispatch(new \BoomCMS\Core\Commands\CreatePagePrimaryUri($this->app['boomcms.page.provider'], $page, '', ''));
            $installer->markInstalled();

            header("Location: /");
            exit;
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
