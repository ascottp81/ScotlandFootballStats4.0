<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\History;

use Illuminate\Support\Facades\Session;


class HistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display the history index page.
     *
     * @return Response
     */
    public function index()
    {
        $chapters = History::orderBy('first_year','asc')->get();

        // Meta data
        $metatitle = "History";
        $metadescription = "A brief history of the Scottish international football team, giving details of matches and incidents that happened surrounding the national team.";

        // Session variables for match list
        Session::put('MatchListUrl', '/history');
        Session::put('MatchList', "History");

        return view('history.index', compact('chapters','metatitle','metadescription'));
    }

    /**
     * Display the history page.
     *
     * @return Response
     */
    public function chapter($url)
    {
        $chapter = History::where('url','=',$url)->firstOrFail();

        // Meta data
        $metatitle = "History - " . $chapter->title;
        $metadescription = $chapter->summary;

        return view('history.chapter', compact('chapter','metatitle','metadescription'));
    }


}
