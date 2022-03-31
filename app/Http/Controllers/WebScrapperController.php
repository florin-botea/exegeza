<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use IvoPetkov\HTML5DOMDocument;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Verse;

class WebScrapperController extends Controller
{
    public function __invoke()
    {
        $book_index = request()->get('book_index', 1);
        $chapter_index = request()->get('chapter_index', 1);
        $type = $book_index >= 40 ? 2 : 1;

        $url = "https://biblia.ortodoxa.info/biblia/versiuni_paralele/vbor/%s/%s";
        $url = sprintf($url, $book_index, $chapter_index);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);
        //$resp = utf8_encode($resp);
        $dom = new HTML5DOMDocument;
        $dom->loadHtml($resp, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);
        
        $verseNodes = $dom->querySelectorAll('.verset');
        if ($verseNodes->count() == 0) {
            $book_index++;
            $chapter_index = 1;
        } else {
            $bookNameNode = $dom->querySelector('#versiuniBiblii h2');
            $chapterNameNode = $dom->querySelector('#versetele h4');
            $book = $bookNameNode->nodeValue;
            $chapter = $chapter_index == 151 ? 'Psalmul 151' : $chapterNameNode->nodeValue;

            
            //TODO: renuntam la id-uri de legatura
            

            Book::updateOrCreate([
                'index' => $book_index,
                'version' => 'NTR',
                'type' => $type
            ], [
                'name' => $book,
                'alias' => '-',
                'slug' => Str::slug($book),
            ]);

            Chapter::updateOrCreate([
                'book_index' => $book_index,
                'index' => $chapter_index
            ], [
                'name' => $chapter
            ]);

            Verse::where('chapter_index', $chapter_index)->where('book_index', $book_index)->delete();

            $i = 1;
            foreach ($verseNodes as $vnode) {
                $verse = '';
                foreach ($vnode->childNodes as $cn) {
                    if ($cn->nodeName == '#text' || $cn->nodeName == 'span') {
                        $verse = trim($cn->nodeValue);
                    }
                }
                if (!$verse) {
                    dd($book_index, $chapter_index, $i);
                }
                Verse::create([
                    'book_index' => $book_index,
                    'chapter_index' => $chapter_index,
                    'index' => $i,
                    'text' => $verse
                ]);
                $i++;
            }

            $chapter_index++;
        }

        if ($book_index > 82) {
            return;
        }
        
        echo "<script>window.location = 'http://localhost/public/web?book_index={$book_index}&chapter_index={$chapter_index}';</script>";

return;
        #versiuniBiblii h2 e nume carte
        
        #versetele h4 e titlul capitolului
        
        // while raspuns are .verset ->count() / length
        
        // https://biblia.ortodoxa.info/biblia/versiuni_paralele/vbor/40/1
        // incepand de la 40, e NT.
        
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
