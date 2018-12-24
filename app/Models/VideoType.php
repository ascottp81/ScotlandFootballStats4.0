<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoType extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'videotype';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','url'];


    /* RELATIONSHIPS */

    /**
     * A type has many videos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany('App\Models\Video');
    }

}
