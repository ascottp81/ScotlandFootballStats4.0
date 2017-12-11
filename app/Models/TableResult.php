<?php
declare(strict_types=1);

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

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'match_round' => 'integer',
    ];


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
    public function getHomeTeamAttribute(): string
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
    public function getAwayTeamAttribute(): string
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
    public function getShortHomeTeamAttribute(): string
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
    public function getShortAwayTeamAttribute(): string
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
    public function getResultAttribute(): string
    {
        return $this->home_team . " " . $this->home_goals . "-" . $this->away_goals . " " . $this->away_team;
    }

    /**
     * Get the abbreviated result string
     *
     * @return string
     */
    public function getShortResultAttribute(): string
    {
        return $this->short_home_team . " " . $this->home_goals . "-" . $this->away_goals . " " . $this->short_away_team;
    }


    /**
     * Get the fixture string
     *
     * @return string
     */
    public function getFixtureAttribute(): string
    {
        return $this->home_team . " v " . $this->away_team;
    }

    /**
     * Get the abbreviated fixture string
     *
     * @return string
     */
    public function getShortFixtureAttribute(): string
    {
        return $this->short_home_team . " v " . $this->short_away_team;
    }

    /**
     * Get the date row for table results
     *
     * @return string
     */
    public function getDateRowAttribute(): string
    {
        // loop through each table result for the same table
        $results = TableResult::where('competition_table_id','=',$this->competition_table_id)->orderBy('match_date','asc')->get();
        $previousDate = 'NULL';
        foreach ($results as $result) {

            // if the match date is different to the previous one,
            // assign the match date to the variable
            if ($result->match_date != $previousDate) {
                $assignedDate = date_format($result->match_date, 'jS F Y');
            }
            // otherwise assign a blank string
            else {
                $assignedDate = "";
            }

            // if the table result is the current one, return the assigned value
            if ($result->id == $this->id) {
                return $assignedDate;
            }

            $previousDate = $result->match_date;
        }

        return "";
    }

    /**
     * Is this the last result in a date
     *
     * @return bool
     */
    public function getLastMatchInDateAttribute(): bool
    {
        // loop through each table result for the same table, in reverse
        $results = TableResult::where('competition_table_id','=',$this->competition_table_id)->orderBy('match_date','desc')->orderBy('id','desc')->get();
        $previousDate = 'NULL';
        foreach ($results as $result) {

            // if the match date is different to the previous one (next in calendar),
            // it is the last match in a date
            if ($result->match_date != $previousDate) {
                $lastMatch = true;
            }
            // otherwise it is not the last match
            else {
                $lastMatch = false;
            }

            // if the table result is the current one, return the assigned value
            if ($result->id == $this->id) {
                return $lastMatch;
            }

            $previousDate = $result->match_date;
        }

        return false;
    }
}
