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
        $href['article_form'] = route('articles.create', ['book' => 0]);
        $breadcrumbs[] = [
            'name' => 'Home'
        ];
     
        return view('homepage', compact('bibles', 'books', 'href', 'breadcrumbs'));
    }
}
