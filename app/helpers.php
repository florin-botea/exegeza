<?php

use Nwidart\Modules\Facades\Module;

function has_module($m)
{
    if ($m = Module::find($m)) {
        return $m->isEnabled();
    }
    return false;
}