<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use App\Classes\GettyImage;

class Manager extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'managers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['surname','firstname','name_extension','from','to','took_charge','appointed','reign_ended','reason','born','birthplace','died','summary','caretaker','appointed_first','assistants','url','getty_image'];
    /**
     * Additional fields to treat as Carbon instances
     *
     * @var array
     */
    protected $dates = ['born'];


    /* RELATIONSHIPS */

    /**
     * A manager has many matches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany('App\Models\Match', 'manager_id');
    }


    /* ACCESSORS */

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullnameAttribute()
    {
        return $this->firstname . " " . $this->surname;
    }

    /**
     * Get extended fullname
     *
     * @return string
     */
    public function getExtendedFullnameAttribute()
    {
        if ($this->name_extension == NULL) {
            return $this->fullname;
        }
        elseif ($this->name_extension == "Sir") {
            return "Sir " . $this->fullname;
        }
        else {
            return $this->fullname . " " . $this->name_extension;
        }
    }

    /**
     * Get the player Getty Image
     *
     * @return string
     */
    public function getImageAttribute()
    {
        $image = $this->getty_image;
        $gettyImage = new GettyImage($image, 0);

        if ($image == "") {
            return '<div class="noImage"><i class="fa fa-user"></i></div>';
        }

        return $gettyImage->outputImage();
    }

    /**
     * Get manager's years
     *
     * @return string
     */
    public function getYearsAttribute()
    {
        if ($this->from == $this->to) {
            return $this->from;
        }
        else {
            return $this->from . "-" . $this->to;
        }
    }


    /**
     * Get past event text
     *
     * @return string
     */
    public function getPastEventAttribute()
    {
        return $this->fullname . " was born on this day in " . $this->birthplace . ".";
    }
}
