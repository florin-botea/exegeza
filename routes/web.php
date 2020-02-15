<?php

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

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
    $bibleVersions = \App\BibleVersion::all();
    return view('homepage')->with('bibleVersions', $bibleVersions);
});

Route::resource('bible-versions', 'BibleVersionsController');

Route::resource('bible-versions.books', 'BooksController');

Route::resource('bible-versions.books.chapters', 'ChaptersController');

Route::resource('bible-versions.books.chapters.verses', 'VersesController');

Route::resource('bible-versions.books.articles', 'PendingArticlesController');

Route::resource('bible-versions.books.chapters.articles', 'PendingArticlesController');

Route::resource('articles', 'ArticlesController', ['publish' => 'articles.create']);

Route::resource('pending-articles', 'PendingArticlesController');

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
    Schema::table('user_details', function($table) {
        $table->string('photo', 611)->nullable()->after('user_id');
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

Route::get('/sign', function (Request $req) {
    return view('sign')->with('output', []);
});

Route::post('/sign', function (Request $req) {
    $start = memory_get_usage();

    $src = $req->file("document_confirmare")->getPathname();
    $dest = getcwd();
    $dest = str_replace('\\', '/', $dest) . '/';
    $props = 'E:/myStuffs/exegeza-biblica/public/props.properties';
    $output = shell_exec("java -jar sign.jar $src $dest $props 2>&1");
    $output = json_decode($output, true);

    $end = memory_get_usage();

    $output['memory_used'] = $end-$start;

    return view("sign")->with('output', $output);
});

Route::post('/download', function (Request $req) {
    $pdfname = basename ($req->filename);

    header('Content-Type: application/pdf');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=".$pdfname);
    readfile($req->filename);
});