<?php

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
    protected $fillable = ['competition_id', 'round_id', 'group_name', 'comment', 'home', 'head_to_head', 'win_points'];



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
        return $this->hasMany('App\Models\TableResult');
    }


    /* ACCESSORS */

    /**
     * Get the home table fixtures
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getHomeTableFixturesAttributes()
    {
        $round1 = 0;
        $round2 = 0;

        $nextFixture = CompetitionTable::where('home', '=', '1')->results()
            ->where('date', '>=', Carbon::now())
            ->orderBy('date', 'ASC')
            ->limit(1)
            ->get();

        foreach ($nextFixture as $fix) {
            $round1 = $fix->match_round;
            $round2 = ($fix->match_round) + 1;
        }

        return $this->results()->whereIn('match_round',array($round1, $round2))->orderBy('date', 'asc')->get();
    }

    /**
     * Get the home table results
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getHomeTableResultsAttributes()
    {
        $round1 = 0;
        $round2 = 0;

        $lastResult = CompetitionTable::where('home', '=', '1')->results()
            ->where('date', '<=', Carbon::now())
            ->orderBy('date', 'DESC')
            ->limit(1)
            ->get();

        foreach ($lastResult as $res) {
            $round1 = $res->match_round;
            $round2 = ($res->match_round) - 1;
        }

        return $this->results()->whereIn('match_round',array($round1, $round2))->orderBy('match_date', 'desc')->get();
    }

    /**
     * Determine if the home table is complete
     *
     * @return boolean
     */
    public function getCompleteAttribute()
    {
        $lastResult = CompetitionTable::where('home', '=', '1')->results()->orderBy('date', 'DESC')->firstOrFail();

        if ($lastResult->date >= Carbon::now()) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Determine if the table matches are fixtures and/or results
     *
     * @return boolean
     */
    public function getFixtureResultTextAttribute()
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
     * Get the segmented table comments
     *
     * @return boolean
     */
    public function getCommentsAttribute()
    {
        $comments = explode(".", $this->comment);
        array_pop($comments);

        $commentItems = array();
        foreach ($comments as $comment) {
            $commentItems[] = $comment;
        }

        return $commentItems;
    }
}
