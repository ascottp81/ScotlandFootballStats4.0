<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Competition;
use App\Models\CompetitionRound;
use App\Models\CompetitionType;
use App\Models\History;
use App\Models\HistoryPage;
use App\Models\Match;
use App\Models\Opponent;
use App\Models\CompetitionTable;
use App\Models\TableResult;
use App\Models\TableTeam;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class HistoryController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the history chapter list.
     *
     * @param int $id
     * @return View
     */
    public function index(int $id = 0): View
    {
        $historyList = History::orderBy('first_year','asc')->get();
        $history = History::where('id','=',$id)->first();
        $matches = Match::orderBy('date','asc')->get();
        return view('admin/history/index', compact('historyList','history','id','matches'));
    }

    /**
     * Update the history records
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function historyUpdate(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'title' => 'required',
            'first_year' => 'required|numeric',
            'url' => 'required'
        ];
        $messages = [
            'title.*' => 'Please input a title',
            'first_year.*' => 'Please input a valid first year',
            'url.*' => 'Please input a valid url'
        ];
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'title' => trim($request->title),
            'period' => trim($request->period),
            'first_year' => $request->first_year,
            'summary' => $request->summary ? trim($request->summary) : '',
            'url' => $request->url ? trim($request->url) : '',
            'getty_image' => $request->getty_image ? trim($request->getty_image) : '',
            'famous_matches' => !is_null($request->famous_matches) ? $request->famous_matches : ''
        ];

        if ($request->itemid == 0) {
            History::create($data);
        }
        else {
            History::where('id', $request->itemid)->update($data);
        }

        return redirect ('/admin/history');
    }


    /**
     * Show the history chapter page list.
     *
     * @param string $url
     * @return View
     */
    public function pageIndex(string $url): View
    {
        $history = History::where('url','=',$url)->first();
        $historyPages = HistoryPage::where('history_id','=',$history->id)->orderBy('page_no','asc')->get();
        return view('admin/history/pageIndex', compact('historyPages','history'));
    }

    /**
     * Edit an existing history page.
     *
     * @param int $id
     * @return View
     */
    public function page(int $id): View
    {
        $page = HistoryPage::find($id);
        $history = History::where('id','=',$page->history_id)->first();
        $historyChapters = History::orderBy('first_year','asc')->get();
        return view('admin/history/page', compact('page','history','historyChapters','id'));
    }

    /**
     * Add a new history page.
     *
     * @param string $url
     * @return View
     */
    public function pageAdd(string $url): View
    {
        $id = 0;
        $history = History::where('url','=',$url)->first();
        return view('admin/history/page', compact('history','id'));
    }


    /**
     * Update the history page records
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function pageUpdate(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'title' => 'required',
            'page_no' => 'required|numeric'
        ];
        $messages = [
            'title.*' => 'Please input a title',
            'page_no.*' => 'Please input a valid page number'
        ];
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'title' => trim($request->title),
            'page_no' => trim($request->page_no),
            'history_id' => $request->history_id,
            'content' => $request->history_content ?? '',
            'getty_image' => $request->getty_image ? trim($request->getty_image) : '',
            'image_text' => $request->image_text ? trim($request->image_text) : '',
        ];

        if ($request->itemid == 0) {
            HistoryPage::create($data);
        }
        else {
            HistoryPage::where('id', $request->itemid)->update($data);
        }

        $history = History::find($request->history_id);
        return redirect ('/admin/history/' . $history->url);
    }

}