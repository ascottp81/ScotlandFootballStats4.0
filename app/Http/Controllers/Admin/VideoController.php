<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Match;
use App\Models\Video;

use App\Models\VideoType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class VideoController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the video list.
     *
     * @param int $id
     * @return View
     */
    public function index(int $id = 0): View
    {
        $videoList = Video::orderBy('id','desc')->get();
        $selectedVideo = Video::find($id);
        $matches = Match::orderBy('date','asc')->get();
        $types = VideoType::all();
        return view('admin/videos/index', compact('videoList','selectedVideo','matches','types','id'));
    }

    /**
     * Update the video records
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'title' => 'required',
            'match_id' => 'numeric|min:1',
            'type_id' => 'numeric|min:1',
            'filename' => 'required',
            'url' => 'required'
        ];
        $messages = [
            'title.*' => 'Please input a title',
            'match_id.*' => 'Please select a match',
            'type_id.*' => 'Please select a type',
            'filename.*' => 'Please input a filename',
            'url.*' => 'Please input a url'
        ];
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'title' => trim($request->title),
            'sub_title' => $request->sub_title ? trim($request->sub_title) : '',
            'summary' => $request->summary ? trim($request->summary) : '',
            'match_id' => $request->match_id,
            'type_id' => $request->type_id,
            'featured' => $request->featured ?? '0',
            'classic' => $request->classic ?? '0',
            'history' => $request->history ?? '0',
            'filename' => trim($request->filename),
            'url' => trim($request->url),
            'youtube' => $request->youtube ? trim($request->youtube) : '',
        ];

        if ($request->itemid == 0) {
            Video::create($data);
        }
        else {
            Video::where('id', $request->itemid)->update($data);
        }

        return redirect ('/admin/videos');
    }
}