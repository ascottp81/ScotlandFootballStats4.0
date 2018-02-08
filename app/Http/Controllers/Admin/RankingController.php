<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Ranking;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class RankingController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
     * Show the ranking list.
     *
	 * @param int $id
     * @return View
     */
    public function index(int $id = 0): View
    {
		$rankingList = Ranking::orderBy('date','desc')->get();	
		$ranking = Ranking::where('id','=',$id)->first();
        return view('admin/rankings/index', compact('rankingList','ranking','id'));
    }
	
    /**
     * Save Ranking Details.
     *
	 * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
		// Validation
		$rules = [
			'date' => 'required|date_format:Y-m-d',
			'ranking' => 'required|integer',
			'europe' => 'required|integer',
			'points' => 'required|integer',
		];
		$messages = [
			'date.*' => 'Please input a valid date in the format: 2000-01-01',
			'ranking.*' => 'Please input a valid ranking',
			'europe.*' => 'Please input a valid ranking',
			'points.*' => 'Please input a valid points value'
		];
		$request->validate($rules, $messages);


		// Obtain data
		$data = [
			'date' => date('Y-m-d', strtotime($request->date)),
			'ranking' => trim($request->ranking),
			'europe' => trim($request->europe),
			'points' => trim($request->points)
		];

		// Add / edit data
		if ($request->itemid == 0) {
			$ranking = Ranking::create($data);
		}
		else {
			$ranking = Ranking::where('id', '=', $request->itemid)->update($data);
		}
		
		return redirect('/admin/rankings');
    }
	
}
