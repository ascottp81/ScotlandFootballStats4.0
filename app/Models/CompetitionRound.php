<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionRound extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'competitionrounds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','order'];


    /* RELATIONSHIPS */

    /**
     * A round has many matches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany('App\Models\Match');
    }

    /**
     * A round has many competition tables
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tables()
    {
        return $this->hasMany('App\Models\CompetitionTable');
    }

}