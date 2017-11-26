<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Ranking extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rankings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'ranking', 'europe', 'points'];

    /**
     * Additional fields to treat as Carbon instances
     *
     * @var array
     */
    protected $dates = ['date'];



    /* ACCESSORS */

    /**
     * Get the Current Ranking
     *
     * @return Ranking
     */
    public function getCurrentAttribute(): Ranking
    {
        return Ranking::where('ranking','>',0)->orderBy('date','desc')->firstOrFail();
    }

    /**
     * Get the Highest Rankings
     *
     * @return \stdClass
     */
    public function getHighestAttribute(): \stdClass
    {
        $ranking = Ranking::where('ranking','>',0)->orderBy('ranking','asc')->orderBy('date','asc')->firstOrFail();
        $zonal = Ranking::where('europe','>',0)->orderBy('europe','asc')->orderBy('date','asc')->firstOrFail();

        $europe = (object) ["ranking" => $zonal->europe, "date" => $zonal->date];
        $array = ["ranking" => $ranking->ranking, "date" => $ranking->date, "europe" => $europe ];

        return (object) $array;
    }

    /**
     * Get the Lowest Rankings
     *
     * @return \stdClass
     */
    public function getLowestAttribute(): \stdClass
    {
        $ranking = Ranking::where('ranking','>',0)->orderBy('ranking','desc')->orderBy('date','asc')->firstOrFail();
        $zonal = Ranking::where('europe','>',0)->orderBy('europe','desc')->orderBy('date','asc')->firstOrFail();

        $europe = (object) ["ranking" => $zonal->europe, "date" => $zonal->date];
        $array = ["ranking" => $ranking->ranking, "date" => $ranking->date, "europe" => $europe ];

        return (object) $array;
    }

    /**
     * Get the Next Ranking Date
     *
     * @return string
     */
    public function getNextRankingAttribute(): string
    {
        $next = Ranking::where('ranking','=',0)->orWhereNull('ranking')->orderBy('date','asc');
        if ($next->count() == 0) {
            return "Unknown";
        }
        else {
            return $next->firstOrFail()->date->format('j F Y');
        }
    }

    /**
     * Get the highest rise and fall stats
     *
     * @return array
     */
    public function getRiseFallAttribute(): array
    {
        $previousRanking = 0;
        $previousZonalRanking = 0;
        $greatestRise = 0;
        $greatestZonalRise = 0;
        $greatestFall = 0;
        $greatestZonalFall = 0;
        $rankings = Ranking::where('ranking','>',0)->orderBy('date','asc')->get();
        foreach ($rankings as $ranking) {
            if ($previousRanking > 0) {
                if (($ranking->ranking - $previousRanking) > $greatestFall) {
                    $greatestFall = $ranking->ranking - $previousRanking;
                    $greatestFallDate = $ranking->date->format('M Y');
                }
                elseif (($previousRanking - $ranking->ranking) > $greatestRise) {
                    $greatestRise = $previousRanking - $ranking->ranking;
                    $greatestRiseDate = $ranking->date->format('M Y');
                }

                if (($ranking->europe - $previousZonalRanking) > $greatestZonalFall) {
                    $greatestZonalFall = $ranking->europe - $previousZonalRanking;
                    $greatestZonalFallDate = $ranking->date->format('M Y');
                }
                elseif (($previousZonalRanking - $ranking->europe) > $greatestZonalRise) {
                    $greatestZonalRise = $previousZonalRanking - $ranking->europe;
                    $greatestZonalRiseDate = $ranking->date->format('M Y');
                }
            }
            $previousRanking = $ranking->ranking;
            $previousZonalRanking = $ranking->europe;
        }

        $riseFall = array(
            'greatestRise' => $greatestRise,
            'greatestRiseDate' => $greatestRiseDate,
            'greatestFall' => $greatestFall,
            'greatestFallDate' => $greatestFallDate,
            'greatestZonalRise' => $greatestZonalRise,
            'greatestZonalRiseDate' => $greatestZonalRiseDate,
            'greatestZonalFall' => $greatestZonalFall,
            'greatestZonalFallDate' => $greatestZonalFallDate
        );

        return $riseFall;
    }

    /**
     * Get slider scale values
     *
     * @return Collection
     */
    public function getSliderScaleAttribute(): Collection
    {
        $noOfLabels = 10;
        $sectorSize = doubleval($this->current->id - 1) / $noOfLabels;

        $sectorIndex = array();
        $sectorIndex[0] = 1;
        for ($i = 1; $i < $noOfLabels; $i++){
            $sectorIndex[$i] = 1 + round($sectorSize * $i);
        }
        $sectorIndex[$noOfLabels] = $this->current->id;

        $scale = Ranking::whereIn('id', $sectorIndex)->orderBy('id','asc')->get();

        return $scale;
    }

    /**
     * Get the monthly records, in 3 columns
     *
     * @return array
     */
    public function getMonthlyRecordsAttribute(): array
    {
        $columnSize = ceil($this->current->id / 3.00);
        $rankings1 = Ranking::orderBy('date','asc')->limit($columnSize)->get();
        $rankings2 = Ranking::orderBy('date','asc')->offset($columnSize)->limit($columnSize)->get();
        $rankings3 = Ranking::where('ranking','>','0')->whereNotNull('ranking')->orderBy('date','asc')->offset(2 * $columnSize)->limit($columnSize)->get();

        return [$rankings1, $rankings2, $rankings3];
    }

}
