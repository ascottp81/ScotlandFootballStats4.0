<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\CompetitionType;
use App\Models\ExternalLink;
use App\Models\History;
use App\Models\Opponent;
use App\Models\Manager;
use App\Models\Player;
use App\Models\Strip;

use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class OtherController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
    }

    /**
     * Show the sitemap page
     *
     * @return \Illuminate\Http\Response
     */
    public function sitemap()
    {
		$opponents = Opponent::orderBy('name','asc')->get();
		$players = Player::orderBy('surname','asc')->orderBy('firstname','asc')->orderBy('debut_year','asc')->get();
		$competitionTypes = CompetitionType::where('title','<>','Friendly')->orderBy('priority','asc')->get();
		
		$managers = Manager::join('matches','matches.manager_id','=','managers.id')
			->select('managers.*', DB::Raw('MIN(date) AS min_date'))
			->groupBy('manager_id')
			->orderBy('min_date','asc')
			->get();
			
		$chapters = History::orderBy('first_year','asc')->get();
		$strips = Strip::orderBy('year_from','asc')->orderBy('id','asc')->get();
								 
		// Meta data
		$metatitle = "Match and Player Stats, Competition Details, Scotland International Football Team";
		$metadescription = "Statistics for Scottish International Football, which includes in-depth Match and Player Stats, Competition Details, FIFA Rankings, and a Brief History.";
		
		
		// Session variables for match list
		Session::put('MatchListUrl', '/sitemap');
		Session::put('MatchList', "Sitemap");
		
        return view('other.sitemap', compact('opponents','players','competitionTypes','managers','chapters','strips','metatitle','metadescription'));
    }
	
    /**
     * Show the links page
     *
     * @return \Illuminate\Http\Response
     */
    public function links()
    {
		$officialLinks = ExternalLink::where('type','=','official')->orderBy('list_order','asc')->get();
		$featuredLinks = ExternalLink::where('type','=','featured')->orderBy('list_order','asc')->get();
		$otherLinks = ExternalLink::where('type','=','other')->orderBy('list_order','asc')->get();
								 
		// Meta data
		$metatitle = "External Links";
		$metadescription = "Statistics for Scottish International Football, which includes in-depth Match and Player Stats, Competition Details, FIFA Rankings, and a Brief History.";
		
		
        return view('other.links', compact('officialLinks','featuredLinks','otherLinks','metatitle','metadescription'));
    }

}
