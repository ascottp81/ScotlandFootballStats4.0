<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Classes\GettyImage;

class HistoryPage extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'historypages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['history_id','page_no','title','content','getty_image','image_text'];



    /* RELATIONSHIPS */

    /**
     * A page belongs to a history item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function history()
    {
        return $this->belongsTo('App\Models\History', 'history_id');
    }


    /* ACCESSORS */

    /**
     * Get the page Getty Image
     *
     * @return string
     */
    public function getImageAttribute(): string
    {
        $gettyImage = new GettyImage($this->getty_image, 0);

        return $gettyImage->outputImage();
    }
}
