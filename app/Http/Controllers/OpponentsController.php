<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Opponent;
use App\Models\Region;

use Illuminate\Support\Facades\Session;

class OpponentsController extends Controller
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
	 * Display the home page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// Regional Data
		$regions = Region::all();
		
		
		// Countries split by columns
		$british = Opponent::where('region_id', '=', '1');
		$european = Opponent::where('region_id','=', '2');
		$britishCount = $british->count();
		$europeCount = $european->count();
		
		$column1 = ceil(($britishCount + $europeCount + 16) / 2.00) - 16;
		$column2 = ($britishCount + $europeCount) - $column1;
		
		$britishOpponents = $british->orderBy('name','asc')->get();
		$europeOpponents1 = $european->orderBy('name','asc')->limit($column1 - $britishCount)->get();
		$europeOpponents2 = $european->orderBy('name','asc')->limit($column2)->offset($column1 - $britishCount)->get();
		$worldOpponents = Opponent::where('region_id', '=', '3')->orderBy('name','asc')->get();
		
		
		// Meta data
		$metatitle = "Opponents";
		$metadescription = "Matches grouped according to the opponent, plus a head to head record for each opponent past and present.";

		return view('opponents.index', compact('regions','britishOpponents','europeOpponents1','europeOpponents2','worldOpponents','metatitle','metadescription'));
	}
	
	/**
	 * Display the single opponent page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function opponent($url)
	{
		$opponent = Opponent::where('url','=',$url)->firstOrFail();
		
		$matchList = Match::opponentId($opponent->id)->orderBy('date','asc')->get();

		// Match Records
        $match = new Match();
        $matchNumbers = $match->getMatchRecordNumbers(Match::opponentId($opponent->id));
        $homeMatchNumbers = $match->getMatchRecordNumbers(Match::opponentId($opponent->id)->home());
        $awayMatchNumbers = $match->getMatchRecordNumbers(Match::opponentId($opponent->id)->awayNeutral());
        $matchNumbersComp = $match->getMatchRecordNumbers(Match::opponentId($opponent->id)->competitive());
        $homeMatchNumbersComp = $match->getMatchRecordNumbers(Match::opponentId($opponent->id)->competitive()->home());
        $awayMatchNumbersComp = $match->getMatchRecordNumbers(Match::opponentId($opponent->id)->competitive()->awayNeutral());

		
		// Meta data
		$metatitle = "Scotland v " . $opponent->name;
		$metadescription = "Details of Scotland matches against " . $opponent->name . ", including a head to head record.";
		
		
		// Session variables for match list
		Session::put('MatchListUrl', $_SERVER['REQUEST_URI']);
		Session::put('MatchList', $opponent->name);

		return view('opponents.opponent', compact('opponent','matchList','matchNumbers','homeMatchNumbers','awayMatchNumbers','matchNumbersComp','homeMatchNumbersComp','awayMatchNumbersComp','metatitle','metadescription'));
	}
		
}
