<?php
declare(strict_types=1);

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
    protected $fillable = ['competition_table_id', 'position', 'team_id', 'played', 'won', 'drew', 'lost', 'for', 'against', 'points', 'outcome'];



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
    public function getTeamAttribute(): string
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
    public function getShortTeamAttribute(): string
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
    public function getGoalDifferenceAttribute(): string
    {
        $gd = $this->for - $this->against;
        if ($gd > 0) {
            $gd = "+" . $gd;
        }
        return (string) $gd;
    }

    /**
     * Get the team flag image
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
            return strtolower(str_replace(" ", "_", $team->name));
        }
    }

    /**
     * Get the line type for this row,
     * i.e top_place(solid line) or play_off (dashed line)
     *
     * @return string
     */
    public function getTableLineAttribute(): string
    {
        if (in_array($this->outcome, ['won','qualified','promoted','playoff','final'])) {
            $nextRow = TableTeam::where('competition_table_id','=',$this->competition_table_id)->where('position','=',$this->position + 1)->first();

            if ($nextRow) {
                if (in_array($this->outcome, ['won','qualified','promoted','final']) && !in_array($nextRow->outcome, ['won','qualified','promoted','final'])) {
                    return "solid";
                }
                elseif ($this->outcome == 'playoff' && $nextRow->outcome != 'playoff') {
                    return "dashed";
                }
            }
        }
        elseif ($this->outcome == 'relegated') {
            $previousRow = TableTeam::where('competition_table_id','=',$this->competition_table_id)->where('position','=',$this->position - 1)->first();

            if ($previousRow) {
                if ($this->outcome == 'relegated' && $previousRow->outcome != 'relegated') {
                    return "relegated";
                }
            }
        }

        return "";

    }
}
