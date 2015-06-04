<?php

use BoomCMS\Installer\Installer;
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
            ->with('boomcms.installed');

        $this->installer->markInstalled();
    }
}