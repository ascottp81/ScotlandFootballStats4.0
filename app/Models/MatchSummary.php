<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchSummary extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matchsummary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['match_id', 'content'];



    /* RELATIONSHIPS */

    /**
     * A Summary belongs to a Match
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function match()
    {
        return $this->belongsTo('App\Models\Match', 'match_id');
    }
}
