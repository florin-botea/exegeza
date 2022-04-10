<?php

namespace App\Filesystem;

use Illuminate\Filesystem\Filesystem as FilesystemBase;

class Filesystem extends FilesystemBase
{
    public function put($path, $contents, $lock = false)
    {
        // don't pass the value of $lock to the parent method
        return parent::put($path, $contents);
    }
}