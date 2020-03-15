<?php

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::auth();

Route::get('/', function () {
    $bibles = \App\BibleVersion::all();
    return view('homepage')->with('bibles', $bibles);
});

Route::get('/bible-versions/search', 'BibleSearchController');
Route::resource('bible-versions', 'BibleVersionsController');
Route::resource('bible-versions.books', 'BooksController');
Route::resource('bible-versions.books.chapters', 'ChaptersController');
Route::resource('bible-versions.books.chapters.verses', 'VersesController');

// articles
Route::put('/articles/{article}/publish', 'ArticlesController@publish')->name('articles.publish');
Route::put('/articles/{article}/unpublish', 'ArticlesController@unpublish')->name('articles.unpublish');
Route::resource('articles', 'ArticlesController');
// Route::resource('bible-versions.books.articles', 'ArticlesController');
// Route::resource('bible-versions.books.chapters.articles', 'ArticlesController');

//Route::resource('articles', 'ArticlesController', ['publish' => 'articles.create']);

//Route::resource('pending-articles', 'PendingArticlesController');

Route::resource('users', 'UsersController');

Route::get('/artisan', function () {
    return view('artisan');
});

Route::post('/artisan', function () {
    $raw = explode('--', request()->command);
    $command = trim($raw[0]);
    $flags = [];
    foreach (array_slice($raw, 1) as $raw_flag) {
        $flag = explode('=', trim($raw_flag));
        isset($flag[1]) ? $flags['--' . $flag[0]] = $flag[1] : $command .= (' --' . $flag[0]);
    }
    \Artisan::call($command, $flags);

    return back();
});

Route::get('/migrate-patches', function () {
    //Schema::table('user_details', function($table) {
    //    $table->string('photo', 611)->nullable()->after('user_id');
    //});
    $lipsum = new joshtronic\LoremIpsum();
    for ($i=1; $i<28; $i++) {
        $book = $lipsum->words(rand(1,4));
        \App\BibleVersion::find(1)->books()->create([
            'index' => $i,
            'name' => $book,
            'alias' => substr($book, 0, 3),
            'slug' => Str::slug($book, '-'),
            'type' => 'nt'
        ]);
    }
});

Route::get('/dev', function(Request $request){
    $role = $request->query('role', null);
    $permission = $request->query('permission', null);
    if ($role) {
        $role = Role::firstOrCreate(['name'=>$role]);
        auth()->user()->assignRole( $role );
    }
    if ($permission) {
        $permission = Permission::firstOrCreate(['name'=>$permission]);
        auth()->user()->givePermissionTo( $permission );
    }
});

Route::post('/upload-photo', function(Request $request){
    if ($request->file('upload')) {
        $path = Storage::put('/public/articles/photos', $request->file('upload'));
        $path = str_replace('public/', '', $path);
        $url = '/storage/'.$path;
        return ['url' => $url];
    }
});

Route::get('/dev/bible-versions', 'BibleVersionsController@manage');
Route::get('/dev/bible-versions/{bible_version}/books', 'BooksController@manage');
Route::get('/dev/bible-versions/{bible_version}/books/{book}/chapters', 'ChaptersController@manage');

Route::post('/verses-preview', function (Request $request) 
{
    $verses = preg_split($request->regex, $request->verses);
    $request->session()->flash('verses_preview', $verses);

    return back()->withInput($request->all());
});