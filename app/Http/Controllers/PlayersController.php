<?php

namespace App\Http\Controllers;

use App\Models\Appearance;
use App\Models\Club;
use App\Models\Manager;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PlayersController extends Controller
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
     * Display the player index page.
     *
     * @return Response
     */
    public function index()
    {
        // Player Search
        $managers = Manager::orderBy('id')->get();
        $clubs = Club::orderBy('name')->get();

        // Meta data
        $metatitle = "Players";
        $metadescription = "Details of every player who has represented Scotland at international level.";

        return view('players.index', compact('managers','clubs','metatitle','metadescription'));
    }

    /**
     * Display the player a-z page.
     *
     * @return Response
     */
    public function az()
    {
        $players = Player::all();

        // Player Search
        $managers = Manager::orderBy('id')->get();
        $clubs = Club::orderBy('name')->get();

        // Meta data
        $metatitle = "Players A-Z";
        $metadescription = "An A-Z of every player who has played for Scotland, including in-depth details of every player and match that they played in.";

        // Session variables for match list
        Session::put('PlayerListUrl', "a-z");
        Session::put('PlayerList', "Players A-Z");

        return view('players.az', compact('players','managers','clubs','metatitle','metadescription'));
    }

    /**
     * Display the SFA Hall of Fame page.
     *
     * @return Response
     */
    public function sfahalloffame()
    {
        $players = Player::join('appearances', 'players.id','=','appearances.player_id')
            ->select('players.*', DB::Raw('COUNT(*) as caps'))
            ->groupBy('players.id')
            ->having('caps','>=',50)
            ->get();

        // Player Search
        $managers = Manager::orderBy('id')->get();
        $clubs = Club::orderBy('name')->get();

        // Meta data
        $metatitle = "SFA Hall Of Fame";
        $metadescription = "Details of Scotland's SFA Hall Of Fame. This includes details of the players and match details of their international appearances.";

        // Session variables for match list
        Session::put('PlayerListUrl', "sfa-hall-of-fame");
        Session::put('PlayerList', "SFA Hall Of Fame");

        return view('players.sfahalloffame', compact('players','managers','clubs','metatitle','metadescription'));
    }

    /**
     * Display the Silver Caps page.
     *
     * @return Response
     */
    public function silvercaps()
    {
        $players = Player::join('appearances', 'players.id','=','appearances.player_id')
            ->select('players.*', DB::Raw('COUNT(*) as caps'))
            ->groupBy('players.id')
            ->having('caps','>=',25)
            ->having('caps','<',50)
            ->get();

        // Player Search
        $managers = Manager::orderBy('id')->get();
        $clubs = Club::orderBy('name')->get();

        // Meta data
        $metatitle = "Silver Caps (25-49)";
        $metadescription = "Details of Scotland's Silver Caps (25-49). This includes details of the players and match details of their international appearances.";

        // Session variables for match list
        Session::put('PlayerListUrl', "silver-caps");
        Session::put('PlayerList', "Silver Caps (25-49)");

        return view('players.silvercaps', compact('players','managers','clubs','metatitle','metadescription'));
    }

    /**
     * Display the Leading goalscorers page.
     *
     * @return Response
     */
    public function leadinggoalscorers()
    {
        $players = Player::join('appearances', 'players.id','=','appearances.player_id')
            ->select('players.*', DB::Raw('SUM(goals) as goals'))
            ->groupBy('players.id')
            ->having('goals','>=',5)
            ->get();

        // Player Search
        $managers = Manager::orderBy('id')->get();
        $clubs = Club::orderBy('name')->get();

        // Meta data
        $metatitle = "Leading Goalscorers";
        $metadescription = "Details of Scotland's leading goalscorers. This includes details of the players and match details of their international appearances.";

        // Session variables for match list
        Session::put('PlayerListUrl', "leading-goalscorers");
        Session::put('PlayerList', "Leading Goalscorers");

        return view('players.leadinggoalscorers', compact('players','managers','clubs','metatitle','metadescription'));
    }

    /**
     * Display the Current Players page.
     *
     * @return Response
     */
    public function currentplayers()
    {
        $players = Player::where('retired','=',0)->get();

        // Player Search
        $managers = Manager::orderBy('id')->get();
        $clubs = Club::orderBy('name')->get();

        // Meta data
        $metatitle = "Current Players";
        $metadescription = "Details of Scotland's current players. This includes details of the players and match details of their international appearances.";

        // Session variables for match list
        Session::put('PlayerListUrl', "current-players");
        Session::put('PlayerList', "Current Players");

        return view('players.currentplayers', compact('players','managers','clubs','metatitle','metadescription'));
    }


    /**
     * Display the Player Search Results page.
     *
     * @return Response
     */
    public function searchresults($parameters)
    {
        // Search Parameters
        $parameterSet = explode("&", $parameters);

        $name = "-";
        $dateFrom = "-";
        $dateTo = "-";
        $manager = "-";
        $club = "-";
        $filtered = false;

        $club_id = "";
        $manager_id = "";

        foreach ($parameterSet as $parameterItem) {
            $parametervalues = explode("=", $parameterItem);

            if ($parametervalues[0] == "stats") {
                $filtered = ($parametervalues[1] == "filtered") ? true : false;
            }
            if ($parametervalues[0] == "name") {
                $name = $parametervalues[1];
            }
            if ($parametervalues[0] == "datefrom") {
                $dateFrom = date('jS F Y', strtotime($parametervalues[1]));
            }
            if ($parametervalues[0] == "dateto") {
                $dateTo = date('jS F Y', strtotime($parametervalues[1]));
            }
            if ($parametervalues[0] == "manager") {
                $manager = Manager::where('id','=',$parametervalues[1])->firstOrFail()->fullname;
                $manager_id = $parametervalues[1];
            }
            if ($parametervalues[0] == "club") {
                $club = Club::where('id','=',$parametervalues[1])->firstOrFail()->name;
                $club_id = $parametervalues[1];
            }
        }

        $searchParameters = array(
            'name' => $name,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'manager' => $manager,
            'club' => $club
        );

        $url = $parameters;
        $parameters = str_replace("stats=filtered&", "", $parameters);


        // Player Search Records

        // Get Filtered Stats
        $players = Player::join('appearances', 'players.id','=','appearances.player_id')
            ->join('matches','matches.id','=','appearances.match_id')
            ->select('players.*', DB::Raw('COUNT(*) as filtered_caps'), DB::Raw('SUM(goals) as filtered_goals'), DB::Raw('YEAR(MIN(date)) as filtered_first_year'), DB::Raw('YEAR(MAX(date)) as filtered_last_year'));

        if ($name != "-") {
            $players = $players->where(function ($q) use ($name) {
                $q->where('surname','like', '%' . $name . '%')->orWhere('firstname','like', '%' . $name . '%');
            });
        }
        if ($dateFrom != "-") {
            $players = $players->where('date','>=',date('Y-m-d', strtotime($dateFrom)));
        }
        if ($dateTo != "-") {
            $players = $players->where('date','<=',date('Y-m-d', strtotime($dateTo)));
        }
        if ($manager_id != "") {
            $players = $players->where('manager_id','=',$manager_id);
        }
        if ($club_id != "") {
            $players = $players->where('club_id','=',$club_id);
        }
        $players = $players->groupBy('players.id');

        // get array of player ids
        $playerIds = $players->pluck('players.id')->toArray();

        $players = $players->get();


        // Get Complete Stats using player ids from Filtered Stats
        if (!$filtered) {
            $players = Player::join('appearances', 'players.id','=','appearances.player_id')
                ->join('matches','matches.id','=','appearances.match_id')
                ->select('players.*')
                ->whereIn('players.id', $playerIds)
                ->groupBy('players.id')
                ->get();
        }


        // Player Search
        $managers = Manager::orderBy('id')->get();
        $clubs = Club::orderBy('name')->get();

        // Meta data
        $metatitle = "Player Search Results";
        $metadescription = "Details of the players that match your search parameters.";

        // Session variables for match list
        Session::put('PlayerListUrl', str_replace("/players/", "", $_SERVER['REQUEST_URI']));
        Session::put('PlayerList', "Search Results");

        return view('players.searchresults', compact('players','filtered','parameters','searchParameters','url','managers','clubs','metatitle','metadescription'));
    }


    /**
     * Display the Player details page.
     *
     * @return Response
     */
    public function player($id, $url)
    {
        $player = Player::find($id);

        // Meta data
        $metatitle = $player->fullname;
        $metadescription = "Details of " . $metatitle . "'s Appearances for Scotland.";

        // Session variables for match list
        Session::put('MatchListUrl', $_SERVER['REQUEST_URI']);
        Session::put('MatchList', $player->fullname);

        return view('players.player', compact('player','metatitle','metadescription'));
    }

    /**
     * Ajax to to view player stats tooltip.
     *
     * @return Response
     */
    public function tooltip($type, $player_id)
    {
        $player = Player::find($player_id);

        return view('partial.tooltip', compact('player','type'));
    }

    /**
     * Ajax to to view player appearance match list tooltip.
     *
     * @return Response
     */
    public function matchtooltip($appearance_id)
    {
        $type = "player-matches";
        $player = Appearance::find($appearance_id);
        $substitutions = Appearance::where('match_id','=',$player->match_id)->where('replaced','=',$player->shirt_no)->count();

        return view('partial.tooltip', compact('type','player','substitutions'));
    }

}
