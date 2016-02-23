<?php

namespace BoomCMS\Installer;

use BoomCMS\Support\Facades\Settings;
use BoomCMS\Support\Facades\Site;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Installer
{
    use DispatchesJobs;

    protected $installFileName = 'boomcms.installed';

    /**
     * @return bool
     */
    public function databaseNeedsInstall()
    {
        try {
            $dbname = DB::connection()->getDatabaseName();
        } catch (\PDOException $e) {
            return true;
        }

        return $dbname ? false : true;
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        return Storage::disk('local')->exists($this->installFileName);
    }

    public function markInstalled()
    {
        Storage::disk('local')->put($this->installFileName, '');

        return $this;
    }

    public function installDatabase(array $config)
    {
        Config::set('database.connections.mysql.host', $config['db_host']);
        Config::set('database.connections.mysql.database', $config['db_name']);
        Config::set('database.connections.mysql.username', $config['db_username']);
        Config::set('database.connections.mysql.password', $config['db_password']);

        if (DB::connection()->getDatabaseName()) {
            $dbenv = "\nDB_HOST={$config['db_host']}\n"
                ."DB_DATABASE={$config['db_name']}\n"
                ."DB_PASSWORD={$config['db_password']}\n"
                ."DB_USERNAME={$config['db_username']}\n";

            file_put_contents(__DIR__.'/../../../../../../.env', $dbenv, FILE_APPEND);
        }
    }

    public function saveSiteDetails($name, $adminEmail)
    {
        Settings::set([
            'site.name'        => $name,
            'site.admin.email' => $adminEmail,
        ]);

        return Site::create([
            'name'        => $name,
            'admin_email' => $adminEmail,
            'default'     => true,
            'hostname'    => '',
        ]);
    }
}
