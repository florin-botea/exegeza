<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
	public function index()
	{
		$bibleVersions = \App\BibleVersion::all();
		dd();
		return view('homepage')->with(['bibleVersions' => $bibleVersions]);
	}
}
