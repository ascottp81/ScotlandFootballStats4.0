<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fact extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['match_id', 'text'];



    /* RELATIONSHIPS */

    /**
     * A Fact belongs to a Match
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Game', 'match_id');
    }
}
