<?php
declare(strict_types=1);
namespace App\Classes;


use App\Models\CompetitionTable;
use App\Models\Manager;
use App\Models\Match;
use App\Models\News;
use App\Models\Opponent;
use App\Models\Player;
use App\Models\TableResult;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Api
{
    private $_col;
    private $_order;

    /**
     * Create an Api object
     *
     */
    public function __construct()
    {
    }

    /**
     * List all of the recent matches
     *
     * @return array
     */
    public function recentMatches(): array
    {
        $col = $_GET['col'] ?? 'date';
        $order = $_GET['order'] ?? 'desc';
        $matches = Match::where('date', '>=', Carbon::now()->addYears(-3))->whereNotNull('result')->orderBy($col,$order)->get();

        $matchData = array();
        foreach ($matches as $match) {

            $singleMatch = [
                "id" => $match->id,
                "date" => $match->date->format("d/m/Y"),
                "result" => $match->short_scoreline,
                "competition" => $match->competition->name
            ];

            $matchData[] = $singleMatch;
        }

        return [
            "matches" => $matchData
        ];
    }

    /**
     * List all of the opponents who have played
     *
     * @param string $os
     * @return array
     */
    public function opponentPlayed(string $os = 'ios'): array
    {
        $opponents = Opponent::orderBy('name','asc')->get(['id', 'name', 'abbr_name']);

        $opponentData = array();
        foreach ($opponents as $opponent) {

            $matches = Opponent::findOrFail($opponent->id)->matches()->whereNotNull('result')->count();

            if ($matches > 0) {

                $singleOpponent = [
                    "id" => $opponent->id,
                    "name" => $opponent->name,
                    "abbr_name" => $opponent->abbr_name,
                    "count" => $matches
                ];

                $opponentData[] = $singleOpponent;
            }
        }

        if ($os == 'ios') {
            return $opponentData;
        }
        else {
            return [
                "opponents" => $opponentData
            ];
        }

    }

    /**
     * List all of the fixtures
     *
     * @return array
     */
    public function fixtures(): array
    {
        $col = $_GET['col'] ?? 'date';
        $order = $_GET['order'] ?? 'asc';
        $matches = Match::whereNull('result')->orderBy($col,$order)->get();

        $matchData = array();
        foreach ($matches as $match) {

            $singleMatch = [
                "date" => $match->date->format("d/m/Y"),
                "kickoff" => "Kick-off: " . $match->kickoff,
                "fixture" => $match->short_fixture,
                "competition" => $match->competition->name,
                "round" => ($match->competitionRound->name != "None")? $match->competitionRound->name : ""
            ];

            $matchData[] = $singleMatch;
        }

        return [
            "matches" => $matchData
        ];
    }

    /**
     * List all of the search results
     *
     * @param string $parameters
     * @return array
     */
    public function searchResults(string $parameters): array
    {
        $col = $_GET['col'] ?? 'date';
        $order = $_GET['order'] ?? 'asc';
        $matches = Match::search($parameters)->orderBy($col, $order)->get();

        $matchData = array();
        foreach ($matches as $match) {

            $singleMatch = [
                "id" => $match->id,
                "date" => $match->date->format("d/m/Y"),
                "result" => $match->short_scoreline,
                "competition" => $match->competition->name
            ];

            $matchData[] = $singleMatch;
        }

        return [
            "matches" => $matchData
        ];
    }

    /**
     * Get specified news article
     *
     * @param int $articleId
     * @return array
     */
    public function newsArticle(int $articleId): array
    {
        $news = News::find($articleId);

        $data = [
            "title" => $news->title,
            "date" => $news->date->format('j F Y'),
            "content" => $news->content
        ];

        return $data;
    }

    /**
     * List all of the matches against specified opponent
     *
     * @param int $opponentId
     * @return array
     */
    public function opponentMatches(int $opponentId): array
    {
        $col = $_GET['col'] ?? 'date';
        $order = $_GET['order'] ?? 'asc';
        $matches = Opponent::findOrFail($opponentId)->matches()->orderBy($col,$order)->get();

        $matchData = array();
        foreach ($matches as $match) {

            $singleMatch = [
                "id" => $match->id,
                "date" => $match->date->format("d/m/Y"),
                "result" => $match->result,
                "venue" => substr($match->ha, 0, 1),
                "competition" => $match->competition->name,
                "round" => ($match->competitionRound->name != "None")? $match->competitionRound->name : ""
            ];

            if ($match->result != null) {
                $matchData[] = $singleMatch;
            }
        }

        return [
            "matches" => $matchData
        ];
    }

    /**
     * get match details
     *
     * @param int $matchId
     * @return array
     */
    public function match(int $matchId): array
    {
        $match = Match::findOrFail($matchId);

        $competitions = array();
        $competitions[] = $match->competition->name;
        if ($match->other_competition_id > 0) {
            $competitions[] = $match->otherCompetition->name;
        }

        return [
            "id" => $match->id,
            "date" => $match->date->format("j F Y"),
            "opponent" => $match->opponent->name,
            "scoreline" => $match->scoreline,
            "venue" => $match->venue_ha,
            "attendance" => $match->attendance,
            "kickoff" => $match->kickoff,
            "competition" => $competitions,
            "round" => ($match->competitionRound->name != "None")? $match->competitionRound->name : "",
            "manager" => $match->manager,
            "scot_scorers" => $match->scot_scorers,
            "opp_scorers" => $match->opp_scorers,
            "scot_team" => $match->scot_team,
            "opp_team" => $match->opp_team
        ];
    }


    /**
     * List all of the players in the specified list
     *
     * @param string $type
     * @param string $letter
     * @return array
     */
    public function players(string $type, string $letter): array
    {
        if ($type == "az") {
            $players = Player::where('surname','like',$letter . '%')->orderBy('surname','asc')->orderBy('firstname','asc')->get();
        }
        elseif ($type == "hof") {
            $players = Player::join('appearances', 'players.id','=','appearances.player_id')
                ->select('players.*', DB::Raw('COUNT(*) as caps'))
                ->groupBy('players.id')
                ->having('caps','>=',50)
                ->orderBy('caps','desc')
                ->orderBy('surname','asc')
                ->orderBy('firstname','asc')
                ->get();
        }
        elseif ($type == "silver") {
            $players = Player::join('appearances', 'players.id','=','appearances.player_id')
                ->select('players.*', DB::Raw('COUNT(*) as caps'))
                ->groupBy('players.id')
                ->having('caps','>=',25)
                ->having('caps','<',50)
                ->orderBy('caps','desc')
                ->orderBy('surname','asc')
                ->orderBy('firstname','asc')
                ->get();
        }
        elseif ($type == "current") {
            $players = Player::where('retired','=',0)->orderBy('surname','asc')->orderBy('firstname','asc')->get();
        }
        elseif ($type == "goalscorers") {
            $players = Player::join('appearances', 'players.id','=','appearances.player_id')
                ->select('players.*', DB::Raw('SUM(goals) as goals'))
                ->groupBy('players.id')
                ->having('goals','>=',5)
                ->orderBy('goals','desc')
                ->orderBy('surname','asc')
                ->orderBy('firstname','asc')
                ->get();
        }
        else {
            $players = Player::where('surname','like','A%')->orderBy('surname','asc')->orderBy('firstname','asc')->get();
        }

        $playerData = array();
        foreach ($players as $player) {

            $singlePlayer = [
                "id" => $player->id,
                "fullname" => $player->fullname,
                "caps" => $player->caps,
                "goals" => $player->goals,
                "years" => $player->years
            ];

            $playerData[] = $singlePlayer;
        }

        return [
            "players" => $playerData
        ];
    }

    /**
     * List all of the player's details
     *
     * @param int $playerId
     * @return array
     */
    public function player(int $playerId): array
    {
        $player = Player::find($playerId);

        $data = [
            "id" => $player->id,
            "fullname" => $player->fullname,
            "caps" => $player->caps,
            "goals" => $player->goals,
            "clean_sheets" => $player->clean_sheets,
            "penalties" => $player->pens,
            "captain" => $player->captain_count,
            "yellow_cards" => $player->yellow_cards,
            "red_cards" => $player->red_cards,
            "keeper" => $player->keeper,
            "years" => $player->years,
            "clubs" => $player->clubs,
            "position" => $player->position,
            "date_of_birth" => $player->date_of_birth->format('j F Y'),
            "birthplace" => $player->birthplace
        ];

        return $data;
    }

    /**
     * List all of the match appearances for a specified player
     *
     * @param int $playerId
     * @return array
     */
    public function playerMatches(int $playerId): array
    {
        $this->_col = $_GET['col'] ?? 'date_sort';
        $this->_order = $_GET['order'] ?? 'asc';
        $appearances = Player::findOrFail($playerId)->appearances()->get();

        $matchData = array();
        foreach ($appearances as $appearance) {

            $singleMatch = [
                "id" => $appearance->match->id,
                "date" => $appearance->match->date->format("d/m/Y"),
                "result" => $appearance->match->short_scoreline,
                "competition" => $appearance->match->competition->name,
                "date_sort" => $appearance->match->date->format("Y-m-d")
            ];

            $matchData[] = $singleMatch;
        }

        // call function to sort array
        usort($matchData, array($this, "sortArray"));

        return [
            "matches" => $matchData
        ];
    }

    /**
     * List all of the match details for a specified competition
     *
     * @param int $competitionId
     * @return array
     */
    public function competitionMatchDetails(int $competitionId): array
    {
        $rounds = Match::where('competition_id', '=', $competitionId)->orWhere('other_competition_id', '=', $competitionId)->groupBy('round_id')->orderBy('date','asc')->get();

        $roundData = array();
        foreach ($rounds as $round) {

            $matches = Match::where('round_id','=',$round->round_id)->where('competition_id', '=', $competitionId)->orWhere('other_competition_id', '=', $competitionId)->orderBy('date', 'asc')->get();

            $matchData = array();
            foreach ($matches as $match) {

                $singleMatch = [
                    "id" => $match->id,
                    "date" => $match->date->format("d/m/Y"),
                    "result" => $match->short_scoreline,
                    "competition" => $match->competition->name
                ];

                $matchData[] = $singleMatch;
            }

            $singleRound = [
                "title" => $round->competitionRound->name,
                "matches" => $matchData
            ];

            $roundData[] = $singleRound;
        }

        return [
            "rounds" => $roundData
        ];
    }

    /**
     * List all of the table details for a specified competition
     *
     * @param int $competitionId
     * @return array
     */
    public function competitionTables(int $competitionId): array
    {
        $tables = CompetitionTable::join('competitionrounds', 'competitiontables.round_id', '=', 'competitionrounds.id')
            ->where('competition_id','=',$competitionId)
            ->orderBy('competitionrounds.order', 'asc')
            ->select('competitiontables.*')
            ->get();

        $tableData = array();
        foreach ($tables as $table) {

            if ($table->competition->type->status == "F") {
                $singleTable["title"] = $table->group_name;
            }
            else {
                $singleTable["title"] = $table->competitionRound->name . ", " . $table->group_name;
            }

            $tableRows = array();
            foreach ($table->teams()->get() as $row) {

                $tableRow = [
                    "team" => $row->team,
                    "played" => $row->played,
                    "won" => $row->won,
                    "drew" => $row->drew,
                    "lost" => $row->lost,
                    "gd" => $row->goal_difference,
                    "points" => $row->points
                ];

                $tableRows[] = $tableRow;
            }

            $singleTable["rows"] = $tableRows;
            $tableData[] = $singleTable;
        }

        return [
            "tables" => $tableData
        ];
    }

    /**
     * List all of the table details for a specified competition
     *
     * @param int $competitionId
     * @return array
     */
    public function competitionTableResults(int $competitionId): array
    {
        $tables = CompetitionTable::join('competitionrounds', 'competitiontables.round_id', '=', 'competitionrounds.id')
            ->where('competition_id','=',$competitionId)
            ->orderBy('competitionrounds.order', 'asc')
            ->select('competitiontables.*')
            ->get();

        $tableData = array();
        foreach ($tables as $table) {

            if ($table->competition->type->status == "F") {
                $singleTable["title"] = $table->group_name;
            }
            else {
                $singleTable["title"] = $table->competitionRound->name . ", " . $table->group_name;
            }

            $dates = TableResult::where('competition_table_id','=',$table->id)->groupBy('match_date')->orderBy('match_date','asc')->get();

            $tableDates = array();
            foreach ($dates as $date) {

                $results = TableResult::where('match_date','=',$date->match_date)->where('competition_table_id','=',$table->id)->orderBy('match_date','asc')->get();

                $tableResults = array();
                foreach ($results as $result) {
                    $tableResults[] = $result->result;
                }

                $tableDate = [
                    "date" => $date->match_date->format('j F Y'),
                    "results" => $tableResults
                ];

                $tableDates[] = $tableDate;
            }

            $singleTable["match_dates"] = $tableDates;
            $tableData[] = $singleTable;
        }

        return [
            "tables" => $tableData
        ];
    }

    /**
     * List all of the managers
     *
     * @return array
     */
    public function managers(): array
    {
        $managers = Manager::all();

        $managerData = array();
        foreach ($managers as $manager) {

            $singleManager = [
                "id" => $manager->id,
                "fullname" => $manager->fullname,
                "years" => "(" . $manager->years . ")"
            ];

            $managerData[] = $singleManager;
        }

        return [
            "managers" => $managerData
        ];
    }

    /**
     * List all of the matches for a specified manager
     *
     * @param int $managerId
     * @return array
     */
    public function managerMatches(int $managerId): array
    {
        $col = $_GET['col'] ?? 'date';
        $order = $_GET['order'] ?? 'asc';
        $matches = Match::where('manager_id','=',$managerId)->orderBy($col,$order)->get();

        $matchData = array();
        foreach ($matches as $match) {

            $singleMatch = [
                "id" => $match->id,
                "date" => $match->date->format("d/m/Y"),
                "result" => $match->short_scoreline,
                "competition" => $match->competition->name
            ];

            $matchData[] = $singleMatch;
        }

        return [
            "matches" => $matchData
        ];
    }


    private function sortArray($a, $b)
    {
        if ($this->_order == "asc") {
            return strcmp($a[$this->_col], $b[$this->_col]);
        }
        else {
            return strcmp($b[$this->_col], $a[$this->_col]);
        }
    }

}