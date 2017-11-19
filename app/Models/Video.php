<?php

namespace App\Models;

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
     * @return object
     */
    public static function getHomeVideo()
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
			
		$video['width'] = '270px';
		$video['height'] = '200px';
		$video['baseurl'] = config('app.url');

        return $video;
    }
	
    /**
     * Get a mini video for the match details page
     * 
     * @return object
     */
    public static function getMiniMatchVideo($match_id)
    {
		if (config('app.livemedia')) {
			$video = Video::where('match_id', '=', $match_id)->where('type_id','=','1')
				->where('videos.youtube', '<>', '');
		}
		else {
			$video = Video::where('match_id', '=', $match_id)->where('type_id','=','1');	
		}
		
		if ($video->count() > 0) {
			$video = $video->firstOrFail();
			$video['width'] = '300px';
			$video['height'] = '200px';
			$video['baseurl'] = config('app.url');
		}

        return $video;
    }
	
    /**
     * Get a large video for the match details page
     * 
     * @return object
     */
    public static function getMatchVideo($match_id)
    {
		if (config('app.livemedia')) {
			$video = Video::where('match_id', '=', $match_id)->where('type_id','=','1')
				->where('videos.youtube', '<>', '');
		}
		else {
			$video = Video::where('match_id', '=', $match_id)->where('type_id','=','1');	
		}
		
		if ($video->count() > 0) {
			$video = $video->firstOrFail();
			$video['width'] = '710px';
			$video['height'] = '423px';
			$video['baseurl'] = config('app.url');
		}

        return $video;
    }
	
    /**
     * Get a random video for the competitions page
     * 
     * @return object
     */
    public static function getCompetitionsVideo()
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
     * @return object
     */
    public static function getCompetitionTypeVideo($type_id)
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
				->firstOrFail();
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
					->firstOrFail();		
			}
			else {
				$video = $video->firstOrFail();
			}
		}
			
		$video['width'] = '255px';
		$video['height'] = '191px';
		$video['baseurl'] = config('app.url');

        return $video;
    }
	
    /**
     * Get a video for the competition page
     * 
     * @return object
     */
    public static function getCompetitionVideo($competition_id)
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
		}
		
		if ($video) {
			$video['count'] = 1;
		}
		else {
			$video['count'] = 0;
		}
			
		$video['width'] = '400px';
		$video['height'] = '240px';
		$video['baseurl'] = config('app.url');

        return $video;
    }
	
	
    /**
     * Get a video for the strip page
     * 
     * @return object
     */
    public static function getStripVideo($strip_id)
    {
		if (config('app.livemedia')) {
			$video = Game::join('videos', 'videos.match_id', '=', 'games.id')
				->join('stripmatchdetails','stripmatchdetails.match_id','=','games.id')
				->select('videos.*', 'games.*')
				->where('videos.youtube', '<>', '')
				->where('type_id','=',1)
				->where('shirt_id','=',$strip_id)
				->orderBy(DB::Raw('RAND()'))
				->first();
				
			if (!$video) {
				$video = Game::join('videos', 'videos.match_id', '=', 'games.id')
					->join('competitions','competitions.id','=','games.competition_id')
					->select('videos.*', 'games.*')
					->where('videos.youtube', '<>', '')
					->where('type_id','=',1)
					->orderBy('match_date','desc')
					->first();
			}
		}
		else {
			$video = Game::join('videos', 'videos.match_id', '=', 'games.id')
				->join('stripmatchdetails','stripmatchdetails.match_id','=','games.id')
				->select('videos.*', 'games.*')
				->where('type_id','=',1)
				->where('shirt_id','=',$strip_id)
				->orderBy(DB::Raw('RAND()'))
				->first();	
				
			if (!$video) {
				$video = Game::join('videos', 'videos.match_id', '=', 'games.id')
					->join('competitions','competitions.id','=','games.competition_id')
					->select('videos.*', 'games.*')
					->where('type_id','=',1)
					->orderBy('match_date','desc')
					->first();
			}
		}
			
		$video['width'] = '275px';
		$video['height'] = '180px';
		$video['baseurl'] = config('app.url');

        return $video;
    }


}
