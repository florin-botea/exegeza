<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tags', function () {
    $q = request()->query('q');
    $tags = \App\Tag::where('value', 'LIKE', $q . '%')->pluck('value');

    return response()->json($tags);
});

Route::get('/languages', function () {
    $q = request()->query('q');
    $langs = \App\Language::where('language', 'LIKE', $q . '%')->pluck('language');

    return response()->json($langs);
});

Route::post('/verses-preview', function (Request $request) {
    return response()->json(preg_split($request->regex, $request->verses));
});

Route::get('/articles', function(Request $request) {
    $articles = \App\Article::filtered($request->all())
        ->paginate(1)
        ->appends($request->query());

    return view('xmlhttp.articles-page')->with('articles', $articles);
});