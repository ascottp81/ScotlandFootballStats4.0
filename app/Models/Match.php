<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

use App\Classes\GettyImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;


class Match extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'opponent_id', 'competition_id', 'round_id', 'other_competition_id', 'venue', 'location_id', 'ha', 'attendance', 'result', 'scot_scorers', 'opp_scorers', 'manager', 'manager_id', 'opp_team', 'scot_miss_pen', 'opp_miss_pen', 'scot_red_card', 'opp_red_card', 'result_comment', 'comment', 'kickoff', 'opp_ranking', 'formation', 'getty_image'];

    /**
     * Additional fields to treat as Carbon instances
     * 
     * @var array
     */
    protected $dates = ['date'];
	
	
    /* SCOPES */

    /**
     * Scope query for fixtures
     * 
     * @param  $query
     */
    public function scopeFixtures($query)
    {
        $query->whereNull('result')->orderBy('date', 'asc');
    }

    /**
     * Scope query for recent results
     * 
     * @param  $query
     */
    public function scopeRecent($query)
    {
        $query->where('date', '>=', Carbon::now()->addYears(-3))->whereNotNull('result')->orderBy('date', 'desc');
    }


    /**
     * Scope query for wins
     * 
     * @param  $query
     */
    public function scopeWon($query)
    {
        $query->where('result', 'LIKE', 'W%');
    }
	
	/**
     * Scope query for draws
     * 
     * @param  $query
     */
    public function scopeDrew($query)
    {
        $query->where('result', 'LIKE', 'D%');
    }
	
    /**
     * Scope query for defeats
     * 
     * @param  $query
     */
    public function scopeLost($query)
    {
        $query->where('result', 'LIKE', 'L%');
    }
	
	/**
     * Scope query for home games
     * 
     * @param  $query
     */
    public function scopeHome($query)
    {
        $query->where('ha', '=', 'H');
    }
	
	/**
     * Scope query for away/neutral games
     * 
     * @param  $query
     */
    public function scopeAwayNeutral($query)
    {
        $query->where('ha', '<>', 'H');
    }
	
    /**
     * Scope query for opponent
     * 
     * @param  $query
	 * @param  int  $opponent_id
     */
    public function scopeOpponentId($query, $opponent_id)
    {
        $query->where('opponent_id','=',$opponent_id)->whereNotNull('result');
    }
	
    /**
     * Scope query for manager
     * 
     * @param  $query
	 * @param  int  $manager_id
     */
    public function scopeManagerId($query, $manager_id)
    {
        $query->where('manager_id','=',$manager_id)->whereNotNull('result');
    }
	
    /**
     * Scope query for competitive games in match search
     * 
     * @param  $query
     */
    public function scopeCompetitive($query)
    {
        $query->join('competitions', 'competitions.id', '=', 'matches.competition_id')->join('competitiontype', 'competitions.competition_type_id','=','competitiontype.id')->select("matches.*")->where('status','=','C');
    }
	
    /**
     * Scope query for friendly games in match search
     * 
     * @param  $query
     */
    public function scopeFriendly($query)
    {
        $query->join('competitions', 'competitions.id', '=', 'matches.competition_id')->join('competitiontype', 'competitions.competition_type_id','=','competitiontype.id')->select("matches.*")->where('status','=','F');
    }

    /**
     * Scope query for competition games
     *
     * @param  $query
     */
    public function scopeCompetitionType($query, $typeid)
    {
        $query->join('competitions', function ($join) {
            $join->on('matches.competition_id','=','competitions.id')->orOn('matches.other_competition_id','=','competitions.id');
        })
            ->join('competitiontype', 'competitiontype.id','=','competitions.competition_type_id')
            ->select('matches.*')
            ->where('competition_type_id','=',$typeid)
            ->whereNotNull('result');
    }

    /**
     * Scope query for qualification games
     *
     * @param  $query
     */
    public function scopeQualifiers($query)
    {
        $query->where('stage', '=', 'Qualifiers');
    }

    /**
     * Scope query for finals games
     *
     * @param  $query
     */
    public function scopeFinals($query)
    {
        $query->where('stage', '=', 'Finals');
    }

	/**
     * Scope query for match search
     * 
     * @param  $query
	 * @param  string  $parameters
     */
    public function scopeSearch($query, $parameters)
    {
		if ($parameters == "all") {
			$query->whereNotNull('result');
		}
		else{
			$parameterSet = explode("&", $parameters);
			
			$query->whereNotNull('result');
			
			foreach ($parameterSet as $parameterItem) {
				$parametervalues = explode("=", $parameterItem);
				
				if ($parametervalues[0] == "opponent") {
					$query->where('opponent_id','=',$parametervalues[1]);
				}		
				if ($parametervalues[0] == "datefrom") {
					$query->where('date','>=',$parametervalues[1]);
				}
				if ($parametervalues[0] == "dateto") {
					$query->where('date','<=',$parametervalues[1]);
				}			
				if ($parametervalues[0] == "venue") {
					$query->where('ha','like',$parametervalues[1] . "%");
				}
				if ($parametervalues[0] == "result") {
					$query->where('result','like',$parametervalues[1] . "%");
				}
				if ($parametervalues[0] == "matchtype") {
					if ($parametervalues[1] == "C") {
						$query->Competitive();
					}
					else {
						$query->Friendly();
					}
				}				
			}
		}
    }

	
	

    /* RELATIONSHIPS */

    /**
     * A game belongs to an opponent
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opponent()
    {
        return $this->belongsTo('App\Models\Opponent', 'opponent_id');
    }
	
    /**
     * A game belongs to a competition
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competition()
    {
        return $this->belongsTo('App\Models\Competition', 'competition_id');
    }
	
    /**
     * A game belongs to a competition round
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competitionRound()
    {
        return $this->belongsTo('App\Models\CompetitionRound', 'round_id');
    }
	
    /**
     * A game belongs to an other competition version
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function otherCompetition()
    {
        return $this->belongsTo('App\Models\Competition', 'other_competition_id');
    }

    /**
     * A game belongs to a location
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }

    /**
     * A game belongs to a manager
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo('App\Models\Manager', 'manager_id');
    }

    /**
     * A game has many lineups
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appearances()
    {
        return $this->hasMany('App\Models\Appearance');
    }
	
	/**
     * A game has many videos
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany('App\Models\Video', 'match_id');
    }
	
	/**
     * A game has one summary
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function summary()
    {
        return $this->hasOne('App\Models\MatchSummary', 'match_id');
    }
	
	/**
     * A game has one fact
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fact()
    {
        return $this->hasOne('App\Models\Fact', 'match_id');
    }
	
	/**
     * A game has one stripmatch
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function strips()
    {
        return $this->hasOne('App\Models\StripMatch', 'match_id');
    }
	
    /**
     * A game has many extramatchstats
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stats()
    {
        return $this->hasMany('App\Models\MatchStatistic', 'match_id');
    }

    /**
     * A game has many incidents
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidents()
    {
        return $this->hasMany('App\Models\MatchIncident')->orderBy('minute','asc');
    }

    /**
     * A game has many penalties from a shootout
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penalties()
    {
        return $this->hasMany('App\Models\Penalty');
    }
	
	
    /* ACCESSORS */
	
	/**
	 * Get the match scoreline
	 *
	 * @return string
	 */
	public function getScorelineAttribute()
	{
		if ($this->ha == "H" || $this->ha == "N1") {
			return "Scotland " . $this->score . " " . $this->opponent->name;
		}
		else {
			return $this->opponent->name . " " . $this->score . " Scotland";
		}
	}
	
	/**
	 * Get the shortened match scoreline
	 *
	 * @return string
	 */
	public function getShortScorelineAttribute()
	{
		if ($this->ha == "H" || $this->ha == "N1") {
			return "Scotland " . $this->score . " " . $this->opponent->abbr_name;
		}
		else {
			return $this->opponent->abbr_name . " " . $this->score . " Scotland";
		}
	}
	
	/**
	 * Get the numeric score, goals only
	 *
	 * @return string
	 */
	public function getScoreAttribute()
	{
		if ($this->ha == "H" || $this->ha == "N1") {
			return substr($this->result, 2);	
		}
		else {
			return substr($this->result, strpos($this->result, "-") + 1) . "-" . substr($this->result, 2, strpos($this->result, "-") - 2);
		}		
	}
	
	/**
	 * Get the sitemap match scoreline
	 *
	 * @return string
	 */
	public function getSitemapScorelineAttribute()
	{
		return $this->short_scoreline . ", " . $this->date->format('Y');
	}
	
	/**
	 * Get the match url
	 *
	 * @return string
	 */
	public function getUrlAttribute()
	{
		$datePart = $this->date->format('d-m-Y');
		$teamPart = "";
		if ($this->ha == "H" || $this->ha == "N1") {
			$teamPart = "scotland-" . str_replace(" ", "-", $this->opponent->name);
		}
		else {
			$teamPart = str_replace(" ", "-", $this->opponent->name) . "-scotland";
		}
		
		return strtolower($datePart . "/" . $teamPart);
	}
	
	
	/**
	 * Get the fixture string
	 *
	 * @return string
	 */
	public function getFixtureAttribute()
	{
		if ($this->ha == "H" || $this->ha == "N1") {
			return "Scotland v " . $this->opponent->name;
		}
		else {
			return $this->opponent->name . " v Scotland";
		}
	}
	
	/**
	 * Get the shortened fixture string
	 *
	 * @return string
	 */
	public function getShortFixtureAttribute()
	{
		if ($this->ha == "H" || $this->ha == "N1") {
			return "Scotland v " . $this->opponent->abbr_name;
		}
		else {
			return $this->opponent->abbr_name . " v Scotland";
		}
	}
	
	/**
	 * Get the home team
	 *
	 * @return string
	 */
	public function getHomeTeamAttribute()
	{
		if ($this->ha == "H" || $this->ha == "N1") {
			return "Scotland";
		}
		else {
			return $this->opponent->name;
		}
	}

	/**
	 * Get the home team
	 *
	 * @return string
	 */
	public function getAwayTeamAttribute()
	{
		if ($this->ha == "A" || $this->ha == "N") {
			return "Scotland";
		}
		else {
			return $this->opponent->name;
		}
	}
	
	/**
	 * Get the kickoff string
	 *
	 * @param string $value
	 * @return string
	 */
	public function getKickoffAttribute($value)
	{
		if ($value == "") {
			return "unknown";
		}
		
		return $value;
	}
	
	
	/**
	 * Get home / away
	 *
	 * @return string
	 */
	public function getHomeAwayAttribute()
	{
		if ($this->ha == "N1") {
			return "N";	
		}
		else {
			return $this->ha;
		}		
	}
	
	/**
	 * Get the venue string
	 *
	 * @return string
	 */
	public function getVenueLocationAttribute()
	{
		if ($this->venue != "" && $this->location_id > 0) {
			return $this->venue . ", " . $this->location->city;
		}
		elseif ($this->venue == "" && $this->location_id == 0) {
			return "Venue: unknown";	
		}
		elseif ($this->location_id == 0) {
			return $this->venue;	
		}
		else {
			return $this->location->city;	
		}
	}
	
	/**
	 * Get full venue
	 *
	 * @return string
	 */
	public function getVenueHaAttribute()
	{
        if ($this->venue != "" && $this->location_id > 0) {
            return $this->venue . ", " . $this->location->city . " (" . $this->home_away . ")";
        }
        elseif ($this->venue == "" && $this->location_id == 0) {
            return  "(" . $this->home_away . ")";
        }
        elseif ($this->location_id == 0) {
            return $this->venue . " (" . $this->home_away . ")";
        }
        else {
            return $this->location->city . " (" . $this->home_away . ")";
        }
	}
	
	
	/**
	 * Get attendance
	 *
	 * @param integer $value
	 * @return string
	 */
	public function getAttendanceAttribute($value)
	{
		if ($value == 0) {
			return "N/A";	
		}
		else {
			return number_format($value , 0, '.', ',');	
		}
	}
	
	
	/**
	 * Is this a competitive match
	 *
	 * @return bool
	 */
	public function getIsCompetitiveAttribute()
	{
	    $competitionType = $this->competition->type->status;
			
		if ($competitionType == "C") {
			return true;	
		}
		else {
			return false;	
		}
	}


    /**
     * Get the result comment
     *
     * @return string
     */
    public function getResultCommentAttribute($value)
    {
        if ($value != "")
            return ' (' . $value . ')';
        else
            return '';
    }

    /**
	 * Get Scotland scorers
	 *
	 * @param string $value
	 * @return array $scorers
	 */
	public function getScotScorersAttribute($value)
	{
        if ($value == null) {
            return array();
        }
		return $this->playerStringToArray($value);
	}
	
	/**
	 * Get Opponent scorers
	 *
	 * @param string $value
	 * @return array $scorers
	 */
	public function getOppScorersAttribute($value)
	{
        if ($value == null) {
            return array();
        }
		return $this->playerStringToArray($value);
	}
	
	/**
	 * Get Scotland penalty misses
	 *
	 * @param string $value
	 * @return array $players
	 */
	public function getScotPenMissAttribute($value)
	{
	    if ($value == null) {
	        return array();
        }
		return $this->playerStringToArray($value);
	}
	
	/**
	 * Get Opponent penalty misses
	 *
	 * @param string $value
	 * @return array $players
	 */
	public function getOppPenMissAttribute($value)
	{
        if ($value == null) {
            return array();
        }
		return $this->playerStringToArray($value);
	}
	
	/**
	 * Get Scotland red cards
	 *
	 * @param string $value
	 * @return array $players
	 */
	public function getScotRedCardAttribute($value)
	{
        if ($value == null) {
            return array();
        }
		return $this->playerStringToArray($value);
	}
	
	/**
	 * Get Opponent red cards
	 *
	 * @param string $value
	 * @return array $players
	 */
	public function getOppRedCardAttribute($value)
	{
        if ($value == null) {
            return array();
        }
		return $this->playerStringToArray($value);
	}
	
	
	/**
	 * Get Scotland team
	 *
	 * @return $team string
	 */
	public function getScotTeamAttribute()
	{
		if ($this->team != "") {
			return str_replace(", ", "<br />", $this->team);
		}
		else {
			$team = "";
			foreach ($this->appearances()->starts()->get() as $player) {
				$team .= substr($player->player->firstname, 0, 1) . " " . $player->player->surname;
				if ($player->captain == 1) {
					$team .= "(C)";	
				}
				$team .= $player->substitute_string . "<br />";
			}
			
			return $team;
		}	
	}

	/**
	 * Get Opponent team
	 *
	 * @param string $value
	 * @return string $team
	 */
	public function getOppTeamAttribute($value)
	{
		return str_replace(", ", "<br />", $value);	
	}	
	
	/**
	 * Get the home team flag image
	 *
	 * @return string
	 */
	public function getHomeFlagAttribute()
	{
		if ($this->ha == "H" || $this->ha == "N1") {
			return "scotland";
		}
		else {
			return strtolower(str_replace(" ", "_", $this->opponent->name));
		}
	}
	
	/**
	 * Get the away team flag image
	 *
	 * @return string
	 */
	public function getAwayFlagAttribute()
	{
		if ($this->ha == "H" || $this->ha == "N1") {
			return strtolower(str_replace(" ", "_", $this->opponent->name));
		}
		else {
			return "scotland";
		}
	}
	
	/**
	 * Get Scotland's FIFA ranking for the match
	 *

	 * @return string
	 */
	public function getScotRankingAttribute()
	{
		$rankingString = "";
		$ranking = Ranking::where('date', '<=', $this->date)->orderBy('date', 'desc');
		
		if ($ranking->count() > 0) {
			$rankingString = $ranking->firstOrFail()->ranking;
		}
		
		return $rankingString;
	}
	
	/**
	 * Get Scotland's formation for the match
	 *
	 * @return string
	 */
	public function getFormationStringAttribute()
	{
		$start = strpos($this->formation, "(") + 1;
		return substr($this->formation, $start, strpos($this->formation, ")") - $start);
	}	
	
	/**
	 * Get Scotland's formation structure and players
	 *
	 * @return array
	 */
	public function getFormationShirtsAttribute()
	{
		$shirtString = str_replace(" ", "", substr($this->formation, strpos($this->formation, ")") + 2));
		$shirts = explode(",", $shirtString);
		
		$formationCount = sizeof(explode("-", "1-" . $this->formation_string));
		$formations = explode("-", "1-" . str_replace("-0", "", $this->formation_string));
		
		// row heights
        $divheight = 0;
		if ($formationCount == 3){
			$divheight = "120";
		}
		elseif ($formationCount == 4){
			$divheight = "80";
		}
		elseif ($formationCount == 5){
			$divheight = "70";
		}
		elseif ($formationCount == 6){
			$divheight = "60";
		}	
		
		// strip colours
		if ($this->strips->strip_id != 0) {
			$stripColour = $this->strips->strip->colour;
			if ($stripColour == "") {
				$stripColour = "DarkBlue";
			}
		}
		else {
			$stripColour = "DarkBlue";
		}
		$goalkeeperTop = $this->strips->goalkeeper_top;
		if ($goalkeeperTop == ""){
			if (($stripColour == "DarkBlue") || ($stripColour == "LightBlue") || ($stripColour == "Claret")){
				$goalkeeperTop = "yellow";
			}
			elseif (($stripColour == "White") || ($stripColour == "Yellow")){
				$goalkeeperTop = "Claret";
			}
			else{
				$goalkeeperTop = "yellow";
			}
		}
		
		
		$a = 0;
		$rows = array();
		// loop through each row
		for ($i = 0; $i < sizeof($formations); $i++) {
			
			$colour = $stripColour;
			if ($i == 0) {
				$colour = $goalkeeperTop;
			}
			
			$players = array();
			// loop through each player in a row
			$b = $a;
			for ($j = $b; $j < ($formations[$i] + $b); $j++) {
			    $appearance = Appearance::where('match_id', '=', $this->id)->where('shirt_no','=',$shirts[$a])->firstOrFail();

				$player = array($shirts[$a], $appearance->player->full_name, $colour, $divheight);
				$players[] = $player;
				$a++;
			}
			$rows[] = $players;
		}
		
		return $rows;
	}
	
	
	/**
	 * Get the match Getty Image
	 *
	 * @return string
	 */
	public function getImageAttribute()
	{
		$image = $this->getty_image;
		
		if ($image == "") {
			if ($this->manager()->count() > 0) {
				$image = $this->manager()->firstOrFail()->getty_image;
			}
		}
		$gettyImage = new GettyImage($image, 2);

		return $gettyImage->outputImage();
	}	
	
	/**
	 * Get the match lineup Getty Image
	 *
	 * @return string
	 */
	public function getLineupImageAttribute()
	{
		$appearance = Appearance::join('players', 'appearances.player_id','=','players.id')
			->where('match_id', '=', $this->id)
			->whereNotNull('getty_image')
			->orderBy(DB::Raw('RAND()'))
			->first();
		
		if ($appearance) {
			$gettyImage = new GettyImage($appearance->player->getty_image, 2);
			return array($gettyImage->outputImage(), $appearance->shirt_no, $appearance->player->full_name);
		}
		else {
			return null;
		}
	}

    /**
     * Get competition table
     *
     * @return object
     */
    public function getCompetitionTableCountAttribute()
    {
        $table = CompetitionTable::where('competition_id', '=', $this->competition->id)
            ->where('round_id', '=', $this->competitionRound->id)
            ->count();

        return $table;
    }

    /**
     * Get competition table
     *
     * @return object
     */
    public function getCompetitionTableAttribute()
    {
        $table = CompetitionTable::where('competition_id', '=', $this->competition->id)
            ->where('round_id', '=', $this->competitionRound->id)
            ->firstOrFail();

        return $table;
    }

	
	/**
	 * Get competition match round
	 *
	 * @return integer
	 */
	public function getMatchRoundAttribute()
	{
	    $table = CompetitionTable::where('competition_id', '=', $this->competition->id)->where('round_id', '=', $this->competitionRound->id)->firstOrFail();
	    $result = $table->results()->where('match_date', '=', $this->date);

		if ($result->count() > 0) {
			return $result->firstOrFail()->match_round;
		}
		else {
			return 0;	
		}
	}
	
	/**
	 * Get competition match round date
	 *
	 * @return string
	 */
	public function getMatchRoundDateAttribute(): string
	{
        $table = CompetitionTable::where('competition_id', '=', $this->competition->id)->where('round_id', '=', $this->competitionRound->id)->firstOrFail();
        $result = $table->results()
            ->where('match_round', '=', $this->match_round)
            ->orderBy('match_date', 'desc')
            ->firstOrFail();

		return $result->match_date->format('j M Y');
	}

    /**
     * Get competition round text, for competition pages
     *
     * @return string
     */
    public function getCompetitionRoundTextAttribute(): string
    {
        $previousMatches = Match::where('competition_id','=', $this->competition_id)
            ->where('round_id','=', $this->round_id)
            ->where('date','<', $this->date)
            ->count();

        if ($previousMatches == 0) {
            return $this->competitionRound->name;
        }
        else {
            return "";
        }
    }

	
	/**
	 * Get past event text
	 *
	 * @return string
	 */
	public function getPastEventAttribute()
	{
		$compString = "the " . $this->competition->name . ".";
		if ($this->competition->name == "Friendly"){
			$compString = "a Friendly.";
		}
		
		if (substr($this->result, 0, 1) == "W"){
			$event = "Scotland defeated " . $this->opponent->name . " " . substr($this->result, 1) . " in " . $compString;
		}
		elseif (substr($this->result, 0, 1) == "D"){
			$event = "Scotland drew " . substr($this->result, 1) . " with " . $this->opponent->name . " in " . $compString;
		}
		elseif (substr($this->result, 0, 1) == "L"){
			$event = "Scotland lost " . substr($this->result, 1) . " to " . $this->opponent->name . " in " . $compString;
		}
		else{
			$event = "Scotland played " . $this->opponent->name . " in " . $compString;
		}
		
		return $event;
	}

    /**
     * Get picture count
     *
     * @return integer
     */
    public function getPictureCountAttribute()
    {
        $path = public_path().'/storage/matches/' . $this->id;
        if (file_exists($path)) {
            $pictures = File::allFiles("storage/matches/" . $this->id);
            return sizeof($pictures);
        }
        else {
            return 0;
        }
    }

    /**
     * Get pictures
     *
     * @return array
     */
    public function getPicturesAttribute()
    {
        $fileData = array();
        $path = public_path().'/storage/matches/' . $this->id;
        if (file_exists($path)) {
            $pictures = File::allFiles("storage/matches/" . $this->id);
            foreach($pictures as $image) {
                $fileData[] = basename($image);
            }
        }
        return $fileData;
    }

    /**
     * Get number of empty tabs at top of details, to determine width
     *
     * @return integer
     */
    public function getEmptyTabsAttribute()
    {
        $emptyTabs = 0;
        $mainVideo = Video::getMatchVideo($this->id);
        if ($mainVideo->count() == 0) {
            $emptyTabs += 1;
        }
        if (!$this->summary && ($this->incidents->count() == 0 || config('app.livemedia'))) {
            $emptyTabs += 1;
        }
        if ($this->picture_count == 0) {
            $emptyTabs += 1;
        }

        return $emptyTabs;
    }
	
	
	/**
	 * Get the first sector of the breadcrumb on the match details page
	 *
	 * @return array
	 */
	public function getBreadcrumbAttribute() 
	{
		// split match list url into segments
		$urlSegments = explode("/", Session::get('MatchListUrl'));
		
		// remove the last segment
		array_pop($urlSegments);
		
		// generate the breadcrumb url with the remaining segments
		$breadcrumbUrl = implode("/", $urlSegments);

		// if the last segment is numeric, assign player list values
		$lastSegment = array_pop($urlSegments);
		if (is_numeric($lastSegment)) {
			$lastSegment = Session::get('PlayerList');
			$breadcrumbUrl = "/players/" . Session::get('PlayerListUrl');
		}
		
		// generate the breadcrumb text from the last segment
		$breadcrumbText = ucwords(str_replace("-", " ", $lastSegment));
		
		// if the last segment is blank, set as the home page
		if ($lastSegment == "" || $lastSegment == "match-search" || $lastSegment == "recent-results") {
			$breadcrumbText = "Home";
			$breadcrumbUrl = "/";
		}
		
		return array('text' => $breadcrumbText, 'url' => $breadcrumbUrl);
		
	}


	/**
	 * Get the meta description for a match details page
	 *
	 * @return string
	 */
	public function getMetaDescriptionAttribute() {
		
		$metadescription = "Match details of " . $this->scoreline . " played on " . $this->date->format('l jS F Y') . " at " . $this->venue_location . " for ";
		if ($this->competition->name == "Friendly"){
			$metadescription .= "a friendly";
		}
		else{
			$metadescription .= "the " . $this->competition->name;
		}

		return $metadescription;
		
	}
	
	
	
	/* FUNCTIONS */
	
	/**
	 * Split Scorers, Penalty Misses, and Sending Offs to Array
	 *
	 * @return array $players
	 */
	public function playerStringToArray($value)
	{
		// split players string by commas
		$tempPlayers = explode(", ", $value);

		// go through each item in array
		for ($j = 0; $j < sizeof($tempPlayers); $j++) {

			// if last digit in item is not numeric, 
			// add hash to show it is end of player row, and not multiple minute values (player scoring multiple goals)
			if (!ctype_digit(substr($tempPlayers[$j], -1, 1))) {
				$tempPlayers[$j] .= "#";
			}
		}

		// implode into string linked by commas
		$playersString = implode(", ", $tempPlayers);	
		// If it is end of player row, swap hash and comma for semi-colon
		$playersString = str_replace("#,", ";", $playersString);
		// If it is the last player row at the end, remove hash
		$playersString = str_replace("#", "", $playersString);
		
		// split players by semi-colon into array of players
		$players = explode("; ", $playersString);
		
		return $players;	
	}


	/**
	 * Get Extra Match Stats
	 *
	 * @return array
	 */
	public function getStats()
	{
		if ($this->ha == "H" || $this->ha == "N1") {
			$stats = $this->stats()->orderBy('team_id', 'asc')->get();
		}
		else {
			$stats = $this->stats()->orderBy('team_id', 'desc')->get();
		}
		
		$i = 0;
		foreach ($stats as $row) {
			if ($i == 0) {
				$homeShots = $row->shots;
				$homeOnTarget = $row->on_target;
				$homePossession = $row->possession;	
				$homeTa = $row->ta;
				$homeFouls = $row->fouls;
				$homeCorners = $row->corners;
				$homeOffside = $row->offside;
				$homeSaves = $row->saves;
				$homeYellowCards = $row->yellow_cards;
				$homeRedCards = $row->red_cards;
				$homeColour = strtolower($row->colour);
			}
			elseif ($i == 1) {
				$awayShots = $row->shots;
				$awayOnTarget = $row->on_target;
				$awayPossession = $row->possession;	
				$awayTa = $row->ta;
				$awayFouls = $row->fouls;
				$awayCorners = $row->corners;
				$awayOffside = $row->offside;
				$awaySaves = $row->saves;
				$awayYellowCards = $row->yellow_cards;
				$awayRedCards = $row->red_cards;
				$awayColour = strtolower($row->colour);
			}
			$i++;
		}


		$data = array();
		
		// Add populated statistics to the output array
		if ($homeShots != "") {
            $shotsWidths = $this->getBarWidths($homeShots, $awayShots, $homeColour, $awayColour);
            $shots = array("Shots At Goal", $homeShots, $awayShots, $shotsWidths[0], $shotsWidths[1], $shotsWidths[2], $shotsWidths[3]);
			$data[] = $shots;
		}
		if ($homeOnTarget != "") {
            $onTargetWidths = $this->getBarWidths($homeOnTarget, $awayOnTarget, $homeColour, $awayColour);
            $on_target = array("Shots On Target", $homeOnTarget, $awayOnTarget, $onTargetWidths[0], $onTargetWidths[1], $onTargetWidths[2], $onTargetWidths[3]);
			$data[] = $on_target;
		}
		if ($homePossession != "") {
            $possessionWidths = $this->getBarWidths($homePossession, $awayPossession, $homeColour, $awayColour);
            $possession = array("Possession", $homePossession . "%", $awayPossession . "%", $possessionWidths[0], $possessionWidths[1], $possessionWidths[2], $possessionWidths[3]);
			$data[] = $possession;
		}
		if ($homeTa != "") {
            $taWidths = $this->getBarWidths($homeTa, $awayTa, $homeColour, $awayColour);
            $ta = array("Territorial Advantage", $homeTa, $awayTa, $taWidths[0], $taWidths[1], $taWidths[2], $taWidths[3]);
			$data[] = $ta;
		}
		if ($homeFouls != "") {
            $foulsWidths = $this->getBarWidths($homeFouls, $awayFouls, $homeColour, $awayColour);
            $fouls = array("Fouls", $homeFouls, $awayFouls, $foulsWidths[0], $foulsWidths[1], $foulsWidths[2], $foulsWidths[3]);
			$data[] = $fouls;
		}
		if ($homeCorners != "") {
            $cornersWidths = $this->getBarWidths($homeCorners, $awayCorners, $homeColour, $awayColour);
            $corners = array("Corners", $homeCorners, $awayCorners, $cornersWidths[0], $cornersWidths[1], $cornersWidths[2], $cornersWidths[3]);
			$data[] = $corners;
		}
		if ($homeOffside != "") {
            $offsideWidths = $this->getBarWidths($homeOffside, $awayOffside, $homeColour, $awayColour);
            $offside = array("Offsides", $homeOffside, $awayOffside, $offsideWidths[0], $offsideWidths[1], $offsideWidths[2], $offsideWidths[3]);
			$data[] = $offside;
		}		
		if ($homeSaves != "") {
            $savesWidths = $this->getBarWidths($homeSaves, $awaySaves, $homeColour, $awayColour);
            $saves = array("Saves", $homeSaves, $awaySaves, $savesWidths[0], $savesWidths[1], $savesWidths[2], $savesWidths[3]);
			$data[] = $saves;
		}
		if ($homeYellowCards != "") {
            $yellowCardsWidths = $this->getBarWidths($homeYellowCards, $awayYellowCards, $homeColour, $awayColour);
            $yellow_cards = array("Yellow Cards", $homeYellowCards, $awayYellowCards, $yellowCardsWidths[0], $yellowCardsWidths[1], $yellowCardsWidths[2], $yellowCardsWidths[3]);
			$data[] = $yellow_cards;
		}
		if ($homeRedCards != "") {
            $redCardsWidths = $this->getBarWidths($homeRedCards, $awayRedCards, $homeColour, $awayColour);
            $red_cards = array("Red Cards", $homeRedCards, $awayRedCards, $redCardsWidths[0], $redCardsWidths[1], $redCardsWidths[2], $redCardsWidths[3]);
			$data[] = $red_cards;
		}

		return $data;
	}
	
	/**
	 * Calculate the widths and get the colours of the bars
	 *
	 */
	function getBarWidths($homeValue, $awayValue, $homeColour, $awayColour)
	{
		$homeWidth = 0;
		$awayWidth = 0;
		$homeZeroWidth = 0;
		$awayZeroWidth = 0;
	
		$totalCount = $homeValue + $awayValue;
	
		if ($totalCount == 0){
			$homeWidth = 150;
			$awayWidth = 150;
		}
		else{
			if ($homeValue == 0){
				$homeColour = $awayColour;
				$homeWidth = 150;
				$awayWidth = 150;
			}
			else if ($awayValue == 0){
				$awayColour = $homeColour;
				$homeWidth = 150;
				$awayWidth = 150;
			}
			else{
				$homeWidth = round((300 * $homeValue / $totalCount),0);
				$awayWidth = 300 - $homeWidth;
			}
		}
		
		return array($homeWidth, $awayWidth, $homeColour, $awayColour);
	}

	/**
	 * Get competition match round table
	 *
	 * @return object
	 */
	public function getMatchRoundTable()
	{
		$tableData = array();

        $competitionTable = CompetitionTable::where('competition_id', '=', $this->competition->id)->where('round_id', '=', $this->competitionRound->id)->firstOrFail();

		// Loop through each team in the group
		$teams = $competitionTable->teams()->get();
		$tableData = $this->getTableData($teams, $competitionTable, $teams);
		
		// Sort them by points, Goal difference, goals scored
		usort($tableData, array($this, 'sortByGoalDifference'));
		
		
		// If position is determined by head to head instead of goal difference
		if ($competitionTable->head_to_head == 1) {
			
			$newArray = array();
			
			// Group teams with the same points 
			$arr = array();
			foreach($tableData as $item){
			   $arr[$item[7]][$item[11]] = $item;
			}
			krsort($arr, SORT_NUMERIC);
			
			
			// Go Through each group of points
			foreach ($arr as $item) {
				
				if (count($item) > 1) {
					// Get objects of grouped teams
					$tempTableData = array();
					$teams2 = $competitionTable->teams()->whereIn('team_id', array_keys($item))->get();
						
					// compare results between teams with the same points
					$tempTableData = $this->getTableData($teams2, $competitionTable, $teams);
					
					// Sort them by points, Goal difference, goals scored
					usort($tempTableData, array($this, 'sortByGoalDifference'));
					
					foreach ($tempTableData as $row) {
						$newArray[] = $row[0];
					}
				}
				else {
					foreach ($item as $row) {
						$newArray[] = $row[0];
					}			
				}
			}
			
			// Loop through new order of teams and assign their teamData arrays to the new array in the new order.
			$newTableArray = array();
			foreach ($newArray as $newTeam){
				foreach($tableData as $item){
					if ($item[0] == $newTeam) {
						$newTableArray[] = $item;
					}
				}
			}
			
			$tableData = $newTableArray;			
		}

		return $tableData;
	}
	
	
	/**
	 * Compare group of teams in a table in a particular competition
	 *
	 * @return $tableData array
	 */	
	function getTableData($teams, $competitionTable, $allTeams) 
	{
		
		// Get Ids of every team in group
		$allTeamIds = array();
		foreach ($allTeams as $team) {
			$allTeamIds[] = $team->team_id;
		}		

		$totalForArr = array();
		$totalAgainstArr = array();
		
		// loop through every team to get total goals
		foreach ($allTeams as $team) {
			$totalForArr[$team->team_id] = 0;
			$totalAgainstArr[$team->team_id] = 0;
			
			// Home Games
			$homeResults = TableResult::where('competition_table_id', '=', $competitionTable->id)
				->where('home_team_id', '=', $team->team_id)
				->whereIn('away_team_id', $allTeamIds)
				->where('match_round', '<=', $this->match_round)
				->where('home_goals', '<>', 'P')
				->get();
			
			foreach ($homeResults as $result) {
				$totalForArr[$team->team_id] += $result->home_goals;
				$totalAgainstArr[$team->team_id] += $result->away_goals;
			}
			
			// Away Games
			$awayResults = TableResult::where('competition_table_id', '=', $competitionTable->id)
				->where('away_team_id', '=', $team->team_id)
				->whereIn('home_team_id', $allTeamIds)
				->where('match_round', '<=', $this->match_round)
				->where('away_goals', '<>', 'P')
				->get();
			
			foreach ($awayResults as $result) {
				$totalForArr[$team->team_id] += $result->away_goals;
				$totalAgainstArr[$team->team_id] += $result->home_goals;
			}
		}
		
		
		// Get Ids of teams that are being compared
		$teamIds = array();
		foreach ($teams as $team) {
			$teamIds[] = $team->team_id;
		}
		
		// loop through each team being compared
        $tableData = array();
		foreach ($teams as $team) {
			
			$played = 0;
			$won = 0;
			$drew = 0;
			$lost = 0;
			$for = 0;
			$against = 0;
			$points = 0;
			
			
			// Home Games
			$homeResults = TableResult::where('competition_table_id', '=', $competitionTable->id)
				->where('home_team_id', '=', $team->team_id)
				->whereIn('away_team_id', $teamIds)
				->where('match_round', '<=', $this->match_round)
				->where('home_goals', '<>', 'P')
				->get();
			
			foreach ($homeResults as $result) {
				$played++;
				
				if ($result->home_goals > $result->away_goals){
					$won++;	
					$points += $competitionTable->win_points;
				}
				elseif ($result->home_goals == $result->away_goals){
					$drew++;
					$points++;
				}
				else {
					$lost++;	
				}
				
				$for += $result->home_goals;
				$against += $result->away_goals;
			}
			
			
			// Away Games
			$awayResults = TableResult::where('competition_table_id', '=', $competitionTable->id)
				->where('away_team_id', '=', $team->team_id)
				->whereIn('home_team_id', $teamIds)
				->where('match_round', '<=', $this->match_round)
				->where('away_goals', '<>', 'P')
				->get();
			
			foreach ($awayResults as $result) {
				$played++;
				
				if ($result->away_goals > $result->home_goals){
					$won++;	
					$points += $competitionTable->win_points;
				}
				elseif ($result->home_goals == $result->away_goals){
					$drew++;
					$points++;
				}
				else {
					$lost++;	
				}
				
				$for += $result->away_goals;
				$against += $result->home_goals;
			}
			
			$totalFor = $totalForArr[$team->team_id];
			$totalAgainst = $totalAgainstArr[$team->team_id];

			$rowData = array($team->short_team, $played, $won, $drew, $lost, $for, $against, $points, ($for - $against), $totalFor, ($totalFor - $totalAgainst), $team->team_id);
			
			$tableData[] = $rowData;
		}	

		return $tableData;
	}
	
	/**
	 * Sort teams by goal difference
	*/
	function sortByGoalDifference($a, $b) 
	{
		$points = $b[7] - $a[7];
		if ($points == 0){
			$gd = $b[8] - $a[8];
			if ($gd == 0){
				$for = $b[5] - $a[5];
				if ($for == 0){
					$totalgd = $b[10] - $a[10];
					if ($totalgd == 0){
						$totalfor = $b[9] - $a[9];
						if ($totalfor == 0){
							return strcmp($a[0], $b[0]);
						}
						else {
							return $totalfor;	
						}
					}
					else {
						return $totalgd;
					}
				}
				else {
					return $for;
				}
			}
			else {
				return $gd;	
			}
		}
		else {
			return $points;
		}
	}


	/**
	 * Get competition match round results for current match
	 *
	 * @return array
	 */
	public function getMatchRoundResults()
	{
        $competitionTable = CompetitionTable::where('competition_id', '=', $this->competition->id)->where('round_id', '=', $this->competitionRound->id)->firstOrFail();
		$results = TableResult::join('competitiontables', 'competitiontables.id', '=', 'tableresults.competition_table_id')
			->where('competition_table_id', '=', $competitionTable->id)
			->where('match_round', '=', $this->match_round)
			->orderBy('match_date', 'asc')
			->get();

		$prevDate = "";
		$data = array();
		foreach ($results as $result) {

		    $matchDate = $result->match_date->format('j F Y');
		    $date = "";
		    if ($matchDate != $prevDate) {
		        $date = $matchDate;
            }

		    $data[] = ["date" => $date, "result" => $result->result];

		    $prevDate = $matchDate;
        }

		return $data;
	}	

	
	/**
	 * Get Strip Info for a match
	 *
	 * @return string
	 */
	public function getStripInfo()
	{
		if ($this->strips()->first()->match_note != "") {
			return true;	
		}
		else {
			return false;
		}
	}


	/**
	 * Get search parameters
	 *
	 * @param  string  $parameters  The search parameters in a querystring 
	 * @return  array
	 */
    public function getSearchParameters($parameters)
    {
		$data = array();
		
		$data['opponent'] = "-";
		$data['date_from'] = "-";
		$data['date_to'] = "-";
		$data['venue'] = "-";
		$data['result'] = "-";
		$data['match_type'] = "-";
		
		$parameterSet = explode("&", $parameters);
		
		foreach ($parameterSet as $parameterItem) {
			$parametervalues = explode("=", $parameterItem);
			
			if ($parametervalues[0] == "opponent") {
				$data['opponent'] = Opponent::find($parametervalues[1])->name;
			}		
			if ($parametervalues[0] == "datefrom") {
				$data['date_from'] = date_format(date_create($parametervalues[1]), 'jS F Y');
			}
			if ($parametervalues[0] == "dateto") {
				$data['date_to'] = date_format(date_create($parametervalues[1]), 'jS F Y');
			}			
			if ($parametervalues[0] == "venue") {
				if ($parametervalues[1] == "H") {
					$data['venue'] = "Home";	
				}
				elseif ($parametervalues[1] == "A") {
					$data['venue'] = "Away";	
				}
				else {
					$data['venue'] = "Neutral";	
				}					
			}
			if ($parametervalues[0] == "result") {
				if ($parametervalues[1] == "W") {
					$data['result'] = "Win";	
				}
				elseif ($parametervalues[1] == "L") {
					$data['result'] = "Lose";	
				}
				else {
					$data['result'] = "Draw";	
				}	
			}
			if ($parametervalues[0] == "matchtype") {
				$data['match_type'] = ($parametervalues[1] == "C") ? "Competitive" : "Friendly";
			}				
		}
			
		return $data;
    }



    /**
     * Get the match record numbers
     *
     * @param $results
     * @return array $matchNumbers
     */
    public function getMatchRecordNumbers($results)
    {
        // Match Numbers
        $for = 0;
        $against = 0;
        foreach ($results->get() as $match) {
            $resultArray = explode(" ", $match->result);
            $goals = explode("-", $resultArray[1]);

            $for += intval($goals[0]);
            $against += intval($goals[1]);
        }

        $goal_difference = $for - $against;

        $matchNumbers = array(
            'played' => with(clone $results)->count(),
            'won' => with(clone $results)->won()->count(),
            'drew' => with(clone $results)->drew()->count(),
            'lost' => with(clone $results)->lost()->count(),
            'for' => $for,
            'against' => $against,
            'goal_difference' => (($goal_difference > 0) ? "+" : "") . $goal_difference,
            'win_percent' => ($results->count() > 0) ? round(100 * with(clone $results)->won()->count() / with(clone $results)->count(), 2) : 0
        );

        return $matchNumbers;
    }

}
