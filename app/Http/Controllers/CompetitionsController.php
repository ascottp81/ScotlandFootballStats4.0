<?php

namespace App\Http\Controllers;

use App\Models\Appearance;
use App\Models\Club;
use App\Models\Competition;
use App\Models\CompetitionTable;
use App\Models\CompetitionType;
use App\Models\Manager;
use App\Models\Match;
use App\Models\Player;
use App\Models\TableResult;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $table = CompetitionTable::where('competition_id', '=', $competition->id);

            // if there is no table
            if ($table->count() == 0) {

                // Meta data
                $metatitle = $competitionType->title;
                $metadescription = "Details of every " . $competitionType->title . " that the Scottish international football team has taken part in.";

                return view('competitions.index.notable', compact('competitionType', 'competition', 'matches', 'metatitle', 'metadescription'));
            }
            // if there is a table
            else {

                $table = $table->firstOrFail();

                // Table Results columns
                $rounds = TableResult::where('competition_table_id', '=', $table->id)->orderBy('match_date', 'desc')->first();
                if ($rounds)
                    $columnSize = ceil($rounds->match_round / 3.00);
                else
                    $columnSize = 0;

                $tableResults1 = TableResult::where('competition_table_id', '=', $table->id)->whereBetween('match_round', [1, (1 * $columnSize)])->orderBy('match_date', 'asc')->orderBy('id', 'asc')->get();
                $tableResults2 = TableResult::where('competition_table_id', '=', $table->id)->whereBetween('match_round', [(1 * $columnSize) + 1, (2 * $columnSize)])->orderBy('match_date', 'asc')->orderBy('id', 'asc')->get();
                $tableResults3 = TableResult::where('competition_table_id', '=', $table->id)->whereBetween('match_round', [(2 * $columnSize) + 1, (3 * $columnSize)])->orderBy('match_date', 'asc')->orderBy('id', 'asc')->get();


                // Meta data
                $metatitle = $competitionType->title;
                $metadescription = "Details of every " . $competitionType->title . " that the Scottish international football team has taken part in.";

                return view('competitions.index.singletable', compact('competitionType', 'competition', 'matches', 'table', 'tableResults1', 'tableResults2', 'tableResults3', 'metatitle', 'metadescription'));
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

        // Table data
        $table = CompetitionTable::where('competition_id','=',$competition->id)->firstOrFail();

        // Table Results columns
        $rounds = TableResult::where('competition_table_id','=',$table->id)->orderBy('match_date','desc')->first();
        if ($rounds)
            $columnSize = ceil($rounds->match_round / 3.00);
        else
            $columnSize = 0;

        $tableResults1 = TableResult::where('competition_table_id','=',$table->id)->whereBetween('match_round', [1, (1 * $columnSize)])->orderBy('match_date','asc')->orderBy('id','asc')->get();
        $tableResults2 = TableResult::where('competition_table_id','=',$table->id)->whereBetween('match_round', [(1 * $columnSize) + 1, (2 * $columnSize)])->orderBy('match_date','asc')->orderBy('id','asc')->get();
        $tableResults3 = TableResult::where('competition_table_id','=',$table->id)->whereBetween('match_round', [(2 * $columnSize) + 1, (3 * $columnSize)])->orderBy('match_date','asc')->orderBy('id','asc')->get();


        // Scotland Games
        $games = Game::where('competition_id','=',$competition->id)->orWhere('other_competition_id','=',$competition->id)->orderBy('match_date','asc')->get();

        $playoffs = Game::join('competitions','games.competition_id','=','competitions.id')
            ->select('games.*')
            ->where('competition_type_id','=',$competitionType->id)
            ->where('year','=',$competition->year)
            ->where('stage','=',$competition->stage)
            ->where('competition_id','<>',$competition->id)
            ->orderBy('match_date','asc');

        // Video
        $video = Video::getCompetitionVideo($competition->id);

        // Meta data
        $metatitle = $competitionType->title . " " . $competition->year . " " . $competition->stage;
        $metadescription = "Details of Scotland's participation in " . $metatitle . ", including match details and group tables.";

        // Session variables for match list
        Session::put('MatchListUrl', $_SERVER['REQUEST_URI']);
        Session::put('MatchList', $competition->name);

        return view('competitions/competition', compact('competition','competitionType','table','tableResults1','tableResults2','tableResults3','games','playoffs','video','metatitle','metadescription'));
    }
}
