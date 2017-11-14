<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Classes\GettyImage;

class History extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','period','first_year','summary','url','getty_image','famous_matches'];



    /* RELATIONSHIPS */

    /**
     * A Chapter has many pages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany('App\Models\HistoryPage', 'history_id');
    }


    /* ACCESSORS */

    /**
     * Get the Getty Image
     *
     * @return string
     */
    public function getImageAttribute()
    {
        $gettyImage = new GettyImage($this->getty_image, 0);

        return $gettyImage->outputImage();
    }

    /**
     * Get the famous matches
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFamousMatchesAttribute($value)
    {
        $famousMatches = explode(",", $value);

        $match = new Match();
        $matches = $match->whereIn('id', $famousMatches)->orderBy('date','asc')->get();

        return $matches;
    }
}
