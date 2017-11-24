<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Appearance extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'appearances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['match_id', 'player_id', 'shirt_no', 'club_id', 'replaced', 'minute', 'captain', 'keeper', 'goals', 'penalties', 'cards', 'shirt_no_show'];
	
	
	
    /* SCOPES */

    /**
     * Scope query for starting appearances
     * 
     * @param  $query
     */
    public function scopeStarts($query)
    {
        $query->where('replaced','=','0')->orderBy('keeper', 'desc')->orderBy('shirt_no', 'asc');
    }	

	/**
     * Scope query for substitutes
     * 
     * @param  $query
     */
    public function scopeSubstitutes($query)
    {
        $query->where('replaced','>','0')->orderBy('shirt_no', 'asc');
    }
	
	
    /* RELATIONSHIPS */

    /**
     * An appearance belongs to a player
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player()
    {
        return $this->belongsTo('App\Models\Player', 'player_id');
    }
	
	/**
     * An appearance belongs to a match
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function match()
    {
        return $this->belongsTo('App\Models\Match', 'match_id');
    }
	
	/**
     * An appearance belongs to a club
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo('App\Models\Club', 'club_id');
    }
	
	
	
    /* ACCESSORS */
	
	/**
	 * Get the player who was replaced by this substitute
	 *
	 * @return string
	 */
	public function getReplacedPlayerAttribute(): string
	{
	    $appearance = Appearance::where('match_id', '=', $this->match_id)->where('shirt_no', '=', $this->replaced)->firstOrFail();
	    return $appearance->player->fullname;
	}
	
	/**
	 * Get the substitute who replaced this player, for the Scotland team string list
	 *
	 * @return string
	 */
	public function getSubstituteStringAttribute(): string
	{
		$substitute = "";

        $appearance = Appearance::where('match_id', '=', $this->match_id)->where('replaced', '=', $this->shirt_no);

        if ($appearance->count() > 0) {
            $appearance = $appearance->firstOrFail();
            $substitute = " (" . $appearance->player->short_name . " " . $appearance->player->minute . ")";
        }
		
		return $substitute;
	}
	
	/**
	 * Get the player's cap count up to and including this match
	 *
	 * @return string
	 */
	public function getCapsAttribute(): string
	{
		$caps = Appearance::join('matches', 'matches.id', '=', 'appearances.match_id')
			->select('match.date')
			->whereNotNull('result')
			->where('player_id', '=', $this->player_id)
			->where('date', '<=', $this->match->date)
			->count();
			
		if ($caps == 1) {
			return "1&nbsp;Cap";	
		}
		else {
			return $caps . "&nbsp;Caps";
		}
	}
	
	/**
	 * Get the player's age as of the match date
	 *
	 * @return string
	 */
	public function getAgeAttribute(): string
	{
		$age = intval($this->match->date->format('Y')) - intval($this->player->date_of_birth->format('Y'));
		if ($this->player->date_of_birth->format('m-d') > $this->match->date->format('m-d')) {
			$age--;	
		}
		
		if ($this->player->date_of_birth == "-0001-11-30 00:00:00") {
			$age = "&mdash;";	
		}
		
		return (string) $age;
	}

    /**
     * Determine if a player has an info tooltip for a match
     *
     * @return bool
     */
    public function getPlayerInfoAttribute(): bool
    {
        $substituted = Appearance::where('match_id','=',$this->match_id)->where('replaced','=',$this->shirt_no)->count();

        if ($this->goals > 0 || $this->cards != "" || $this->replaced > 0 || $substituted == 1 || $this->captain == 1) {
            return true;
        }
        else {
            return false;
        }
    }
	
}
