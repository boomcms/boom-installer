<?php

namespace BoomCMS\ServiceProviders;

use BoomCMS\Installer;
use BoomCMS\Jobs;
use BoomCMS\Routing\Router;
use BoomCMS\Support\Facades\Person;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class InstallerServiceProvider extends BaseServiceProvider
{
    use DispatchesJobs;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request, Router $router)
    {
        $installer = new Installer\Installer();

        if (php_sapi_name() !== 'cli' && !$installer->isInstalled()) {
            if (!$this->app['migration.repository']->repositoryExists()) {
                $this->app['migration.repository']->createRepository();
            }

            $this->app['migrator']->run(base_path('/vendor/boomcms/boom-core/src/database/migrations'));

            $site = $installer->saveSiteDetails($request->input('site_name'), $request->input('site_email'));

            $router->setActiveSite($site);

            $name = $request->input('user_name');
            $email = $request->input('user_email');

            $person = $this->dispatch(new Jobs\CreatePerson($email, $name));

            $person->addSite($site);
            $person->setSuperuser(true);
            Person::save($person);

            auth()->login($person);

            $page = $this->dispatch(new Jobs\CreatePage());
            $this->dispatch(new Jobs\CreatePagePrimaryUri($page, '', '/'));
            $installer->markInstalled();

            header('Location: /boomcms/login');
            exit;
        }
    }

    /**
     * @return void
     */
    public function register()
    {
        $installer = new Installer\Installer();

        if (php_sapi_name() !== 'cli' && !$installer->isInstalled()) {
            require __DIR__.'/../../install.php';
        }

        $this->publishes([__DIR__.'/../../../public' => public_path('vendor/boomcms/boom-installer')], 'boomcms');
    }
}
