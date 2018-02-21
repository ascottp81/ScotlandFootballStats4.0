<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'caretaker' => 'boolean',
        'appointed_first' => 'boolean'
    ];


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
    public function getFullnameAttribute(): string
    {
        return $this->firstname . " " . $this->surname;
    }

    /**
     * Get extended fullname
     *
     * @return string
     */
    public function getExtendedFullnameAttribute(): string
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
     * Get fullname in a sort format
     *
     * @return string
     */
    public function getFullnameSortAttribute(): string
    {
        return $this->surname . ", " . $this->firstname;
    }

    /**
     * Get the manager Getty Image
     *
     * @return string
     */
    public function getImageAttribute(): string
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
    public function getYearsAttribute(): string
    {
        if ($this->from == $this->to) {
            return (string) $this->from;
        }
        else {
            return $this->from . "-" . $this->to;
        }
    }

    /**
     * Get manager's match count
     *
     * @return int
     */
    public function getMatchCountAttribute(): int
    {
        return Match::where('manager_id','=',$this->id)->count();
    }

    /**
     * Get manager's earliest match date
     *
     * @return string
     */
    public function getMinDateAttribute(): string
    {
        if ($this->match_count == 0) {
            if ($this->appointed != NULL) {
                return date('Y-m-d', strtotime($this->appointed));
            }
            else {
                return date('Y-m-d', strtotime($this->took_charge));
            }
        }
        return Match::where('manager_id','=',$this->id)->orderBy('date','asc')->firstOrFail()->date->format('Y-m-d');
    }

    /**
     * Get manager's latest match date
     *
     * @return string
     */
    public function getMaxDateAttribute(): string
    {
        if ($this->match_count == 0) {
            if ($this->appointed != NULL) {
                return date('Y-m-d', strtotime($this->appointed));
            }
            else {
                return date('Y-m-d', strtotime($this->took_charge));
            }
        }
        return Match::where('manager_id','=',$this->id)->orderBy('date','desc')->firstOrFail()->date->format('Y-m-d');
    }

    /**
     * Get manager's win percentage
     *
     * @return string
     */
    public function getWinPercentageAttribute(): string
    {
        if ($this->match_count == 0) {
            return '0.00';
        }

        $wins = Match::where('manager_id','=',$this->id)->won()->count();
        $number = 100 * $wins / $this->match_count;

        return number_format((float)$number, 2, '.', '');
    }


    /**
     * Get past event text
     *
     * @return string
     */
    public function getPastEventAttribute(): string
    {
        return $this->fullname . " was born on this day in " . $this->birthplace . ".";
    }
}
