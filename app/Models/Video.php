<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Video extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'sub-title', 'summary', 'match_id', 'type_id', 'featured', 'classic', 'history', 'filename', 'url', 'youtube'];
	


    /* RELATIONSHIPS */

    /**
     * A video belongs to a match
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function match()
    {
        return $this->belongsTo('App\Models\Match', 'match_id');
    }


    /* GETTERS */

    /**
     * Get the most recent video for the home page
     * 
     * @return Video
     */
    public static function getHomeVideo(): Video
    {
		if (config('app.livemedia')) {
			$video = Video::join('matches', 'videos.match_id', '=', 'matches.id')
				->select('videos.*')
				->whereNotNull('matches.result')
				->where('matches.result', '<>', '')
				->where('videos.youtube', '<>', '')
				->orderBy('matches.date', 'DESC')
				->firstOrFail();
		}
		else {
			$video = Video::join('matches', 'videos.match_id', '=', 'matches.id')
				->select('videos.*')
				->whereNotNull('matches.result')
				->where('matches.result', '<>', '')
				->orderBy('matches.date', 'DESC')
				->firstOrFail();	
		}

        return $video;
    }

    /**
     * Get a random video for the competitions page
     * 
     * @return Video
     */
    public static function getCompetitionsVideo(): Video
    {
		if (config('app.livemedia')) {
			$video = Video::join('matches', 'videos.match_id', '=', 'matches.id')
				->join('competitions','competitions.id','=','matches.competition_id')
				->join('competitiontype','competitiontype.id','=','competitions.competition_type_id')
				->select('videos.*')
				->whereNotNull('matches.result')
				->where('matches.result', '<>', '')
				->where('videos.youtube', '<>', '')
				->where('status','=','C')
				->orderBy(DB::Raw('RAND()'))
				->firstOrFail();
		}
		else {
			$video = Video::where('type_id','=',4)
				->orderBy(DB::Raw('RAND()'))
				->firstOrFail();	
		}
			
		$video['width'] = '475px';
		$video['height'] = '318px';
		$video['baseurl'] = config('app.url');

        return $video;
    }

    /**
     * Get a random video for the competition type index page
     *
     * @param int $type_id
     * @return Video
     */
    public static function getCompetitionTypeVideo(int $type_id): Video
    {
		if (config('app.livemedia')) {
			$video = Video::join('matches', 'videos.match_id', '=', 'matches.id')
				->join('competitions','competitions.id','=','matches.competition_id')
				->join('competitiontype','competitiontype.id','=','competitions.competition_type_id')
				->select('videos.*')
				->whereNotNull('matches.result')
				->where('matches.result', '<>', '')
				->where('videos.youtube', '<>', '')
				->where('competition_type_id','=',$type_id)
				->orderBy(DB::Raw('RAND()'))
				->first();
		}
		else {
			$video = Video::join('matches', 'videos.match_id', '=', 'matches.id')
				->join('competitions','competitions.id','=','matches.competition_id')
				->join('competitiontype','competitiontype.id','=','competitions.competition_type_id')
				->select('videos.*')
				->whereNotNull('matches.result')
				->where('matches.result', '<>', '')
				->where('competition_type_id','=',$type_id)
				->where('type_id','=',4)
				->orderBy(DB::Raw('RAND()'));

			if ($video->count() == 0) {
				$video = Video::join('matches', 'videos.match_id', '=', 'matches.id')
					->join('competitions','competitions.id','=','matches.competition_id')
					->join('competitiontype','competitiontype.id','=','competitions.competition_type_id')
					->select('videos.*')
					->whereNotNull('matches.result')
					->where('matches.result', '<>', '')
					->where('competition_type_id','=',$type_id)
					->orderBy(DB::Raw('RAND()'))
					->first();
			}
			else {
				$video = $video->first();
			}
		}
		if (!$video) {
            $video = Video::orderBy(DB::Raw('RAND()'))->first();
        }

        return $video;
    }
	
    /**
     * Get a video for the competition page
     *
     * @param int $competition_id
     * @return Video
     */
    public static function getCompetitionVideo(int $competition_id): Video
    {
		if (config('app.livemedia')) {
			$video = Video::join('matches', 'videos.match_id', '=', 'matches.id')
				->join('competitions','competitions.id','=','matches.competition_id')
				->select('videos.*')
				->whereNotNull('matches.result')
				->where('matches.result', '<>', '')
				->where('videos.youtube', '<>', '')
				->where('competition_id','=',$competition_id)
				->orderBy(DB::Raw('RAND()'))
				->first();

			// use random video, if no videos from that competition
            if (!$video) {
                $video = Video::where('videos.youtube', '<>', '')
                    ->orderBy(DB::Raw('RAND()'))
                    ->first();
            }
		}
		else {
			$competition = Competition::where('id','=',$competition_id)->firstOrFail();
			$video = Video::join('matches', 'videos.match_id', '=', 'matches.id')
				->join('competitions','competitions.id','=','matches.competition_id')
				->select('videos.*')
				->where('competition_type_id','=',$competition->competition_type_id)
				->where('year','=',$competition->year)
				->where('stage','=',$competition->stage)
				->where('type_id','=',4)
				->first();	
				
            // use random video from same competition type
			if (!$video) {
				$video = Video::join('matches', 'videos.match_id', '=', 'matches.id')
					->join('competitions','competitions.id','=','matches.competition_id')
					->select('videos.*')
					->whereNotNull('matches.result')
					->where('matches.result', '<>', '')
					->where('competition_id','=',$competition_id)
					->orderBy(DB::Raw('RAND()'))
					->first();
			}

            // use random montage video, if no videos from that competition
            if (!$video) {
                $video = Video::where('type_id', '=', 3)
                    ->orderBy(DB::Raw('RAND()'))
                    ->first();
            }
		}
		
		if ($video) {
			$video['count'] = 1;
		}
		else {
			$video['count'] = 0;
		}

        return $video;
    }
	
	
    /**
     * Get a video for the strip page
     *
     * @param int $strip_id
     * @return Match
     */
    public static function getStripVideo(int $strip_id): Match
    {
		if (config('app.livemedia')) {
			$video = Match::join('videos', 'videos.match_id', '=', 'matches.id')
				->join('stripmatchdetails','stripmatchdetails.match_id','=','matches.id')
				->select('videos.*', 'matches.*')
				->where('videos.youtube', '<>', '')
				->where('type_id','=',1)
				->where('strip_id','=',$strip_id)
				->orderBy(DB::Raw('RAND()'))
				->first();
				
			if (!$video) {
				$video = Match::join('videos', 'videos.match_id', '=', 'matches.id')
					->join('competitions','competitions.id','=','matches.competition_id')
					->select('videos.*', 'matches.*')
					->where('videos.youtube', '<>', '')
					->where('type_id','=',1)
					->orderBy('date','desc')
					->first();
			}
		}
		else {
			$video = Match::join('videos', 'videos.match_id', '=', 'matches.id')
				->join('stripmatchdetails','stripmatchdetails.match_id','=','matches.id')
				->select('videos.*', 'matches.*')
				->where('type_id','=',1)
				->where('strip_id','=',$strip_id)
				->orderBy(DB::Raw('RAND()'))
				->first();	
				
			if (!$video) {
				$video = Match::join('videos', 'videos.match_id', '=', 'matches.id')
					->join('competitions','competitions.id','=','matches.competition_id')
					->select('videos.*', 'matches.*')
					->where('type_id','=',1)
					->orderBy('date','desc')
					->first();
			}
		}

        return $video;
    }


}
