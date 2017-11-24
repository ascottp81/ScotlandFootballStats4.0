<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\CompetitionTable;
use App\Models\CompetitionType;
use App\Models\Match;
use App\Models\Video;

use Illuminate\Support\Facades\Session;

class CompetitionsController extends Controller
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
     * Display the competitions index page.
     *
     * @return Response
     */
    public function index()
    {
        $competitive = CompetitionType::where('status','=','C')->orderBy('priority','asc')->get();
        $friendly = CompetitionType::where('status','=','F')->where('title','<>','Friendly')->orderBy('priority','asc')->get();

        $video = Video::getCompetitionsVideo();


        // Meta data
        $metatitle = "Competitions";
        $metadescription = "Details of every competition that the Scottish international football team has taken part in.";

        return view('competitions.index', compact('competitive','friendly','video','metatitle','metadescription'));
    }

    /**
     * Display the competition honours page.
     *
     * @return Response
     */
    public function honours()
    {
        // Get every competition type that has an honour
        $honourTypes = CompetitionType::orderBy('priority','asc')->get();

        // Meta data
        $metatitle = "Honours";
        $metadescription = "Details of every competition that the Scottish international football team has won or qualified for.";

        return view('competitions.honours', compact('honourTypes','metatitle','metadescription'));
    }

    /**
     * Display the competition type index page.
     *
     * @return Response
     */
    public function competitionindex($url)
    {
        // competition type
        $competitionType = CompetitionType::where('url','=',$url)->firstOrFail();


        // There are multiple competitions
        if ($competitionType->competitions()->count() > 1) {

            // competitions
            $competitions = $competitionType->competitions()
                ->orderBy('year','asc')
                ->orderBy('stage','desc')
                ->get();

            // Match Numbers
            $matchNumbers = $competitionType->match_numbers;

            // Video
            $video = Video::getCompetitionTypeVideo($competitionType->id);


            // Meta data
            $metatitle = $competitionType->title;
            $metadescription = "Details of every " . $competitionType->title . " that the Scottish international football team has taken part in.";

            return view('competitions.index.multiple', compact('competitionType', 'competitions', 'matchNumbers', 'video', 'metatitle', 'metadescription'));
        }
        // There is a single competition
        else {

            // competition
            $competition = $competitionType->competitions()->firstOrFail();

            // Scotland Games
            $matches = Match::where('competition_id', '=', $competition->id)->orWhere('other_competition_id', '=', $competition->id)->orderBy('date', 'asc')->get();

            // Table data
            $tables = CompetitionTable::join('competitionrounds', 'competitiontables.round_id', '=', 'competitionrounds.id')
                ->where('competition_id','=',$competition->id)
                ->orderBy('competitionrounds.order', 'asc')
                ->select('competitiontables.*');


            // if there is no table
            if ($tables->count() == 0) {

                // Meta data
                $metatitle = $competitionType->title;
                $metadescription = "Details of every " . $competitionType->title . " that the Scottish international football team has taken part in.";

                return view('competitions.index.notable', compact('competitionType', 'competition', 'matches', 'metatitle', 'metadescription'));
            }
            // if there is a table
            else {

                $tables = $tables->get();

                // Meta data
                $metatitle = $competitionType->title;
                $metadescription = "Details of every " . $competitionType->title . " that the Scottish international football team has taken part in.";

                return view('competitions.index.singletable', compact('competitionType', 'competition', 'matches', 'tables', 'metatitle', 'metadescription'));
            }
        }
    }

    /**
     * Display the competition page.
     *
     * @return Response
     */
    public function competition($type_url, $url)
    {
        // competition type
        $competitionType = CompetitionType::where('url','=',$type_url)->firstOrFail();

        // competitions
        $url_segments = explode("-", $url);
        if (sizeof($url_segments) > 1) {
            $competition = Competition::where('competition_type_id','=',$competitionType->id)
                ->where('year','=',$url_segments[0])
                ->where('stage','=',ucwords($url_segments[1]))
                ->firstOrFail();
        }
        else {
            $competition = Competition::where('competition_type_id','=',$competitionType->id)
                ->where('year','=',$url)
                ->firstOrFail();
        }

        // Scotland Games
        $matches = Match::where('competition_id', '=', $competition->id)->orWhere('other_competition_id', '=', $competition->id)->orderBy('date', 'asc')->get();


        // Session variables for match list
        Session::put('MatchListUrl', $_SERVER['REQUEST_URI']);
        Session::put('MatchList', $competition->name);


        // Table data
        $tables = CompetitionTable::join('competitionrounds', 'competitiontables.round_id', '=', 'competitionrounds.id')
            ->where('competition_id','=',$competition->id)
            ->orderBy('competitionrounds.order', 'asc')
            ->select('competitiontables.*');


        // if there is no table
        if ($tables->count() == 0) {

            // Meta data
            $metatitle = $competitionType->title . " " . $competition->year . " " . $competition->stage;
            $metadescription = "Details of Scotland's participation in " . $metatitle . ".";

            return view('competitions.notable', compact('competitionType', 'competition', 'matches', 'metatitle', 'metadescription'));
        }
        // if there is a table
        else {
            $tables = $tables->get();

            // Video
            $video = Video::getCompetitionVideo($competition->id);

            // Meta data
            $metatitle = $competitionType->title . " " . $competition->year . " " . $competition->stage;
            $metadescription = "Details of Scotland's participation in " . $metatitle . ", including match details and group tables.";


            return view('competitions.competition', compact('competition', 'competitionType', 'tables', 'matches', 'video', 'metatitle', 'metadescription'));
        }
    }
}
