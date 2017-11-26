<?php

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

// include the middleware group 'web; to start the session
Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'HomeController@index');
    Route::get('/recent-results', 'HomeController@recentresults');
    Route::get('/fixtures', 'HomeController@fixtures');
    Route::get('/latest-news', 'HomeController@latestnews');
    Route::get('/articles/{url}', 'HomeController@article');
    Route::get('/match-search/{parameters}', 'HomeController@matchsearch');

    Route::get('/opponents', 'OpponentsController@index');
    Route::get('/opponents/{url}', 'OpponentsController@opponent');

    Route::get('/match-details/{date}/{url}', 'MatchController@index');

    Route::get('/players', 'PlayersController@index');
    Route::get('/players/a-z', 'PlayersController@az');
    Route::get('/players/sfa-hall-of-fame', 'PlayersController@sfahalloffame');
    Route::get('/players/silver-caps', 'PlayersController@silvercaps');
    Route::get('/players/leading-goalscorers', 'PlayersController@leadinggoalscorers');
    Route::get('/players/current-players', 'PlayersController@currentplayers');
    Route::get('/players/search/{parameters}', 'PlayersController@searchresults');
    Route::get('/players/tooltip/matches/{appearance_id}', 'PlayersController@matchtooltip');
    Route::get('/players/tooltip/{type}/{id}', 'PlayersController@tooltip');
    Route::get('/players/{id}/{url}', 'PlayersController@player');

    Route::get('/competitions', 'CompetitionsController@index');
    Route::get('/competitions/honours', 'CompetitionsController@honours');
    Route::get('/competitions/{url}', 'CompetitionsController@competitionindex');
    Route::get('/competitions/{type}/{url}', 'CompetitionsController@competition');

    Route::get('/managers', 'ManagersController@index');
    Route::get('/managers/{url}', 'ManagersController@manager');

    Route::get('/history', 'HistoryController@index');
    Route::get('/history/{url}', 'HistoryController@chapter');

    Route::get('/fifa-rankings', 'RankingsController@index');
    Route::get('/fifa-rankings/chart/{start}/{end}/{chart}', 'RankingsController@chart');
    Route::get('/fifa-rankings/date-range/{start}/{end}', 'RankingsController@dateRange');


});