<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CompetitionTable;
use App\Models\Match;
use App\Models\News;
use App\Models\Opponent;
use App\Models\PastEvent;
use App\Models\Player;
use App\Models\Video;

use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the home page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$recentResults = Match::recent()->limit(2)->get();
		$fixtures = Match::fixtures()->limit(2)->get();
		$news = News::recent()->limit(5)->get();
		$video = Video::getHomeVideo();
        $videoDimensions = ["width" => "270px", "height" => "200px"];
		$articles = Article::all();
		
		// Match Search opponents
		$opponents = Opponent::orderBy('name')->get();
		
		// Home Table
		$homeTable = CompetitionTable::home()->firstOrFail();
										   

		// On this day
        $events = new PastEvent();
		$events = $events->getTodayEvents();

								 
		// Meta data
		$metatitle = "Match and Player Stats, Competition Details, Scotland International Football Team";
		$metadescription = "Statistics for Scottish International Football, which includes in-depth Match and Player Stats, Competition Details, FIFA Rankings, and a Brief History.";
		
		
		// Session variables for match list
		Session::put('MatchListUrl', '/recent-results');
		Session::put('MatchList', "Recent Results");
		
        return view('home.index', compact('opponents','articles','news','video','videoDimensions','recentResults','fixtures','homeTable','events','metatitle','metadescription'));
    }


    /**
     * Show the recent results page
     *
     * @return \Illuminate\Http\Response
     */
    public function recentresults()
    {
        // Recent Result Matches
        $recentResults = Match::recent()->get();

        // Get match numbers for recent results
        $match = new Match();
        $matchNumbers = $match->getMatchRecordNumbers(Match::recent());

        // Recent Results Player Stats
        $player = new Player();
        $topScorers = $player->getRecentTopScorers();
        $topAppearances = $player->getRecentTopAppearances();

        // Match Search opponents
        $opponents = Opponent::orderBy('name')->get();

        // Article Links
        $articles = Article::all();

        // Meta data
        $metatitle = "Recent Results";
        $metadescription = "Details of Scotland's games from the last three years.";

        // Session variables for match list
        Session::put('MatchListUrl', '/recent-results/');
        Session::put('MatchList', "Recent Results");

        return view('home.recentresults', compact('recentResults','topScorers','topAppearances','matchNumbers','opponents','articles','metatitle','metadescription'));
    }


    /**
     * Show the fixtures page
     *
     * @return \Illuminate\Http\Response
     */
    public function fixtures()
    {
        $fixtures = Match::fixtures()->get();

        // Meta data
        $metatitle = "Fixtures";
        $metadescription = "Details of Scotland's forthcoming fixtures in International Football.";

        return view('home.fixtures', compact('fixtures','metatitle','metadescription'));
    }


    /**
     * Show the latest news page
     *
     * @return \Illuminate\Http\Response
     */
    public function latestnews()
    {
        $news = News::recent()->get();
        $squad = News::where('type','=','Squad')->orderBy('date','desc')->firstOrFail();

        // Match Search opponents
        $opponents = Opponent::orderBy('name')->get();


        // On this day
        $events = new PastEvent();
        $events = $events->getTodayEvents();


        // Meta data
        $metatitle = "Latest News";
        $metadescription = "Scotland's Latest News Headlines and Squad Details in International Football";

        return view('home.latestnews', compact('news','squad','opponents','events','metatitle','metadescription'));
    }


    /**
     * Show the article page
     *
     * @return \Illuminate\Http\Response
     */
    public function article($url)
    {
        $article = Article::where('url','=',$url)->firstOrFail();
        $articles = Article::all();

        // Match Search opponents
        $opponents = Opponent::orderBy('name')->get();

        // Home Table
        $homeTable = CompetitionTable::home()->firstOrFail();


        // On this day
        $events = new PastEvent();
        $events = $events->getTodayEvents();


        // Meta data
        $metatitle = $article->title;
        $metadescription = strip_tags($article->content);


        return view('home.article', compact('opponents','article','articles','homeTable','events','metatitle','metadescription'));
    }


    /**
     * Show the match search page
     *
     * @param string $parameters
     * @return \Illuminate\Http\Response
     */
    public function matchsearch(string $parameters)
    {
        $searchResults = Match::search($parameters)->orderBy("date")->get();


        // Match Numbers
        $match = new Match();
        $matchNumbers = $match->getMatchRecordNumbers(Match::search($parameters));

        // Search Parameters
        $searchParameters = $match->getSearchParameters($parameters);


        // Search form
        $opponents = Opponent::orderBy('name')->get();


        // Meta data
        $metatitle = "Match Search Results";
        $metadescription = "Details of the games that match your search parameters.";

        // Session variables for match list
        Session::put('MatchListUrl', '/match-search/' . $parameters);
        Session::put('MatchList', "Match Search Results");

        return view('home.matchsearch', compact('searchResults','searchParameters','parameters','matchNumbers','opponents','metatitle','metadescription'));
    }
}
