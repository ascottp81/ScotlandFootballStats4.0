<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StripMatch extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stripmatchdetails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['match_id','strip_id','scotland_shorts','opponent_shirt','opponent_shorts','goalkeeper_top','match_note'];



    /* RELATIONSHIPS */

    /**
     * A strip match belongs to a match
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function match()
    {
        return $this->belongsTo('App\Models\Match', 'match_id');
    }

    /**
     * A strip match belongs to a strip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function strip()
    {
        return $this->belongsTo('App\Models\Strip', 'strip_id');
    }
}
