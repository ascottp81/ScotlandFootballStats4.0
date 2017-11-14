<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchStatistic extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matchstatistics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['match_id', 'team_id', 'colour', 'possession', 'shots', 'on_target', 'fouls','offside','ta','corners','saves','yellow_cards','red_cards','source'];



    /* RELATIONSHIPS */

    /**
     * A match statistic belongs to a match
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo('App\Model\Match', 'match_id');
    }

}
