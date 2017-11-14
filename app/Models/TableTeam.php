<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TableTeam extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tableteams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['competition_table_id', 'position', 'team_id', 'played', 'won', 'drew', 'lost', 'for', 'against', 'points', 'top_place', 'playoff'];



    /* SCOPES */

    /**
     * Scope query for top place in table
     *
     * @param  $query
     */
    public function scopeTop($query)
    {
        $query->where('top_place','=','1');
    }

    /**
     * Scope query for top place in table
     *
     * @param  $query
     */
    public function scopePlayoff($query)
    {
        $query->where('playoff','=','1');
    }


    /* RELATIONSHIPS */

    /**
     * A table row belongs to a competition table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function table()
    {
        return $this->belongsTo('App\Models\CompetitionTable', 'competition_table_id');
    }


    /* ACCESSORS */

    /**
     * Get the team
     *
     * @return string
     */
    public function getTeamAttribute()
    {
        if ($this->team_id == 0) {
            return "SCOTLAND";
        }
        else {
            $team = Opponent::find($this->team_id);
            return $team->name;
        }
    }

    /**
     * Get the team abbreviated name
     *
     * @return string
     */
    public function getShortTeamAttribute()
    {
        if ($this->team_id == 0) {
            return "SCOTLAND";
        }
        else {
            $team = Opponent::find($this->team_id);
            return $team->abbr_name;
        }
    }

    /**
     * Get the goal difference
     *
     * @return string
     */
    public function getGoalDifferenceAttribute()
    {
        $gd = $this->for - $this->against;
        if ($gd > 0) {
            $gd = "+" . $gd;
        }
        return $gd;
    }

    /**
     * Get the team flag image
     *
     * @return string
     */
    public function getFlagAttribute()
    {
        if ($this->team_id == 0) {
            return "scotland";
        }
        else {
            $team = Opponent::find($this->team_id);
            return strtolower(str_replace(" ", "_", $team->name));
        }
    }

    /**
     * Get the line type for this row,
     * i.e top_place(solid line) or play_off (dashed line)
     *
     * @return string
     */
    public function getTableLineAttribute()
    {
        if ($this->top_place == 1 || $this->playoff == 1) {
            $nextRow = TableTeam::where('competition_table_id','=',$this->competition_table_id)->where('position','=',$this->position + 1)->first();

            if ($nextRow) {
                if ($this->top_place == 1 && $nextRow->top_place != 1) {
                    return "solid";
                }
                elseif ($this->playoff == 1 && $nextRow->playoff != 1) {
                    return "dashed";
                }
                else {
                    return "";
                }
            }
            else {
                return "";
            }
        }
        else {
            return "";
        }
    }
}
