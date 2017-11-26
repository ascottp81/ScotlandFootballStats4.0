<?php

namespace App\Http\Controllers;

use App\Models\Strip;
use App\Models\StripMatch;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;

class StripsController extends Controller
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
	 * Display the strip index page.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$home = Strip::home()->orderBy('year_from','asc')->orderBy('id','asc')->get();
		$away = Strip::awayThird()->orderBy('year_from','asc')->orderBy('id','asc')->get();
		
		// Meta data
		$metatitle = "Strips";
		$metadescription = "Details of every strip that Scotland has worn post-war.";

		return view('strips.index', compact('home','away','metatitle','metadescription'));
	}
	
	/**
	 * Display the Strip details page.
	 *
	 * @return Response
	 */
	public function strip($url)
	{	
		$strip = Strip::where(DB::Raw("LOWER(CONCAT(type, '-', year_from))"),'=',$url)->firstOrFail();
			
		// Video
		$video = Video::getStripVideo($strip->id);
		
		
		// Meta data
		$metatitle = $strip->title;
		$metadescription = "Details of every match where the " . $metatitle . " strip was worn.";
		
		// Session variables for match list
		Session::put('MatchListUrl', $_SERVER['REQUEST_URI']);
		Session::put('MatchList', $metatitle);

		return view('strips.strip', compact('strip','video','metatitle','metadescription'));
	}	
	

	/**
	 * Ajax to to view match list tooltip.
	 *
	 * @return Response
	 */
	public function matchtooltip($id)
	{
		$note = StripMatch::where('match_id','=',$id)->firstOrFail()->match_note;
		$type = "strip";
		
		return view('partial.tooltip', compact('note','type'));
	}


		
}
