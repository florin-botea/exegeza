<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BibleVersion;
use App\Models\Book;
use PhpTemplates\Facades\Template;

class HomepageController extends Controller
{
    public function index()
    {
        $bibles = BibleVersion::all();
        $books = Book::all();
        $breadcrumbs[] = [
            'name' => 'Home'
        ];
      //return response('Hello World');
  
        return view('homepage', compact('bibles', 'books', 'breadcrumbs'));
    }
}
