<?php

namespace BoomCMS\Installer;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Installer
{
    protected $installFileName = 'boomcms.installed';

    public function isInstalled()
    {
        return Storage::disk('local')->exists($this->installFileName);
    }

    public function markInstalled()
    {
        Storage::disk('local')->put($this->installFileName);
    }

    public function install(array $config)
    {

        Config::set('database.connections.mysql.host', $config['db_host']);
        Config::set('database.connections.mysql.database', $config['db_name']);
        Config::set('database.connections.mysql.username', $config['db_username']);
        Config::set('database.connections.mysql.password', $config['db_password']);

        if (DB::connection()->getDatabaseName()) {
            $dbenv = "DB_HOST={$config['db_host']}\n"
                . "DB_DATABASE={$config['db_database']}\n"
                . "DB_PASSWORD={$config['db_password']}\n"
                . "DB_USERNAME={$config['db_username']}\n";

            file_put_contents(__DIR__ . '/../../../../.env', $dbenv, FILE_APPEND);
        } else {

        }
    }
}