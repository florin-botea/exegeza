<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use IvoPetkov\HTML5DOMDocument;
use App\Models\Book;

class WebScrapperController extends Controller
{
    public function __invoke()
    {
        header('Content-Type: text/html; charset=UTF-8');
//$this->chapter();return; 
$this->verse();return; 

  //      echo '<html><head><meta charset="UTF-8"></head><body>';
        $url = 'http://www.bibliaortodoxa.ro/vechiul-testament.php';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);
        //$resp = utf8_encode($resp);
        $dom = new HTML5DOMDocument;
        $dom->loadHtml($resp);
        $a = $dom->querySelectorAll('.css_main a');
       
        $i = 1;
//Book::getQuery()->delete();
        foreach ($a as $a) {
            $title = strip_tags($a->getAttribute('title'));
            $href = $a->getAttribute('href');
            $slug = explode('/', trim($href, '/'));
            array_pop($slug);
            $slug = implode('/', $slug);
            
            $book = Book::updateOrCreate([
                'index' => $i,
                'slug' => $slug,
                'type' => 1
            ], [
                'name' => $title, 
                'alias' => '',
            ]);
            $i++;
            //print_r(iconv('UTF-8', 'ISO-8859-1', strip_tags($a->ownerDocument->saveHtml($a))));
            //print_r($a->getAttribute('title'));
        }
        dd(json_decode(json_encode(Book::all()),true));
    }
    
    private function chapter()
    {
        $book = Book::first();
        
        $url = 'http://www.bibliaortodoxa.ro/'.$book->slug;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);
        //$resp = utf8_encode($resp);
        $dom = new HTML5DOMDocument;
        $dom->loadHtml($resp);
        $a = $dom->querySelectorAll('.css_navbar a');
  
        $i = 1;
        foreach ($a as $a) {
            //$title = strip_tags($a->getAttribute('title'));
            $slug = $a->getAttribute('href');
            $book->chapters()->firstOrCreate([
                'index' => $i
            ], [
                'slug' => $slug,
                'name' => 'Capitolul '. $i
            ]);
            $i++;
        }
    
        dd(json_decode(json_encode($book->chapters,true)));
    }
    
    
    private function verse()
    {
        $book = Book::first();
        $chapter = $book->chapters()->first();
        $book_id = explode('/',$book->slug);
        $book_id = end($book_id);
        $url = 'http://www.bibliaortodoxa.ro/carte.php?id='.$book_id.'&cap='.$chapter->index;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);
        
        //$resp = utf8_encode($resp);
        $dom = new HTML5DOMDocument;
        $dom->loadHtml($resp);
        $td = $dom->querySelectorAll('table td');
 
        $i = 0;
        $v = 1;
$chapter->verses()->delete();           
        foreach ($td as $td) {
            if (!($i%2)) {
                $i++;
                continue;
            }
            //$title = strip_tags($a->getAttribute('title'));
            //$slug = $a->getAttribute('href');
            $chapter->verses()->firstOrCreate([
                'index' => $i
            ], [
                //'slug' => $slug,
                'text' => strip_tags($td->nodeValue)
            ]);
            $i++;
            $v++;
        }
        
        dd(json_decode(json_encode($chapter->verses->sortBy('index'),true)));
    
    }
}
