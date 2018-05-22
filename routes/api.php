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

Route::get('/v1/recent-results', 'ApiController@recentMatches');
Route::get('/v1/fixtures', 'ApiController@fixtures');
Route::get('/v1/match-search/{parameters}', 'ApiController@searchResults');
Route::get('/v1/news', 'ApiController@news');
Route::get('/v2/news', 'ApiNewController@news');
Route::get('/v1/news/{id}', 'ApiController@newsArticle');

Route::get('/v1/opponents', 'ApiController@opponents');
Route::get('/v2/opponents', 'ApiNewController@opponents');
Route::get('/v1/opponents/{id}', 'ApiController@opponentMatches');

Route::get('/v1/competitions', 'ApiController@competitions');
Route::get('/v2/competitions', 'ApiNewController@competitions');
Route::get('/v1/competitions/{id}', 'ApiController@competitionVersions');
Route::get('/v2/competitions/{id}', 'ApiNewController@competitionVersions');
Route::get('/v1/competitions/version/{id}/match-details', 'ApiController@competitionMatchDetails');
Route::get('/v1/competitions/version/{id}/tables', 'ApiController@competitionTables');
Route::get('/v1/competitions/version/{id}/table-results', 'ApiController@competitionTableResults');

Route::get('/v1/players/{type}/{letter?}', 'ApiController@players');
Route::get('/v1/player/{id}', 'ApiController@player');
Route::get('/v1/player/{id}/matches', 'ApiController@playerMatches');

Route::get('/v1/managers', 'ApiController@managers');
Route::get('/v1/managers/{id}', 'ApiController@managerMatches');

Route::get('/v1/match/{id}', 'ApiController@match');
