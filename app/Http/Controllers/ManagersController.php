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

        // Match Records
        $match = new Match();
        $managerMatches = Match::managerId($manager->id);
        $matchNumbers = $match->getMatchRecordNumbers(with(clone $managerMatches));
        $homeMatchNumbers = $match->getMatchRecordNumbers(with(clone $managerMatches)->home());
        $awayMatchNumbers = $match->getMatchRecordNumbers(with(clone $managerMatches)->awayNeutral());
        $matchNumbersComp = $match->getMatchRecordNumbers(with(clone $managerMatches)->competitive());
        $homeMatchNumbersComp = $match->getMatchRecordNumbers(with(clone $managerMatches)->competitive()->home());
        $awayMatchNumbersComp = $match->getMatchRecordNumbers(with(clone $managerMatches)->competitive()->awayNeutral());


        // Meta data
        $metatitle = $manager->fullname;
        $metadescription = "Details of " . $metatitle . "'s matches in charge of Scotland.";

        // Session variables for match list
        Session::put('MatchListUrl', $_SERVER['REQUEST_URI']);
        Session::put('MatchList', $manager->fullname);

        return view('managers.manager', compact('manager','matchNumbers','homeMatchNumbers','awayMatchNumbers','matchNumbersComp','homeMatchNumbersComp','awayMatchNumbersComp','metatitle','metadescription'));
    }
}
