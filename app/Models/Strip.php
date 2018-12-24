<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Classes\GettyImage;

class Strip extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'strips';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','year_from','year_to','type','colour','match','complete','getty_image','designer','note'];


    /* SCOPES */

    /**
     * Scope query for home strips
     *
     * @param  $query
     */
    public function scopeHome($query)
    {
        $query->where('type','=','Home');
    }

    /**
     * Scope query for away and third strips
     *
     * @param  $query
     */
    public function scopeAwayThird($query)
    {
        $query->whereIn('type',['Away','Third']);
    }


    /* RELATIONSHIPS */

    /**
     * A strip has many matches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany('App\Models\StripMatch', 'strip_id');
    }



    /* ACCESSORS */

    /**
     * Get the strip title
     *
     * @return string
     */
    public function getTitleAttribute(): string
    {
        return $this->type . " (" . $this->year_from . (($this->year_from != $this->year_to)? '-' . $this->year_to : '') . ")";
    }

    /**
     * Get the strip URL
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return strtolower($this->type) . '-' . $this->year_from;
    }

    /**
     * Get the strip Getty Image
     *
     * @return string
     */
    public function getImageAttribute(): string
    {
        $gettyImage = new GettyImage($this->getty_image, 1);

        if ($this->getty_image == "") {
            return '<div class="noImage"><i class="fa fa-user"></i></div>';
        }
        else {
            return $gettyImage->outputImage();
        }
    }
}
