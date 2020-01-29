<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VersesController extends Controller
{
	public function __construct ()
	{
		// $this->middleware('chapters_pagination_handler', ['only'=>'index']);
	}

	public function index ()
	{
		abort(404);
	}
	
    public function store ()
	{
			
	}
}
