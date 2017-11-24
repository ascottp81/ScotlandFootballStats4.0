<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Classes\GettyImage;

class Opponent extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'opponents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'memorable_match', 'summary', 'abbr_name', 'region_id', 'years', 'url', 'getty_image'];


    /* RELATIONSHIPS */

    /**
     * An Opponent has many matches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany('App\Models\Match', 'opponent_id');
    }

    /**
     * An opponent belongs to a region
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'region_id');
    }



    /* ACCESSORS */

    /**
     * Get the opponent flag image
     *
     * @return string
     */
    public function getFlagAttribute(): string
    {
        return strtolower(str_replace(" ", "_", $this->name));
    }

    /**
     * Get the opponent Getty Image
     *
     * @return string
     */
    public function getImageAttribute(): string
    {
        $gettyImage = new GettyImage($this->getty_image, 2);

        return $gettyImage->outputImage();
    }

}
