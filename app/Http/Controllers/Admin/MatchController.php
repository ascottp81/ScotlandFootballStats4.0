<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Appearance;
use App\Models\Club;
use App\Models\Competition;
use App\Models\CompetitionRound;
use App\Models\Fact;
use App\Models\IncidentType;
use App\Models\Location;
use App\Models\Manager;
use App\Models\Match;
use App\Models\MatchIncident;
use App\Models\MatchStatistic;
use App\Models\MatchSummary;
use App\Models\Opponent;
use App\Models\Penalty;
use App\Models\Player;
use App\Models\Strip;
use App\Models\StripMatch;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class MatchController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the match list.
     *
     * @return View
     */
    public function matches(): View
    {
        $matchList = Match::all();
        return view('admin/matches/index', compact('matchList'));
    }

    /**
     * Add/edit a fixture.
     *
     * @param int $id
     * @return View
     */
    public function fixture(int $id = null): View
    {
        $fixture = Match::find($id);
        $opponents = Opponent::orderBy('name')->get();
        $competitions = Competition::orderBy('name')->get();
        $rounds = CompetitionRound::all();
        $locations = Location::orderBy('name')->get();

        return view('/admin/matches/fixture', compact('fixture','id','opponents','competitions','rounds','locations'));
    }


    /**
     * Create / Update the fixture record.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function fixtureUpdate(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'date' => 'required|date_format:Y-m-d',
            'opponent' => 'required|min:1',
            'competition' => 'required|min:1',
            'round' => 'required|min:1',
            'ha' => 'required|min:1'
        ];
        $messages = [
            'date.*' => 'Please input a valid date',
            'opponent.*' => 'Please select an opponent',
            'competition.*' => 'Please select a competition',
            'round.*' => 'Please select a competition round',
            'ha.*' => 'Please select H/A',
        ];
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'date' => date('Y-m-d', strtotime($request->date)),
            'opponent_id' => $request->opponent,
            'competition_id' => $request->competition,
            'round_id' => $request->round,
            'other_competition_id' => '0',
            'venue' => $request->venue ? trim($request->venue) : '',
            'location_id' => $request->location,
            'ha' => $request->ha,
            'kickoff' => $request->kickoff ? trim($request->kickoff) : '',
            'opp_ranking' => $request->ranking ? trim($request->ranking) : ''
        ];

        // Add / edit data
        if ($request->itemid == null) {
            $fixture = Match::create($data);
        }
        else {
            $fixture = Match::where('id', $request->itemid)->update($data);
        }

        return redirect('/admin/matches');
    }

    /**
     * Edit Match Details Dashboard.
     *
     * @param int $id
     * @return View
     */
    public function match(int $id): View
    {
        $match = Match::find($id);

        return view('admin/matches/dashboard', compact('match'));
    }

    /**
     * Edit Basic Match Details.
     *
     * @param int $id
     * @return View
     */
    public function basic(int $id): View
    {
        $match = Match::find($id);
        $opponents = Opponent::orderBy('name')->get();
        $competitions = Competition::orderBy('name')->get();
        $rounds = CompetitionRound::all();
        $locations = Location::orderBy('name')->get();
        $managers = Manager::orderBy('from')->orderBy('id')->get();

        return view('admin/matches/basic', compact('match','opponents','competitions','rounds','locations','managers'));
    }

    /**
     * Save Basic Match Details.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function basicUpdate(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'date' => 'required|date_format:Y-m-d',
            'opponent' => 'required|min:1',
            'competition' => 'required|min:1',
            'round' => 'required|min:1',
            'ha' => 'required|min:1',
            'attendance' => 'numeric',
            'result' => 'required'
        ];
        $messages = [
            'date.*' => 'Please input a valid date',
            'opponent.*' => 'Please select an opponent',
            'competition.*' => 'Please select a competition',
            'round.*' => 'Please select a competition round',
            'ha.*' => 'Please select H/A',
            'attendance.*' => 'Attendance must be numeric',
            'result.*' => 'Please input a result'
        ];
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'date' => trim($request->date),
            'opponent_id' => $request->opponent,
            'competition_id' => $request->competition,
            'round_id' => $request->round,
            'other_competition_id' => $request->other_competition,
            'venue' => $request->venue ? trim($request->venue) : '',
            'location_id' => $request->location,
            'ha' => $request->ha,
            'attendance' => $request->attendance ?? 0,
            'result' => trim($request->result),
            'kickoff' => $request->kickoff ? trim($request->kickoff) : '',
            'manager_id' => $request->manager,
            'manager' => $request->manager_text ? trim($request->manager_text) : '',
            'result_comment' => $request->result_comment ?? '',
            'comment' => $request->comment ?? '',
            'opp_ranking' => $request->opp_ranking ? trim($request->opp_ranking) : 0,
            'scot_scorers' => $request->scot_scorers ? trim($request->scot_scorers) : '',
            'opp_scorers' => $request->opp_scorers ? trim($request->opp_scorers) : '',
            'team' => $request->team ? trim($request->team) : '',
            'opp_team' => $request->opp_team ? trim($request->opp_team) : '',
            'scot_pen_miss' => $request->scot_pen_miss ? trim($request->scot_pen_miss) : '',
            'opp_pen_miss' => $request->opp_pen_miss ? trim($request->opp_pen_miss) : '',
            'scot_red_card' => $request->scot_red_card ? trim($request->scot_red_card) : '',
            'opp_red_card' => $request->opp_red_card ? trim($request->opp_red_card) : ''
        ];

        // Update data
        $match = Match::where('id', $request->itemid)->update($data);

        return redirect('/admin/match/' . $request->itemid);
    }


    /**
     * Input Team Lineup.
     *
     * @param int $id
     * @return View
     */
    public function lineup(int $id): View
    {
        $match = Match::find($id);

        $players = Player::where('debut_year', '>=', intval($match->date->format('Y')) - 20)
            ->where('debut_year', '<=', intval($match->date->format('Y')))
            ->orderBy('surname','asc')->orderBy('firstname','asc')->orderBy('debut_year','asc')
            ->get();

        $clubs = Club::orderBy('name','asc')->get();

        $starts = Appearance::where('match_id','=',$id)->where('replaced','=','0')->orderBy('shirt_no','asc')->get();
        $subs = Appearance::where('match_id','=',$id)->where('replaced','>','0')->orderBy('shirt_no','asc')->get();

        return view('admin/matches/lineup', compact('id','players','clubs','starts','subs'));
    }

    /**
     * Save Lineup Match Details.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function lineupUpdate(Request $request): RedirectResponse
    {
        // Validation
        $rules = array();
        $messages = array();

        for ($i = 0; $i < sizeof($request->id); $i++) {

            $rules['shirt_no.'. $i] = 'required|numeric';
            $rules['player_id.'. $i] = 'required|min:1';
            $rules['club_id.'. $i] = 'required|min:1';
            $rules['goals.'. $i] = 'required|numeric';
            $rules['penalties.'. $i] = 'required|numeric';

            // specify class that shows error on input
            $messages['shirt_no.' . $i . '.*'] = 'errorInput';
            $messages['player_id.' . $i . '.*'] = 'errorInput';
            $messages['club_id.' . $i . '.*'] = 'errorInput';
            $messages['goals.' . $i . '.*'] = 'errorInput';
            $messages['penalties.' . $i . '.*'] = 'errorInput';
        }

        $request->validate($rules, $messages);


        for ($i = 0; $i < sizeof($request->id); $i++) {

            // Obtain data
            $data = [
                'match_id' => $request->match_id,
                'shirt_no' => $request->shirt_no[$i],
                'player_id' => $request->player_id[$i],
                'club_id' => $request->club_id[$i],
                'replaced' => trim($request->replaced[$i]),
                'minute' => trim($request->minute[$i]),
                'captain' => $request->captain[$i],
                'keeper' => ($i == 0)? '1' : '0',
                'goals' => trim($request->goals[$i]),
                'penalties' => trim($request->penalties[$i]),
                'cards' => $request->cards[$i],
                'shirt_no_show' => $request->shirt_no_show[$i]
            ];

            // Add / edit data
            if ($request->id[$i] == 0) {
                $appearance = Appearance::create($data);
            }
            else {
                $appearance = Appearance::where('id', '=', $request->id[$i])->update($data);
            }

        }

        return redirect('/admin/match/' . $request->match_id);
    }

    /**
     * Input shirt details.
     *
     * @param int $id
     * @return View
     */
    public function strips(int $id): View
    {
        $match = Match::find($id);
        $scotlandShirts = Strip::orderBy('year_from','asc')->get();

        return view('admin/matches/shirts', compact('match','scotlandShirts'));
    }

    /**
     * Save shirt details.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function stripsUpdate(Request $request): RedirectResponse
    {
        $data = [
            'match_id' => $request->itemid,
            'strip_id' => $request->scotland_top ?? 0,
            'scotland_shorts' => $request->scotland_shorts ?? '',
            'opponent_shirt' => $request->opponent_shirt ?? '',
            'opponent_shorts' => $request->opponent_shorts ?? '',
            'goalkeeper_top' => $request->goalkeeper_top ?? '',
            'match_note' => $request->match_note ?? ''
        ];

        if (StripMatch::where('match_id','=',$request->itemid)->count() == 0) {
            $stripmatch = StripMatch::create($data);
        }
        else {
            $stripmatch = StripMatch::where('match_id', '=', $request->itemid)->update($data);
        }

        return redirect('/admin/match/' . $request->itemid);
    }


    /**
     * Input match summary.
     *
     * @param int $id
     * @return View
     */
    public function summary(int $id): View
    {
        $summary = MatchSummary::where('match_id','=',$id)->first();

        return view('admin/matches/summary', compact('id','summary'));
    }

    /**
     * Save match summary.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function summaryUpdate(Request $request): RedirectResponse
    {
        $match = Match::find($request->itemid);

        $data = [
            'match_id' => $request->itemid,
            'content' => $request->summary ?? ''
        ];


        if (MatchSummary::where('match_id','=',$request->itemid)->count() == 0) {
            $summary = MatchSummary::create($data);
        }
        else {
            $summary = MatchSummary::where('match_id', '=', $request->itemid)->update($data);
        }

        return redirect('/admin/match/' . $request->itemid);
    }


    /**
     * Input extra match stats.
     *
     * @param int $id
     * @return View
     */
    public function stats(int $id): View
    {
        $scotlandStats = MatchStatistic::where('team_id','=','0')->where('match_id','=',$id)->first();
        $opponentStats = MatchStatistic::where('team_id','<>','0')->where('match_id','=',$id)->first();

        $match = Match::find($id);
        $opponent = Opponent::find($match->opponent_id);

        return view('admin/matches/stats', compact('id','opponent','scotlandStats','opponentStats'));
    }

    /**
     * Save extra match stats.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function statsUpdate(Request $request): RedirectResponse
    {
        $match = Match::find($request->itemid);

        $scotlandData = [
            'match_id' => $request->itemid,
            'team_id' => 0,
            'colour' => $request->scotland_colour ?? '',
            'possession' => $request->scotland_possession ?? '',
            'shots' => $request->scotland_shots ?? '',
            'on_target' => $request->scotland_on_target ?? '',
            'fouls' => $request->scotland_fouls ?? '',
            'offside' => $request->scotland_offside ?? '',
            'corners' => $request->scotland_corners ?? '',
            'saves' => $request->scotland_saves ?? '',
            'ta' => $request->scotland_ta ?? '',
            'yellow_cards' => $request->scotland_yellow_cards ?? '',
            'red_cards' => $request->scotland_red_cards ?? '',
            'source' => $request->source ?? ''
        ];

        $opponentData = [
            'match_id' => $request->itemid,
            'team_id' => $match->opponent_id,
            'colour' => $request->opponent_colour ?? '',
            'possession' => $request->opponent_possession ?? '',
            'shots' => $request->opponent_shots ?? '',
            'on_target' => $request->opponent_on_target ?? '',
            'fouls' => $request->opponent_fouls ?? '',
            'offside' => $request->opponent_offside ?? '',
            'corners' => $request->opponent_corners ?? '',
            'saves' => $request->opponent_saves ?? '',
            'ta' => $request->opponent_ta ?? '',
            'yellow_cards' => $request->opponent_yellow_cards ?? '',
            'red_cards' => $request->opponent_red_cards ?? '',
            'source' => $request->source ?? ''
        ];



        if (MatchStatistic::where('match_id','=',$request->itemid)->count() == 0) {
            $extraStat = MatchStatistic::create($scotlandData);
            $extraStat = MatchStatistic::create($opponentData);
        }
        else {
            $extraStat = MatchStatistic::where('match_id', '=', $request->itemid)->where('team_id','=','0')->update($scotlandData);
            $extraStat = MatchStatistic::where('match_id', '=', $request->itemid)->where('team_id','<>','0')->update($opponentData);
        }

        return redirect('/admin/match/' . $request->itemid);
    }

    /**
     * Input Incidents.
     *
     * @param int $id
     * @return View
     */
    public function incidents(int $id): View
    {
        $match = Match::find($id);
        $incidents = MatchIncident::where('match_id','=',$id)->orderBy('minute','asc')->get();
        $incidentTypes = IncidentType::all();

        return view('admin/matches/incidents', compact('match','incidents','incidentTypes'));
    }

    /**
     * Save Incidents.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function incidentsUpdate(Request $request): RedirectResponse
    {

        for ($i = 0; $i < sizeof($request->id); $i++) {

            $data = [
                'match_id' => $request->match_id,
                'minute' => $request->minute[$i],
                'player' => $request->player[$i],
                'team_id' => $request->team_id[$i],
                'incident_type_id' => $request->incident_type_id[$i]
            ];

            $image = $request->file('image.' . $i);
            $destinationPath = storage_path('/app/public/animations/incidents');

            if ($request->id[$i] == 0) {
                $incident = MatchIncident::create($data);

                //if ($image != null) {
                //    $image->move($destinationPath, $incident->id . '.gif');
                //}
            }
            else {
                $incident = MatchIncident::where('id', '=', $request->id[$i])->update($data);

                //if ($image != null) {
                //    $image->move($destinationPath, $request->id[$i] . '.gif');
                //}
            }

        }

        return redirect('/admin/match/' . $request->match_id);
    }

    /**
     * Input Penalties.
     *
     * @param int $id
     * @return View
     */
    public function penalties(int $id): View
    {
        $match = Match::find($id);
        $penalties = Penalty::where('match_id','=',$id)->orderBy('penalty_no','asc')->get();

        return view('admin/matches/penalties', compact('match','penalties'));
    }

    /**
     * Save Penalties.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function penaltiesUpdate(Request $request): RedirectResponse
    {

        for ($i = 0; $i < sizeof($request->id); $i++) {

            $data = [
                'match_id' => $request->match_id,
                'penalty_no' => $request->penalty_no[$i],
                'player' => $request->player[$i],
                'team_id' => $request->team_id[$i],
                'result' => trim($request->result[$i])
            ];

            if ($request->id[$i] == 0) {
                $penalty = Penalty::create($data);
            }
            else {
                $penalty = Penalty::where('id', '=', $request->id[$i])->update($data);
            }

        }

        return redirect('/admin/match/' . $request->match_id);
    }


    /**
     * Input formation, fact and getty image
     *
     * @param int $id
     * @return View
     */
    public function other(int $id): View
    {
        $match = Match::find($id);
        $fact = Fact::where('match_id','=', $id)->first();

        return view('admin/matches/other', compact('match','fact'));
    }

    /**
     * Save extra match stats.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function otherUpdate(Request $request): RedirectResponse
    {
        // Formation and Getty Image
        $formation = "(" . $request->formation . ") " . implode(",", $request->formation_shirt);

        $data = [
            'formation' => $formation,
            'getty_image' => $request->image
        ];
        $match = Match::where('id', $request->itemid)->update($data);


        // Match Fact
        $factData = [
            'match_id' => $request->itemid,
            'text' => $request->fact
        ];

        if (Fact::where('match_id','=',$request->itemid)->count() == 0 && $request->fact != "") {
            Fact::create($factData);
        }
        elseif ($request->fact != "") {
            Fact::where('match_id', '=', $request->itemid)->update(['text' => $request->fact]);
        }
        else {
            Fact::where('match_id', '=', $request->itemid)->delete();
        }

        return redirect('/admin/match/' . $request->itemid);
    }


    /**
     * Add substitute to lineup.
     *
     * @param int $match_id
     * @return View
     */
    public function addLineup(int $match_id): View
    {
        $match = Match::find($match_id);
        $players = Player::where('debut_year', '>=', intval($match->date->format('Y')) - 20)
            ->where('debut_year', '<=', intval($match->date->format('Y')))
            ->orderBy('surname','asc')->orderBy('firstname','asc')->orderBy('debut_year','asc')
            ->get();
        $clubs = Club::orderBy('name','asc')->get();


        return view('admin/matches/partial/lineup', compact('players','clubs'));
    }

    /**
     * Remove substitute from lineup.
     *
     * @param int $id
     */
    public function removeLineup(int $id)
    {
        $remove = Appearance::where('id', '=', $id)->delete();
    }

    /**
     * Add incident
     *
     * @param int $match_id
     * @return View
     */
    public function addIncident(int $match_id): View
    {
        $match = Match::find($match_id);
        $incidentTypes = IncidentType::all();

        return view('admin/matches/partial/incident', compact('match','incidentTypes'));
    }

    /**
     * Remove incident.
     *
     * @param int $id
     */
    public function removeIncident(int $id)
    {
        $remove = MatchIncident::where('id', '=', $id)->delete();

        // delete image
        $image = '/public/animations/incidents/' . $id . ".gif";
        Storage::delete($image);
    }

    /**
     * Add penalty to shoot-out
     *
     * @param int $match_id
     * @return View
     */
    public function addPenalty(int $match_id): View
    {
        $match = Match::find($match_id);
        return view('admin/matches/partial/penalty', compact('match'));
    }

    /**
     * Remove penalty.
     *
     * @param int $id
     */
    public function removePenalty(int $id)
    {
        $remove = Penalty::where('id', '=', $id)->delete();
    }

}