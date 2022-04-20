<?php

use App\Models\BibleVersion;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use PhpTemplates\Facades\Template;
//dd(config('app.log_level'));
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
if (!session('ff')) {
    session()->put('ff', uniqid());
}
//dump(session('ff'));

Route::auth();
Auth::routes(['verify' => true]);


// Route::get('/web', 'WebScrapperController');
// homepageController
Route::post('/public', function() {
    ob_start();
    dump($_COOKIE);
    $foo = ob_get_contents();
    ob_end_clean();
    return $foo;
});
Route::get('/', function() {
    ob_start();
    dump($_COOKIE);
    $foo = ob_get_contents();
    ob_end_clean();
    return $foo.'
<script>
function listCookies() {
    var theCookies = document.cookie.split(";");
    var aString = "";
    for (var i = 1 ; i <= theCookies.length; i++) {
        aString += i + " " + theCookies[i-1] + "\n";
    }
    return aString;
}
alert(listCookies());
</script>
<form action="/public" method="post">
<input type="text" name="_token" value="'.csrf_token().'">
<button>fooo</button>
</form>
';
});
//Route::get('/', 'HomepageController@index');// bible index de fapt trb
Route::get('/{book}', 'BookController@show')->name('book');
Route::get('/{book}/{chapter}', 'ChapterController@show')->name('chapter');
// Route::resource('books', 'BookController');

//Route::get('/bible-versions/search', 'BibleSearchController');
//Route::resource('bible-versions', 'BibleVersionController');
Route::resource('bible-versions.books', 'BookController');
Route::resource('bible-versions.books.chapters', 'ChapterController');
Route::resource('bible-versions.books.chapters.verses', 'VerseController');

// articles
Route::put('/articles/{article}/publish', 'ArticleController@publish')->name('articles.publish');
Route::put('/articles/{article}/unpublish', 'ArticleController@unpublish')->name('articles.unpublish');
Route::resource('articles', 'ArticleController');
// Route::resource('bible-versions.books.articles', 'ArticleController');
// Route::resource('bible-versions.books.chapters.articles', 'ArticleController');

//Route::resource('articles', 'ArticleController', ['publish' => 'articles.create']);

//Route::resource('pending-articles', 'PendingArticleController');

Route::resource('users', 'UserController');
Route::get('/users/{user}/danger-zone', 'UserController@dangerZone')->name('users.danger-zone');
Route::put('/users/{user}/change-password', 'UserController@changePassword')->name('users.change-password');
Route::delete('/users/{user}/abort-destroy', 'UserController@abortDestroy')->name('users.abort-destroy');

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
    Schema::table('tablename', function($table) {

    });
    /*
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
    */
    Schema::create('deletion_requests', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('model_type');
        $table->bigInteger('model_id');
        $table->bigInteger('deadline')->nullable();
        $table->bigInteger('user_id')->unsigned();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users');
    });
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

Route::middleware(['can:manage bibles'])->group(function () {
    Route::get('/dev/bible-versions', 'BibleVersionController@manage');
    Route::get('/dev/bible-versions/{bible_version}/books', 'BookController@manage');
    Route::get('/dev/bible-versions/{bible_version}/books/{book}/chapters', 'ChapterController@manage');
});

Route::post('/verses-preview', function (Request $request)
{
    $verses = preg_split($request->regex, $request->verses);
    $request->session()->flash('verses_preview', $verses);

    return back()->withInput($request->all());
});

Route::get('/opinions', function() {
    return view('opinions');
});

Route::resource('comments', 'CommentController');

Route::resource('subscriptions', 'SubscriptionController');
Route::get('/subscriptions/{id}/verify', 'SubscriptionController@verify')->name('subscriptions.verify');
