<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Classes\GettyImage;

class Region extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'regions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'getty_image', 'image_text'];



    /* RELATIONSHIPS */

    /**
     * A Region has many opponents
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opponents()
    {
        return $this->hasMany('App\Models\Opponent', 'region_id');
    }


    /* ACCESSORS */

    /**
     * Get the regional Getty Image
     *
     * @return string
     */
    public function getImageAttribute()
    {
        $gettyImage = new GettyImage($this->getty_image, 2);

        return $gettyImage->outputImage();
    }
}
