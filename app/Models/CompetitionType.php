<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;


class CompetitionType extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'competitiontype';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'priority', 'summary', 'short_summary', 'status', 'url', 'getty_images', 'local_getty_images'];


    /* RELATIONSHIPS */

    /**
     * A competition type has many competitions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function competitions()
    {
        return $this->hasMany('App\Models\Competition', 'competition_type_id');
    }



    /* ACCESSORS */

    /**
     * Get competition years
     *
     * @return string
     */
    public function getYearsAttribute(): string
    {
        $competitions = $this->competitions()
            ->select(DB::Raw('MAX(year) as max_year'), DB::Raw('MIN(year) as min_year'))
            ->firstOrFail();

        if ($competitions->min_year == $competitions->max_year) {
            return (string) $competitions->min_year;
        }
        else {
            return $competitions->min_year . " - " . $competitions->max_year;
        }
    }

    /**
     * Get match numbers for each competition type
     *
     * @return array
     */
    public function getMatchNumbersAttribute(): array
    {
        if ($this->status == "C") {

            // Qualification goal numbers
            $for_q = 0;
            $against_q = 0;

            $competitionMatches = Match::CompetitionType($this->id)->qualifiers()->get();
            foreach($competitionMatches as $match) {
                $resultArray = explode(" ", $match->result);
                $goals = explode("-", $resultArray[1]);

                $for_q += intval($goals[0]);
                $against_q += intval($goals[1]);
            }
            $goal_difference_q = $for_q - $against_q;


            // Finals goal numbers
            $for_f = 0;
            $against_f = 0;
            $competitionMatches = Match::CompetitionType($this->id)->finals()->get();
            foreach($competitionMatches as $match) {
                $resultArray = explode(" ", $match->result);
                $goals = explode("-", $resultArray[1]);

                $for_f += intval($goals[0]);
                $against_f += intval($goals[1]);
            }
            $goal_difference_f = $for_f - $against_f;


            // competitive numbers
            $matchNumbers = array(
                'played_q' => Match::CompetitionType($this->id)->qualifiers()->count(),
                'won_q' => Match::CompetitionType($this->id)->qualifiers()->won()->count(),
                'drew_q' => Match::CompetitionType($this->id)->qualifiers()->drew()->count(),
                'lost_q' => Match::CompetitionType($this->id)->qualifiers()->lost()->count(),
                'for_q' => $for_q,
                'against_q' => $against_q,
                'goal_difference_q' => (($goal_difference_q > 0) ? "+" : "") . $goal_difference_q,
                'played_f' => Match::CompetitionType($this->id)->finals()->count(),
                'won_f' => Match::CompetitionType($this->id)->finals()->won()->count(),
                'drew_f' => Match::CompetitionType($this->id)->finals()->drew()->count(),
                'lost_f' => Match::CompetitionType($this->id)->finals()->lost()->count(),
                'for_f' => $for_f,
                'against_f' => $against_f,
                'goal_difference_f' => (($goal_difference_f > 0) ? "+" : "") . $goal_difference_f
            );

            return $matchNumbers;
        }
        else {

            // goal numbers
            $for = 0;
            $against = 0;
            $competitionMatches =  Match::CompetitionType($this->id)->get();
            foreach($competitionMatches as $match) {
                $resultArray = explode(" ", $match->result);
                $goals = explode("-", $resultArray[1]);

                $for += intval($goals[0]);
                $against += intval($goals[1]);
            }
            $goal_difference = $for - $against;



            $matchNumbers = array(
                'played' =>  Match::CompetitionType($this->id)->count(),
                'won' =>  Match::CompetitionType($this->id)->won()->count(),
                'drew' =>  Match::CompetitionType($this->id)->drew()->count(),
                'lost' =>  Match::CompetitionType($this->id)->lost()->count(),
                'for' => $for,
                'against' => $against,
                'goal_difference' => (($goal_difference > 0) ? "+" : "") . $goal_difference
            );

            return $matchNumbers;
        }
    }

    /**
     * Get competition honours
     *
     * @return string
     */
    public function getHonoursAttribute(): string
    {
        $competitions = $this->competitions()
            ->where(function ($q) {
                $q->where('won','=', 1)->orWhere('shared','=', '1')->orWhere('qualified','=', '1');
            })
            ->orderBy('year','asc')
            ->get();

        $years = array();
        $withdrewCount = 0;
        $sharedCount = 0;
        foreach ($competitions as $comp) {
            $yearString = $comp->year;

            if ($comp->shared == 1) {
                $yearString .= "*";
                $sharedCount++;
            }
            elseif ($comp->withdrew == 1) {
                $yearString .= "*";
                $withdrewCount++;
            }

            $years[] = $yearString;
        }

        $honoursFooterText = "";
        if ($sharedCount > 0) {
            $honoursFooterText = "<br /><span class='honourFooterText'>* championship was shared</span>";
        }
        elseif ($withdrewCount > 0) {
            $honoursFooterText = "<br /><span class='honourFooterText'>* withdrew from finals</span>";
        }

        return implode(", ", $years) . $honoursFooterText;

    }

    /**
     * Get competition honours count
     *
     * @return int
     */
    public function getHonoursCountAttribute(): int
    {
        $competitions = $this->competitions()
            ->where(function ($q) {
                $q->where('won','=', 1)->orWhere('shared','=', '1')->orWhere('qualified','=', '1');
            })
            ->count();

        return $competitions;
    }

}
