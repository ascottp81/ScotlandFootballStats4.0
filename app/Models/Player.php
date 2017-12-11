<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

use App\Classes\GettyImage;
use Illuminate\Support\Facades\DB;

class Player extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['surname', 'firstname', 'debut_year', 'position', 'date_of_birth', 'birthplace', 'notes', 'retired', 'getty_image'];
	
	/**
     * Additional fields to treat as Carbon instances
     * 
     * @var array
     */
    protected $dates = ['date_of_birth'];

	
	
	
	/* RELATIONSHIPS */

    /**
     * A Player has many appearances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appearances()
    {
        return $this->hasMany('App\Models\Appearance', 'player_id');
    }
	
	
	
	
	/* ACCESSORS */

	/**
	 * Get fullname
	 *
	 * @return string
	 */
	public function getFullnameAttribute(): string
	{
		return $this->firstname . " " . $this->surname;
	}
	
	/**
	 * Get initialed name
	 *
	 * @return string
	 */
	public function getShortnameAttribute(): string
	{
		return substr($this->firstname, 0, 1) . " " . $this->surname;
	}

    /**
     * Get fullname in a sort format
     *
     * @return string
     */
    public function getFullnameSortAttribute(): string
    {
        return $this->surname . ", " . $this->firstname;
    }


    /**
	 * Get cap count
	 *
	 * @return int
	 */
	public function getCapsAttribute(): int
	{
		return $this->appearances()->count();
	}
	
	/**
	 * Get goal count
	 *
	 * @return int
	 */
	public function getGoalsAttribute(): int
	{
		return (int) $this->appearances()->sum('goals');
	}
	
	/**
	 * Get penalty count
	 *
	 * @return int
	 */
	public function getPensAttribute(): int
	{
		return (int) $this->appearances()->sum('penalties');
	}
	
	/**
	 * Get player's last year
	 *
	 * @return int
	 */
	public function getLastYearAttribute(): int
	{
		$player = Appearance::join('matches','matches.id','=','appearances.match_id')
			->select(DB::Raw('YEAR(MAX(date)) as max_year'))
			->where('player_id','=',$this->id)
			->firstOrFail();
		
		return (int) $player->max_year;
	}
	
	/**
	 * Get player's years
	 *
	 * @return string
	 */
	public function getYearsAttribute(): string
	{
		if ($this->debut_year == $this->last_year) {
			return (string) $this->debut_year;
		}
		else {
			return $this->debut_year . "-" . $this->last_year;	
		}
	}

    /**
     * Get the year a player entered the SFA Hall of Fame
     *
     * @return int
     */
    public function getHofEntryAttribute(): int
    {
        $player = Appearance::join('matches','matches.id','=','appearances.match_id')
            ->where('player_id','=',$this->id)
            ->orderBy('date', 'asc')
            ->skip(49)
            ->limit(1)
            ->firstOrFail();

        return (int) date('Y', strtotime($player->date));
    }
	
	/**
	 * Determine if player is a goalkeeper
	 *
	 * @return bool
	 */
	public function getKeeperAttribute(): bool
	{
		if ($this->appearances()->where('keeper','=',1)->count() > 0) {
			return true;	
		}
		else {
			return false;	
		}
	}
	
	/**
	 * Get number of clean sheets
	 *
	 * @return int
	 */
	public function getCleanSheetsAttribute(): int
	{
		// Get clean sheet appearances where player started
		$shutOuts = $this->join('appearances','players.id','=','appearances.player_id')
			->join('matches','matches.id','=','appearances.match_id')
			->select('players.*','match_id','shirt_no')
			->where('player_id','=',$this->id)
			->where('keeper','=',1)
			->where('result','like','%-0');
			
		$shutOutCount = $shutOuts->count();
		$shutOuts = $shutOuts->get();
		
		// get number of clean sheet appearances where player was substituted
		$substitutions = 0;
		foreach ($shutOuts as $shutOut) {
			$substitutions += Appearance::where('match_id','=',$shutOut->match_id)->where('replaced','=',$shutOut->shirt_no)->count();
		}

		return $shutOutCount - $substitutions;
	}
	
	/**
	 * Get number of starts
	 *
	 * @return int
	 */
	public function getStartsAttribute(): int
	{
		$starts = Appearance::where('player_id','=',$this->id)->where('replaced','=', 0)->count();

		return $starts;
	}
	
	/**
	 * Get number of substitute appearances
	 *
	 * @return int
	 */
	public function getSubAppearancesAttribute(): int
	{
		$subs = Appearance::where('player_id','=',$this->id)->where('replaced','>', 0)->count();

		return $subs;
	}
	
	/**
	 * Get number of appearances as captain
	 *
	 * @return int
	 */
	public function getCaptainCountAttribute(): int
	{
		$count = Appearance::where('player_id','=',$this->id)->where('captain','=', 1)->count();

		return $count;
	}
	
	/**
	 * Get number of yellow cards
	 *
	 * @return int
	 */
	public function getYellowCardsAttribute(): int
	{
		$yellow = $this->appearances()->where('cards','=','Y')->count();
		$yellowRed = $this->appearances()->where('cards','=','YR')->count();
		$redYellow = $this->appearances()->where('cards','=','RY')->count();
		
		return $yellow + $yellowRed + (2 * $redYellow);
	}
	
	/**
	 * Get number of red cards
	 *
	 * @return int
	 */
	public function getRedCardsAttribute(): int
	{
		$red = $this->appearances()->where('cards','=','R')->count();
		$yellowRed = $this->appearances()->where('cards','=','YR')->count();
		$redYellow = $this->appearances()->where('cards','=','RY')->count();
		
		return $red + $yellowRed + $redYellow;
	}
	
	/**
	 * Get player's clubs
	 *
	 * @return string
	 */
	public function getClubsAttribute(): string
	{
		$clubs = Club::join('appearances','appearances.club_id','=','clubs.id')
			->join('matches','matches.id','=','appearances.match_id')
			->select('clubs.*')
			->where('player_id','=',$this->id)
			->groupBy('club_id')
			->orderBy('date')
			->get();

		
		$clubArray = array();
		foreach ($clubs as $club) {
			$clubArray[] = $club->name;
		}
		
		return implode(", ", $clubArray);
	}
	
	/**
	 * Get player url
	 *
	 * @return string
	 */
	public function getUrlAttribute(): string
	{
		return strtolower($this->firstname . "-" . $this->surname);
	}
	
	/**
	 * Get past event text
	 *
	 * @return string
	 */
	public function getPastEventAttribute(): string
	{
		return $this->fullname . " was born on this day in " . $this->birthplace . ".";
	}
	
	/**
	 * Get the player Getty Image
	 *
	 * @return string
	 */
	public function getImageAttribute(): string
	{
		$image = $this->getty_image;
		$gettyImage = new GettyImage($image, 0);
		
		if ($image == "") {
			return '<div class="noImage"><i class="fa fa-user"></i></div>';
		}

		return $gettyImage->outputImage();
	}


	/* FUNCTIONS */

    /**
     * Get the recent top scorers
     *
     * @return Collection
     */
    public function getRecentTopScorers(): Collection
    {
        $topScorers = Player::join('appearances','appearances.player_id','=','players.id')
            ->join('matches','matches.id','=','appearances.match_id')
            ->select('players.*', DB::Raw('SUM(goals) as goalCount'))
            ->where('date', '>=', Carbon::now()->addYears(-3))
            ->havingRaw("SUM(goals) > 1")
            ->groupBy('player_id')
            ->orderBy('goalCount','desc')
            ->orderBy('surname','asc')
            ->orderBy('firstname','asc')
            ->limit(10)
            ->get();

        return $topScorers;
    }

    /**
     * Get the recent top scorers
     *
     * @return Collection
     */
    public function getRecentTopAppearances(): Collection
    {
        $topAppearances = Player::join('appearances','appearances.player_id','=','players.id')
            ->join('matches','matches.id','=','appearances.match_id')
            ->select('players.*', DB::Raw('COUNT(*) as capCount'))
            ->where('date', '>=', Carbon::now()->addYears(-3))
            ->groupBy('player_id')
            ->orderBy('capCount','desc')
            ->orderBy('surname','asc')
            ->orderBy('firstname','asc')
            ->limit(10)
            ->get();

        return $topAppearances;
    }

}
