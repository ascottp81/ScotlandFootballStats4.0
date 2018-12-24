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


// Admin CMS Routes
if (config('app.admin')) {

    Route::group(['middleware' => ['web','auth']], function () {

        Route::group(['prefix' => 'admin'], function () {

            Route::get('/', 'Admin\AdminController@index');

            Route::get('/matches', 'Admin\MatchController@matches');
            Route::get('/fixture/{id?}', 'Admin\MatchController@fixture');
            Route::post('/fixture', 'Admin\MatchController@fixtureUpdate');
            Route::get('/match/{id}', 'Admin\MatchController@match');
            Route::get('/match/{id}/basic', 'Admin\MatchController@basic');
            Route::post('/match/basic', 'Admin\MatchController@basicUpdate');
            Route::get('/match/{id}/lineup', 'Admin\MatchController@lineup');
            Route::post('/match/lineup', 'Admin\MatchController@lineupUpdate');
            Route::get('/match/{id}/strips', 'Admin\MatchController@strips');
            Route::post('/match/strips', 'Admin\MatchController@stripsUpdate');
            Route::get('/match/{id}/summary', 'Admin\MatchController@summary');
            Route::post('/match/summary', 'Admin\MatchController@summaryUpdate');
            Route::get('/match/{id}/stats', 'Admin\MatchController@stats');
            Route::post('/match/stats', 'Admin\MatchController@statsUpdate');
            Route::get('/match/{id}/incidents', 'Admin\MatchController@incidents');
            Route::post('/match/incidents', 'Admin\MatchController@incidentsUpdate');
            Route::get('/match/{id}/penalties', 'Admin\MatchController@penalties');
            Route::post('/match/penalties', 'Admin\MatchController@penaltiesUpdate');
            Route::get('/match/{id}/other', 'Admin\MatchController@other');
            Route::post('/match/other', 'Admin\MatchController@otherUpdate');

            Route::get('/ajax/lineup/{id}', 'Admin\MatchController@addLineup');
            Route::get('/ajax/lineup/remove/{id}', 'Admin\MatchController@removeLineup');
            Route::get('/ajax/penalty/{id}', 'Admin\MatchController@addPenalty');
            Route::get('/ajax/penalty/remove/{id}', 'Admin\MatchController@removePenalty');
            Route::get('/ajax/incident/{id}', 'Admin\MatchController@addIncident');
            Route::get('/ajax/incident/remove/{id}', 'Admin\MatchController@removeIncident');


            Route::get('/players', 'Admin\PlayerController@index');
            Route::get('/player/{id?}', 'Admin\PlayerController@player');
            Route::post('/player', 'Admin\PlayerController@playerUpdate');


            Route::get('/rankings/{id?}', 'Admin\RankingController@index');
            Route::post('/ranking', 'Admin\RankingController@update');


            Route::get('/news', 'Admin\NewsController@index');
            Route::get('/news/article/{id?}', 'Admin\NewsController@article');
            Route::post('/news', 'Admin\NewsController@update');
            Route::get('/news/delete/{id}', 'Admin\NewsController@delete');


            Route::get('/competitions/{id?}', 'Admin\CompetitionController@index')->where('id', '[0-9]+');
            Route::post('/competition', 'Admin\CompetitionController@competitionTypeUpdate');
            Route::get('/competitions/{url}/{id?}', 'Admin\CompetitionController@competition')->where('id', '[0-9]+');
            Route::post('/competition-version', 'Admin\CompetitionController@competitionUpdate');
            Route::get('/competitions/{competitionid}/table/{id?}', 'Admin\CompetitionController@table');
            Route::post('/competition-table', 'Admin\CompetitionController@tableUpdate');
            Route::get('/competitions/{competitionid}/table/{tableid}/results/{id?}', 'Admin\CompetitionController@result');
            Route::post('/competition-result', 'Admin\CompetitionController@resultUpdate');

            Route::get('/ajax/table', 'Admin\CompetitionController@ajax_table');
            Route::get('/ajax/table/remove/{id}', 'Admin\CompetitionController@ajax_tableRemove');
            Route::get('/ajax/table/position/{id}', 'Admin\CompetitionController@ajax_tablePosition');


            Route::get('/history/{id?}', 'Admin\HistoryController@index')->where('id', '[0-9]+');
            Route::post('/history', 'Admin\HistoryController@historyUpdate');
            Route::get('/history/{url}', 'Admin\HistoryController@pageIndex');
            Route::get('/history/{url}/add', 'Admin\HistoryController@pageAdd');
            Route::get('/history/page/{id}', 'Admin\HistoryController@page')->where('id', '[0-9]+');
            Route::post('/history/page', 'Admin\HistoryController@pageUpdate');


            Route::get('/managers', 'Admin\ManagerController@index');
            Route::get('/manager/{id?}', 'Admin\ManagerController@manager')->where('id', '[0-9]+');
            Route::post('/manager', 'Admin\ManagerController@managerUpdate');
        });

        Route::get('/logout', 'Auth\LoginController@logout');


    });
    Route::auth();

}