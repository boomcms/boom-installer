<?php

namespace BoomCMS\Installer;

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
}