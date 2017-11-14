<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class TableResult extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tableresults';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['competition_table_id', 'match_date', 'match_round', 'home_team_id', 'home_goals', 'away_goals', 'away_team_id'];

    /**
     * Additional fields to treat as Carbon instances
     *
     * @var array
     */
    protected $dates = ['match_date'];



    /* RELATIONSHIPS */

    /**
     * A table result belongs to a competition table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function table()
    {
        return $this->belongsTo('App\Models\CompetitionTable', 'table_id');
    }



    /* ACCESSORS */

    /**
     * Get the home team
     *
     * @return string
     */
    public function getHomeTeamAttribute()
    {
        if ($this->home_team_id == 0) {
            return "Scotland";
        }
        else {
            $team = Opponent::find($this->home_team_id);
            return $team->name;
        }
    }

    /**
     * Get the away team
     *
     * @return string
     */
    public function getAwayTeamAttribute()
    {
        if ($this->away_team_id == 0) {
            return "Scotland";
        }
        else {
            $team = Opponent::find($this->away_team_id);
            return $team->name;
        }
    }

    /**
     * Get the abbreviated home team
     *
     * @return string
     */
    public function getShortHomeTeamAttribute()
    {
        if ($this->home_team_id == 0) {
            return "Scotland";
        }
        else {
            $team = Opponent::find($this->home_team_id);
            return $team->abbr_name;
        }
    }

    /**
     * Get the abbreviated away team
     *
     * @return string
     */
    public function getShortAwayTeamAttribute()
    {
        if ($this->away_team_id == 0) {
            return "Scotland";
        }
        else {
            $team = Opponent::find($this->away_team_id);
            return $team->abbr_name;
        }
    }


    /**
     * Get the result string
     *
     * @return string
     */
    public function getResultAttribute()
    {
        return $this->home_team . " " . $this->home_goals . "-" . $this->away_goals . " " . $this->away_team;
    }

    /**
     * Get the abbreviated result string
     *
     * @return string
     */
    public function getShortResultAttribute()
    {
        return $this->short_home_team . " " . $this->home_goals . "-" . $this->away_goals . " " . $this->short_away_team;
    }


    /**
     * Get the fixture string
     *
     * @return string
     */
    public function getFixtureAttribute()
    {
        return $this->home_team . " v " . $this->away_team;
    }

    /**
     * Get the abbreviated fixture string
     *
     * @return string
     */
    public function getShortFixtureAttribute()
    {
        return $this->short_home_team . " v " . $this->short_away_team;
    }

    /**
     * Get the date row for table results
     *
     * @return string
     */
    public function getDateRowAttribute()
    {
        $previousResults = TableResult::where('competition_table_id','=',$this->competition_table_id)->orderBy('match_date','desc')->orderBy('id','desc')->get();
        $next = false;
        $previous_date = '1872-01-01 00:00:00';
        foreach ($previousResults as $result) {
            if ($next) {
                $previous_date = $result->match_date;
                break;
            }

            if ($result->id == $this->id) {
                $next = true;
            }
        }

        if ($previous_date != $this->match_date) {
            return date_format(date_create($this->match_date), 'jS F Y');
        }
        else {
            return "";
        }
    }



    /* FUNCTIONS */

    /**
     * Get an array of home table fixtures and results
     *
     * @return  $data array
     */
    public function getHomeTableFixtures()
    {
        $homeTable = CompetitionTable::home()->firstOrFail();

        // Show fixtures or results if group stage is complete
        $showFixtures = false;
        $lastRound = TableResult::where('competition_table_id', $homeTable->id)->orderBy('match_date','desc')->firstOrFail();
        if ($lastRound->match_date >= date('Y-m-d', strtotime("now"))) {
            $showFixtures = true;
        }

        // Get Match Round number of fixtures or results
        $data = array();
        if ($showFixtures) {
            $nextRound = TableResult::where('competition_table_id', $homeTable->id)
                ->where('match_date','>=',date('Y-m-d', strtotime("now")))
                ->orderBy('match_date','asc')
                ->firstOrFail()
                ->match_round;

            // Get next 2 rounds fixtures
            $tableFixtures = TableResult::where('competition_table_id', $homeTable->id)
                ->whereIn('match_round', array($nextRound, $nextRound + 1))
                ->orderBy('match_date','asc')
                ->get();

            $lastDate = "";
            foreach ($tableFixtures as $fixture) {
                $matchdate = $fixture->match_date->format('j F Y');
                if ($lastDate == $matchdate) {
                    $date = "";
                }
                else {
                    $date = $matchdate;
                }
                $data[] = ["date" => $date, "fixture" => $fixture->short_fixture];
                $lastDate = $matchdate;
            }
        }
        else {
            $lastRound = TableResult::where('competition_table_id', $homeTable->id)
                ->where('match_date','<',date('Y-m-d', strtotime("now")))
                ->orderBy('match_date','desc')
                ->firstOrFail()
                ->match_round;

            // Get last 2 rounds results
            $tableResults = TableResult::where('competition_table_id', $homeTable->id)
                ->whereIn('match_round', array($lastRound, $lastRound - 1))
                ->orderBy('match_date','desc')
                ->get();

            $lastDate = "";
            foreach ($tableResults as $result) {
                $matchdate = $result->match_date->format('j F Y');
                if ($lastDate == $matchdate) {
                    $date = "";
                }
                else {
                    $date = $matchdate;
                }
                $data[] = ["date" => $date, "fixture" => $result->short_result];
                $lastDate = $matchdate;
            }
        }

        return $data;
    }
}
