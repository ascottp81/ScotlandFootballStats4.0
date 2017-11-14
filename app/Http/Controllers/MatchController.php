<?php

namespace App\Http\Controllers;


use App\Models\Match;
use App\Models\Video;
use Illuminate\Support\Facades\Session;


class MatchController extends Controller
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
	 * @return Response
	 */
	public function index($date, $url)
	{
		// Match Data
		$dateParts = explode("-", $date);
		$matchdate = $dateParts[2] . "-" . $dateParts[1] . "-" . $dateParts[0];
		$match = Match::where('date', $matchdate)->firstOrFail();
		$video = Video::getMiniMatchVideo($match->id);
		$mainVideo = Video::getMatchVideo($match->id);
		
		
		// If no Session variables for match list, default to opponents list
		if (!Session::has('MatchList')) {
			Session::put('MatchListUrl', "/opponents/" . $match->opponent->url);
			Session::put('MatchList', $match->opponent->name);
		}
		
		
		// Meta data
		$metatitle = $match->scoreline . " " . $match->date->format("Y");
		$metadescription = $match->meta_description;

		return view('matchdetails.index', compact('match','video','mainVideo','metatitle','metadescription'));
	}
			
}
