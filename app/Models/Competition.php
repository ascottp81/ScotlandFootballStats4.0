<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competition extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'competitions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['competition_type_id', 'year', 'stage', 'name', 'won', 'shared', 'qualified', 'withdrew'];



    /* SCOPES */

    /**
     * Scope query for competitions won
     *
     * @param  $query
     */
    public function scopeWon($query)
    {
        $query->where('won','=','1');
    }

    /**
     * Scope query for competitions shared
     *
     * @param  $query
     */
    public function scopeShared($query)
    {
        $query->where('shared','=','1');
    }

    /**
     * Scope query for competitions qualified
     *
     * @param  $query
     */
    public function scopeQualified($query)
    {
        $query->where('qualified','=','1');
    }

    /**
     * Scope query for competitions withdrawn from
     *
     * @param  $query
     */
    public function scopeWithdrew($query)
    {
        $query->where('withdrew','=','1');
    }

    /**
     * Scope query for qualifers
     *
     * @param  $query
     */
    public function scopeQualifiers($query)
    {
        $query->where('stage','=','Qualifiers');
    }

    /**
     * Scope query for finals
     *
     * @param  $query
     */
    public function scopeFinals($query)
    {
        $query->where('stage','=','Finals');
    }


    /* RELATIONSHIPS */

    /**
     * A competition belongs to a competition type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Models\CompetitionType', 'competition_type_id');
    }

    /**
     * A competition has many tables
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tables()
    {
        return $this->hasMany('App\Models\CompetitionTable');
    }


    /* ACCESSORS */

    /**
     * Get the competition URL
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        if ($this->stage == "") {
            return $this->year;
        }
        else {
            return $this->year . "-" . strtolower($this->stage);
        }
    }

    /**
     * Get the generic competition title
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        if ($this->stage == "") {
            return $this->year;
        }
        else {
            return $this->year . " " . $this->stage;
        }
    }

    /**
     * Get the competition status icon class
     *
     * @return string
     */
    public function getClassAttribute()
    {
        $class = "";
        if ($this->won == 1)
            $class = " competitionWon";
        elseif ($this->shared == 1)
            $class = " competitionShared";
        elseif ($this->qualified == 1)
            $class = " competitionQualified";

        return $class;
    }
}
