<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Match;
use Illuminate\Support\Facades\Session;

class ManagersController extends Controller
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
     * Display the home page.
     *
     * @return Response
     */
    public function index()
    {
        $managers = Manager::all();

        // Meta data
        $metatitle = "Managers";
        $metadescription = "Details of every manager that has taken charge of the Scotland international football team.";

        return view('managers.index', compact('managers','metatitle','metadescription'));
    }

    /**
     * Display the Manager details page.
     *
     * @return Response
     */
    public function manager($url)
    {
        $manager = Manager::where('url','=',$url)->firstOrFail();

        $matchList = Match::managerId($manager->id)->get();

        // Match Records
        $match = new Match();
        $matchNumbers = $match->getMatchRecordNumbers(Match::managerId($manager->id));
        $homeMatchNumbers = $match->getMatchRecordNumbers(Match::managerId($manager->id)->home());
        $awayMatchNumbers = $match->getMatchRecordNumbers(Match::managerId($manager->id)->awayNeutral());
        $matchNumbersComp = $match->getMatchRecordNumbers(Match::managerId($manager->id)->competitive());
        $homeMatchNumbersComp = $match->getMatchRecordNumbers(Match::managerId($manager->id)->competitive()->home());
        $awayMatchNumbersComp = $match->getMatchRecordNumbers(Match::managerId($manager->id)->competitive()->awayNeutral());


        // Meta data
        $metatitle = $manager->fullname;
        $metadescription = "Details of " . $metatitle . "'s matches in charge of Scotland.";

        // Session variables for match list
        Session::put('MatchListUrl', $_SERVER['REQUEST_URI']);
        Session::put('MatchList', $manager->fullname);

        return view('managers.manager', compact('manager','matchList','matchNumbers','homeMatchNumbers','awayMatchNumbers','matchNumbersComp','homeMatchNumbersComp','awayMatchNumbersComp','metatitle','metadescription'));
    }
}
