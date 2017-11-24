<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class CompetitionTable extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'competitiontables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['competition_id', 'round_id', 'group_name', 'home', 'head_to_head', 'win_points'];



    /* SCOPES */

    /**
     * Scope query for table on home page
     *
     * @param  $query
     */
    public function scopeHome($query)
    {
        $query->where('home','=','1');
    }



    /* RELATIONSHIPS */

    /**
     * A competition table belongs to a competition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competition()
    {
        return $this->belongsTo('App\Models\Competition', 'competition_id');
    }

    /**
     * A competition table belongs to a competition round
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competitionRound()
    {
        return $this->belongsTo('App\Models\CompetitionRound', 'round_id');
    }

    /**
     * A competition table has many teams
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany('App\Models\TableTeam')->orderBy('position','asc');
    }

    /**
     * A competition table has many results
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany('App\Models\TableResult')->orderBy('match_date','asc');
    }


    /* ACCESSORS */

    /**
     * Get the home table fixtures, or results if there are no fixtures
     *
     * @return array
     */
    public function getTableFixturesResultsAttribute(): array
    {
        // Show fixtures or results if group stage is complete
        $showFixtures = false;
        $lastRound = TableResult::where('competition_table_id', $this->id)->orderBy('match_date','desc')->firstOrFail();
        if ($lastRound->match_date >= date('Y-m-d', strtotime("now"))) {
            $showFixtures = true;
        }

        // Get Match Round number of fixtures or results
        $data = array();
        if ($showFixtures) {
            $nextRound = TableResult::where('competition_table_id', $this->id)
                ->where('match_date','>=',date('Y-m-d', strtotime("now")))
                ->orderBy('match_date','asc')
                ->firstOrFail()
                ->match_round;

            // Get next 2 rounds fixtures
            $tableFixtures = TableResult::where('competition_table_id', $this->id)
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
            $lastRound = TableResult::where('competition_table_id', $this->id)
                ->where('match_date','<',date('Y-m-d', strtotime("now")))
                ->orderBy('match_date','desc')
                ->firstOrFail()
                ->match_round;

            // Get last 2 rounds results
            $tableResults = TableResult::where('competition_table_id', $this->id)
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


    /**
     * Get the text for the table to state fixtures and/or results
     *
     * @return string
     */
    public function getFixtureResultTextAttribute(): string
    {
        if ($this->results()->count() > 0) {
            $firstDate = $this->results()->orderBy('match_date','asc')->first()->date;
            $lastDate = $this->results()->orderBy('match_date','desc')->first()->date;

            if (Carbon::now() < $firstDate){
                return "Fixtures";
            }
            elseif ((Carbon::now() >= $firstDate) && (Carbon::now() < $lastDate)) {
                return "Fixtures / Results";
            }
            else {
                return "Results";
            }
        }
        else {
            return "Results";
        }
    }


    /**
     * Get the table group name title
     *
     * @return string
     */
    public function getGroupNameAttribute($value): string
    {
        $round = $this->competitionRound()->first()->name;

        if ($round != "None" && $this->competition->type->status == "F") {
            return $round . " - " . $value;
        }
        elseif ($this->competition->type->status == "C") {
            return $value;
        }
        else {
            return "";
        }
    }
}
