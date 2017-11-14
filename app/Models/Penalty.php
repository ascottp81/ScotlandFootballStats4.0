<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penalty extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'penalties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['match_id', 'team_id', 'player', 'result', 'penalty_no'];


    /* SCOPES */

    /**
     * Scope query for Scotland penalties
     *
     * @param  $query
     */
    public function scopeScotland($query)
    {
        $query->where('team_id', '=', '0')->orderBy('penalty_no', 'asc');
    }

    /**
     * Scope query for Opponent penalties
     *
     * @param  $query
     */
    public function scopeOpponent($query)
    {
        $query->where('team_id', '<>', '0')->orderBy('penalty_no', 'asc');
    }



    /* RELATIONSHIPS */

    /**
     * A penalty belongs to a match
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function match()
    {
        return $this->belongsTo('App\Models\Match', 'match_id');
    }



    /* ACCESSORS */

    /**
     * Get the team who hit the first penalty
     *
     * @return string
     */
    public function getFirstTeamAttribute()
    {
        $penalty = Penalty::where('match_id', '=', $this->match_id)->where('penalty_no', '=', '1')->firstOrFail();

        if ($penalty->team_id == 0) {
            return "Scotland";
        }
        else {
            $team = Opponent::find($penalty->team_id);
            return $team->name;
        }
    }

    /**
     * Get the current penalty scoreline
     *
     * @return string
     */
    public function getScorelineAttribute()
    {
        $scotlandScored = Penalty::where('match_id', '=', $this->match_id)->where('team_id', '=', '0')->where('penalty_no', '<=', $this->penalty_no)->where('result', '=', 'scored')->count();
        $opponentScored = Penalty::where('match_id', '=', $this->match_id)->where('team_id', '<>', '0')->where('penalty_no', '<=', $this->penalty_no)->where('result', '=', 'scored')->count();

        if ($this->match->ha == "H" || $this->match->ha == "N1") {
            return "Scotland " . $scotlandScored . "-" . $opponentScored . " " . $this->match->opponent->abbr_name;
        }
        else {
            return $this->match->opponent->abbr_name . " " . $opponentScored . "-" . $scotlandScored . " Scotland";
        }
    }

    /**
     * Is Scotland the away team and take the first penalty
     *
     * @return string
     */
    public function getScotlandFirstAttribute()
    {
        if ($this->first_team == "Scotland") {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Is the opponent the away team and take the first penalty
     *
     * @return string
     */
    public function getOpponentFirstAttribute()
    {
        if ($this->first_team == "Scotland") {
            return false;
        }
        else {
            return true;
        }
    }
}
