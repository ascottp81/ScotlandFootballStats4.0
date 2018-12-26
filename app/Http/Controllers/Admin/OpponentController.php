<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Opponent;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class OpponentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the opponent list.
     *
     * @param int $id
     * @return View
     */
    public function index(int $id = 0): View
    {
        $opponentList = Opponent::orderBy('name','asc')->get();
        $selectedOpponent = Opponent::find($id);
        $regions = Region::all();
        return view('admin/opponents/index', compact('opponentList','selectedOpponent','regions','id'));
    }

    /**
     * Update the opponent records
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'name' => 'required',
            'abbr_name' => 'required',
            'url' => 'required',
            'region_id' => 'required|min:1'
        ];
        $messages = [
            'name.*' => 'Please input a name',
            'abbr_name.*' => 'Please input an abbreviated name',
            'url.*' => 'Please input a url',
            'region_id.*' => 'Please select a region',
        ];
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'name' => trim($request->name),
            'abbr_name' => trim($request->abbr_name),
            'url' => trim($request->url),
            'region_id' => $request->region_id,
            'years' => $request->years ? trim($request->years) : '',
            'memorable_match' => $request->memorable_match ? trim($request->memorable_match) : '',
            'summary' => $request->summary ? trim($request->summary) : '',
            'getty_image' => $request->getty_image ? trim($request->getty_image) : ''
        ];

        if ($request->itemid == 0) {
            Opponent::create($data);
        }
        else {
            Opponent::where('id', $request->itemid)->update($data);
        }

        return redirect ('/admin/opponents');
    }
}