<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Competition;
use App\Models\CompetitionRound;
use App\Models\CompetitionType;
use App\Models\Opponent;
use App\Models\CompetitionTable;
use App\Models\TableResult;
use App\Models\TableTeam;

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
     * @param int $id
     * @return View
     */
    public function index(int $id = 0): View
    {
        $competitionList = CompetitionType::orderBy('priority','asc')->get();
        $competition = CompetitionType::where('id','=',$id)->first();
        return view('admin/competitions/index', compact('competitionList','competition','id'));
    }

    /**
     * Update the competition type records
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function competitionTypeUpdate(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'title' => 'required',
            'priority' => 'numeric'
        ];
        $messages = [
            'title.*' => 'Please input a title',
            'priority.*' => 'Please input a priority number'
        ];

        // if it is not a friendly
        if ($request->itemid != 8) {
            $rules['status'] = 'required|min:1';
            $rules['url'] = 'required';
            $messages['status.*'] = 'Please select a status';
            $messages['url.*'] = 'Please input a URL';
        }
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'title' => trim($request->title),
            'priority' => trim($request->priority),
            'summary' => $request->summary ? trim($request->summary) : '',
            'short_summary' => $request->short_summary ? trim($request->short_summary) : '',
            'status' => $request->status ? trim($request->status) : '',
            'url' => $request->url ? trim($request->url) : '',
            'getty_images' => $request->getty_images ? trim($request->getty_images) : '',
            'local_getty_images' => $request->local_getty_images ? trim($request->local_getty_images) : ''
        ];

        if ($request->itemid == 0) {
            $competition = CompetitionType::create($data);
        }
        else {
            $competition = CompetitionType::where('id', $request->itemid)->update($data);
        }

        return redirect ('/admin/competitions');
    }



    /**
     * Add / Edit a competition version.
     *
     * @param string $url
     * @param int $id
     * @return View
     */
    public function competition(string $url, int $id = 0): View
    {
        $competitionType = CompetitionType::where('url','=',$url)->firstOrFail();
        $competitionVersion = Competition::where('id','=',$id)->first();

        // competitions
        $competitions = Competition::where('competition_type_id','=',$competitionType->id)
            ->orderBy('year','asc')
            ->orderBy('stage','desc')
            ->get();

        // Competition Types
        $competitionTypes = CompetitionType::orderBy('priority','asc')->get();

        // tables
        $tables = CompetitionTable::where('competition_id','=',$id)->get();

        return view('admin/competitions/versions', compact('competitionType','competitionVersion','competitions','id','competitionTypes','tables'));
    }

    /**
     * Update the competition records
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function competitionUpdate(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'name' => 'required',
            'competition_type_id' => 'required|min:1',
            'year' => 'required|numeric'
        ];
        $messages = [
            'name.*' => 'Please input a name',
            'competition_type_id.*' => 'Please select a competition type',
            'year.*' => 'Please input a year'
        ];
        $request->validate($rules, $messages);

        // data
        $data = [
            'name' => trim($request->name),
            'competition_type_id' => $request->competition_type_id,
            'year' => trim($request->year),
            'stage' => $request->stage ? trim($request->stage) : '',
            'comment' => $request->comment ? trim($request->comment) : '',
            'outcome' => $request->outcome ?? '',
            'withdrew' => $request->withdrew ?? '0'
        ];

        if ($request->itemid == 0) {
            Competition::create($data);
        }
        else {
            Competition::where('id', $request->itemid)->update($data);
        }

        // Competition Type
        $competitionType = CompetitionType::where('id','=',$request->competition_type_id)->first();

        return redirect ('/admin/competitions/' . $competitionType->url);
    }

    /**
     * Show competition table.
     *
     * @param int $competitionId
     * @param int $id
     * @return View
     */
    public function table(int $competitionId, int $id = 0): View
    {
        $competition = Competition::where('id','=',$competitionId)->first();
        $table = CompetitionTable::where('id','=',$id)->first();

        if ($table) {
            $row = TableTeam::where('competition_table_id', '=', $table->id)->orderBy('position', 'asc')->get();
        }
        else {
            $row = null;
        }

        $rounds = CompetitionRound::orderBy('name','asc')->get();
        $opponents = Opponent::orderBy('name','asc')->get();
        $competitions = Competition::orderBy('name','asc')->get();

        return view('admin/competitions/table', compact('competition','table','row','rounds','opponents','competitions','id'));
    }

    /**
     * Update the competition table
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function tableUpdate(Request $request): RedirectResponse
    {
        // Competition Table Record
        $tableData = [
            'competition_id' => trim($request->competition_id),
            'round_id' => trim($request->round_id),
            'group_name' => trim($request->group_name),
            'home' => $request->home ?? '0',
            'head_to_head' => $request->head_to_head ?? '0',
            'win_points' => trim($request->win_points)
        ];

        $competitionTableCount = CompetitionTable::where('id', '=', $request->competition_table_id)->count();

        if ($competitionTableCount == 0) {
            $competitionTable = CompetitionTable::create($tableData);
            $competitionTableId = $competitionTable->id;
        }
        else {
            $competitionTable = CompetitionTable::where('id', $request->competition_table_id)->update($tableData);
            $competitionTableId = $request->competition_table_id;
        }


        // Table Teams
        for ($i = 0; $i < sizeof($request->id); $i++) {

            $data = [
                'competition_table_id' => $competitionTableId,
                'team_id' => $request->team_id[$i],
                'played' => $request->played[$i],
                'won' => $request->won[$i],
                'drew' => $request->drew[$i],
                'lost' => trim($request->lost[$i]),
                'for' => trim($request->for[$i]),
                'against' => $request->against[$i],
                'points' => trim($request->points[$i]),
                'outcome' => $request->outcome[$i] ?? ''
            ];

            if ($request->id[$i] == 0) {
                $data['position'] = ($i + 1);
                TableTeam::create($data);
            }
            else {
                TableTeam::where('id', '=', $request->id[$i])->update($data);
            }
        }

        // Competition Type
        $competitionTable = CompetitionTable::where('id', '=', $competitionTableId)->first();
        $competitionType = CompetitionType::where('id','=',$competitionTable->competition->type->id)->first();

        return redirect ('/admin/competitions/' . $competitionType->url . '/' . $competitionTable->competition->id);
    }



    /**
     * Show competition results.
     *
     * @param int $competitionId
     * @param int $tableId
     * @param int $id
     * @return View
     */
    public function result(int $competitionId, int $tableId, int $id = 0): View
    {
        $competition = Competition::where('id','=',$competitionId)->first();
        $competitionTables = CompetitionTable::all();

        // results
        $results = TableResult::where('competition_table_id','=',$tableId)
            ->orderBy('match_date','asc')
            ->get();

        $opponents = Opponent::orderBy('name','asc')->get();

        $tableResult = TableResult::find($id);

        return view('admin/competitions/results', compact('competition','tableId','results','opponents','id','tableResult','competitionTables'));
    }

    /**
     * Update the competition result
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function resultUpdate(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'match_date' => 'required|date',
            'match_round' => 'required|numeric',
            'home_team_id' => 'required|numeric',
            'away_team_id' => 'required|numeric',
        ];
        $messages = [
            'match_date.*' => 'Please input a match date',
            'match_round.*' => 'Please input a match round',
            'home_team_id.*' => 'Please select a home team',
            'away_team_id.*' => 'Please select an away team',
        ];
        $request->validate($rules, $messages);

        // data
        $data = [
            'competition_table_id' => $request->competition_table_id,
            'match_date' => $request->match_date,
            'match_round' => $request->match_round,
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'home_goals' => $request->home_goals,
            'away_goals' => $request->away_goals
        ];

        if ($request->itemid == 0) {
            $result = TableResult::create($data);
        }
        else {
            $result = TableResult::where('id', $request->itemid)->update($data);
        }

        $competitionTable = CompetitionTable::where('id','=',$request->competition_table_id)->first();

        return redirect ('/admin/competitions/' . $competitionTable->competition_id . '/table/' . $competitionTable->id . '/results');
    }



    /**
     * Add team to competition table.
     *
     * @return View
     */
    public function ajax_table(): View
    {
        $opponents = Opponent::orderBy('name','asc')->get();

        return view('admin/competitions/partial/table', compact('opponents'));
    }

    /**
     * Remove team from competition table.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function ajax_tableRemove(int $id)
    {
        $remove = TableTeam::where('id', '=', $id)->delete();
    }

    /**
     * Change team position in competition table.
     *
     * @param int $order
     * @return \Illuminate\Http\Response
     */
    public function ajax_tablePosition(int $order)
    {
        $order = explode(",", $order);

        for ($i = 1; $i <= sizeof($order); $i++){
            $id = $order[$i - 1];
            $table = TableTeam::where('id', $id)->update(['position' => $i]);
        }
    }
}