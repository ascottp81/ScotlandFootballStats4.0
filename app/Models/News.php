<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class News extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'title', 'content', 'type'];
	
    /**
     * Additional fields to treat as Carbon instances
     * 
     * @var array
     */
    protected $dates = ['date'];


    /* SCOPES */

    /**
     * Scope query for fixtures
     * 
     * @param  $query
     */
    public function scopeRecent($query)
    {
        $query->where('type','=','News')->where('date', '>=', Carbon::now()->addYears(-1))->orderBy('date','desc')->orderBy('id','desc');
    }

}
