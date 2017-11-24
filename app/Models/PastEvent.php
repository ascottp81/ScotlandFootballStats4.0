<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PastEvent extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pastevents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date','summary'];

    /**
     * Additional fields to treat as Carbon instances
     *
     * @var array
     */
    protected $dates = ['date'];


    /* SCOPES */

    /**
     * Scope query for current day event
     *
     * @param  $query
     */
    public function scopeCurrentDay($query)
    {
        $query->whereDay('date', '=', date('d'))->whereMonth('date', '=', date('m'));
    }


    /* FUNCTIONS */

    /**
     * Get an array of today's events
     *
     * @return  array
     */
    public function getTodayEvents(): array
    {
        $data = array();
        $count = 0;

        $events = $this->currentDay()->orderBy(DB::Raw('RAND()'))->limit(2)->get();
        foreach ($events as $event) {
            $data[] = ["year" => $event->date->format('Y'), "summary" => $event->summary];
            $count++;
        }

        if ($count < 2) {
            $matches = Match::whereDay('date', '=', date('d'))->whereMonth('date', '=', date('m'))
                ->whereNotNull('result')
                ->orderBy(DB::Raw('RAND()'))
                ->limit(2)
                ->get();
            foreach ($matches as $match) {
                if ($count < 2) {
                    $data[] = ["year" => $match->date->format('Y'), "summary" => $match->past_event];
                    $count++;
                }
            }
        }

        if ($count < 2) {
            $players = Player::whereDay('date_of_birth', '=', date('d'))->whereMonth('date_of_birth', '=', date('m'))
                ->orderBy(DB::Raw('RAND()'))
                ->limit(2)
                ->get();
            foreach ($players as $player) {
                if ($count < 2) {
                    $data[] = ["year" => $player->date_of_birth->format('Y'), "summary" => $player->past_event];
                    $count++;
                }
            }
        }

        if ($count < 2) {
            $managers = Manager::whereDay('born', '=', date('d'))->whereMonth('born', '=', date('m'))
                ->orderBy(DB::Raw('RAND()'))
                ->limit(2)
                ->get();
            foreach ($managers as $manager) {
                if ($count < 2) {
                    $data[] = ["year" => $manager->born->format('Y'), "summary" => $manager->past_event];
                    $count++;
                }
            }
        }

        return $data;
    }
}
