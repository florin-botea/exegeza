<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        
    public function __construct() {
        
    }

    public function inspect($data){
        echo '<pre>'.json_encode($data, JSON_PRETTY_PRINT).'</pre>';
        die();
    }
}
