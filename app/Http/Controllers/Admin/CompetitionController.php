<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Competition;
use App\Models\CompetitionRound;
use App\Models\CompetitionType;
use App\Models\Opponent;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CompetitionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the competition type list.
     *
     * @return View
     */
    public function index(): View
    {
        $competitionList = CompetitionType::orderBy('priority','asc')->get();
        return view('admin/competitions/index', compact('competitionList'));
    }

    /**
     * Add / edit competition type.
     *
     * @param int $id
     * @return View
     */
    public function type(int $id = null): View
    {
        $competitionType = CompetitionType::find($id);
        return view('admin/competitions/type', compact('competitionType'));
    }

    /**
     * Show the competition version list.
     *
     * @param int $id
     * @return View
     */
    public function versionIndex(int $id): View
    {
        $competitionList = Competition::where('competition_type_id', '=', $id)->orderBy('year','asc')->orderBy('stage','desc')->get();
        return view('admin/competitions/versionindex', compact('competitionList'));
    }

    /**
     * Add / edit the competition version.
     *
     * @param int $id
     * @return View
     */
    public function version(int $id = null): View
    {
        $competition = Competition::find($id);
        return view('admin/competitions/version', compact('competition'));
    }

}