<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchIncident extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matchincidents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['match_id', 'team_id', 'incident_type_id', 'minute', 'player'];



    /* RELATIONSHIPS */

    /**
     * An incident belongs to a match
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function match()
    {
        return $this->belongsTo('App\Models\Match', 'match_id');
    }

    /**
     * An incident belongs to an incident type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Models\IncidentType', 'incident_type_id');
    }




    /* ACCESSORS */

    /**
     * Get the team linked to the incident
     *
     * @return string
     */
    public function getTeamAttribute(): string
    {
        if ($this->team_id == 0) {
            return "Scotland";
        }
        else {
            $team = Opponent::find($this->team_id);
            return $team->name;
        }
    }

    /**
     * Get the team flag linked to the incident
     *
     * @return string
     */
    public function getFlagAttribute(): string
    {
        if ($this->team_id == 0) {
            return "scotland";
        }
        else {
            $team = Opponent::find($this->team_id);
            return $team->flag;
        }
    }

    /**
     * Get the team flag linked to the incident
     *
     * @return string
     */
    public function getScorelineAttribute(): string
    {
        $scotlandScored = MatchIncident::where('match_id', '=', $this->match_id)->where('team_id', '=', '0')->where('minute', '<=', $this->minute)->whereIn('incident_type_id', array(1,2,3))->count();
        $opponentScored = MatchIncident::where('match_id', '=', $this->match_id)->where('team_id', '<>', '0')->where('minute', '<=', $this->minute)->whereIn('incident_type_id', array(1,2,3))->count();

        if ($this->match->ha == "H" || $this->match->ha == "N1") {
            return "Scotland " . $scotlandScored . "-" . $opponentScored . " " . $this->match->opponent->name;
        }
        else {
            return $this->match->opponent->name . " " . $opponentScored . "-" . $scotlandScored . " Scotland";
        }
    }
}
