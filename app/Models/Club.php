<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clubs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];



    /* RELATIONSHIPS */

    /**
     * A Player has many appearances
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appearances()
    {
        return $this->hasMany('App\Models\Lineup', 'club_id');
    }
}
