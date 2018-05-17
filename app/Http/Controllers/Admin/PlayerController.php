<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Player;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	/**
     * Show the player list.
     *
     * @return View
     */
    public function index(): View
    {
		$playerList = Player::all();	
        return view('admin/players/index', compact('playerList'));
    }
	
	/**
     * Add/Edit Player details
     *
     * @param int $id
     * @return View
     */
    public function player(int $id = 0): View
    {
		$player = Player::find($id);
		
        return view('admin/players/player', compact('player','id'));
    }
	
    /**
     * Save Player Details.
     *
	 * @param Request $request
     * @return RedirectResponse
     */
    public function playerUpdate(Request $request) : RedirectResponse
    {
        // Validation
        $rules = [
            'surname' => 'required',
            'firstname' => 'required',
            'debut_year' => 'date_format:Y',
            'date_of_birth' => 'date_format:j F Y',
        ];
        $messages = [
            'surname.required' => 'Please input a valid surname',
            'firstname.required' => 'Please input a valid firstname',
            'debut_year.date_format' => 'Please input a valid year',
            'date_of_birth.date_format' => 'Please input a valid date',
        ];
        $request->validate($rules, $messages);


        // Obtain data
		$data = [
			'surname' => trim($request->surname),
			'firstname' => trim($request->firstname),
			'debut_year' => trim($request->debut_year),
			'position' => $request->position ? trim($request->position) : '',
			'date_of_birth' => $request->date_of_birth ? date('Y-m-d', strtotime($request->date_of_birth)) : '',
			'birthplace' => $request->birthplace ? trim($request->birthplace) : '',
			'notes' => $request->notes ? trim($request->notes) : '',
			'retired' => ($request->retired)? 1:0,
			'getty_image' => $request->image ? trim($request->image) : ''
		];

        // Add / edit data
		if ($request->itemid == 0) {
			$player = Player::create($data);
		}
		else {
			$player = Player::where('id', '=', $request->itemid)->update($data);
		}
		
		return redirect('/admin/players');
    }
	
}
