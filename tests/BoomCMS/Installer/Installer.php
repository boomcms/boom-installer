<?php

use BoomCMS\Core\Settings\Settings;
use BoomCMS\Installer\Installer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InstallerTest extends PHPUnit_Framework_TestCase
{
    private $installer;

    public function setUp()
    {
        parent::setUp();

        $this->installer = new Installer();
    }

    public function testIsNotInstalled()
    {
        Storage::shouldReceive('disk')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('exists')
            ->once()
            ->with('boomcms.installed')
            ->andReturn(false);

        $this->assertFalse($this->installer->isInstalled());
    }

    public function testIsInstalled()
    {
        Storage::shouldReceive('disk')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('exists')
            ->once()
            ->with('boomcms.installed')
            ->andReturn(true);

        $this->assertTrue($this->installer->isInstalled());
    }

    public function testMarkInstalled()
    {
        Storage::shouldReceive('disk')
            ->andReturnSelf()
            ->shouldReceive('put')
            ->with('boomcms.installed', '');

        $this->installer->markInstalled();
    }

    public function testDatabaseNeedsInstallTrueWithNoConnectionDetails()
    {
        DB::shouldReceive('connection')
            ->once()
            ->andThrow('PDOException');

        $this->assertTrue($this->installer->databaseNeedsInstall());
    }

    public function testDatabaseNeedsInstallTrueWithNoDBName()
    {
        DB::shouldReceive('connection')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('getDatabaseName')
            ->once()
            ->andReturn(null);

        $this->assertTrue($this->installer->databaseNeedsInstall());
    }

    public function testDatabaseNeedsInstallFalse()
    {
        DB::shouldReceive('connection')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('getDatabaseName')
            ->once()
            ->andReturn('a_database_name');

        $this->assertFalse($this->installer->databaseNeedsInstall());
    }

    public function testSaveSiteDetails()
    {
        $settings = [
            'site.name'        => 'test',
            'site.admin.email' => 'test@test.com',
        ];

        Settings::shouldReceive('set')
            ->once()
            ->with($settings);

        $this->installer->saveSiteDetails($settings['site.name'], $settings['site.admin.email']);
    }
}
