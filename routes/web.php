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

    Route::get('/strips', 'StripsController@index');
    Route::get('/strips/{url}', 'StripsController@strip');
    Route::get('/strips/tooltip/matches/{id}', 'StripsController@matchtooltip');

    Route::get('/sitemap', 'OtherController@sitemap');
    Route::get('/links', 'OtherController@links');
    Route::get('/contact', 'OtherController@contact');
    Route::post('/email', 'OtherController@email');

});
/*Auth::routes();

Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/auth/matches', 'Auth\MatchController@index');

});*/

// Admin CMS Routes
if (config('app.admin')) {

    Route::group(['middleware' => ['web','auth']], function () {
        Route::get('/admin', 'Admin\AdminController@index');

        Route::get('/admin/matches', 'Admin\MatchController@matches');
        Route::get('/admin/fixture/{id?}', 'Admin\MatchController@fixture');
        Route::post('/admin/fixture', 'Admin\MatchController@fixtureUpdate');
        Route::get('/admin/match/{id}', 'Admin\MatchController@match');
        Route::get('/admin/match/{id}/basic', 'Admin\MatchController@basic');
        Route::post('/admin/match/basic', 'Admin\MatchController@basicUpdate');
        Route::get('/admin/match/{id}/lineup', 'Admin\MatchController@lineup');
        Route::post('/admin/match/lineup', 'Admin\MatchController@lineupUpdate');
        Route::get('/admin/match/{id}/strips', 'Admin\MatchController@strips');
        Route::post('/admin/match/strips', 'Admin\MatchController@stripsUpdate');
        Route::get('/admin/match/{id}/summary', 'Admin\MatchController@summary');
        Route::post('/admin/match/summary', 'Admin\MatchController@summaryUpdate');
        Route::get('/admin/match/{id}/stats', 'Admin\MatchController@stats');
        Route::post('/admin/match/stats', 'Admin\MatchController@statsUpdate');
        Route::get('/admin/match/{id}/incidents', 'Admin\MatchController@incidents');
        Route::post('/admin/match/incidents', 'Admin\MatchController@incidentsUpdate');
        Route::get('/admin/match/{id}/penalties', 'Admin\MatchController@penalties');
        Route::post('/admin/match/penalties', 'Admin\MatchController@penaltiesUpdate');
        Route::get('/admin/match/{id}/other', 'Admin\MatchController@other');
        Route::post('/admin/match/other', 'Admin\MatchController@otherUpdate');

        Route::get('/admin/ajax/lineup/{id}', 'Admin\MatchController@addLineup');
        Route::get('/admin/ajax/lineup/remove/{id}', 'Admin\MatchController@removeLineup');
        Route::get('/admin/ajax/penalty/{id}', 'Admin\MatchController@addPenalty');
        Route::get('/admin/ajax/penalty/remove/{id}', 'Admin\MatchController@removePenalty');
        Route::get('/admin/ajax/incident/{id}', 'Admin\MatchController@addIncident');
        Route::get('/admin/ajax/incident/remove/{id}', 'Admin\MatchController@removeIncident');

        Route::get('/logout', 'Auth\LoginController@logout');


    });
    Route::auth();

}