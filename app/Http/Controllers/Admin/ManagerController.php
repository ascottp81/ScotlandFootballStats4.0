<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Manager;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	/**
     * Show the manager list.
     *
     * @return View
     */
    public function index(): View
    {
		$managerList = Manager::all();
        return view('admin/managers/index', compact('managerList'));
    }
	
	/**
     * Add/Edit Manager details
     *
     * @param int $id
     * @return View
     */
    public function manager(int $id = 0): View
    {
		$manager = Manager::find($id);
		
        return view('admin/managers/manager', compact('manager','id'));
    }
	
    /**
     * Save Manager Details.
     *
	 * @param Request $request
     * @return RedirectResponse
     */
    public function managerUpdate(Request $request) : RedirectResponse
    {
        // Validation
        $rules = [
            'surname' => 'required',
            'firstname' => 'required',
            'url' => 'required',
            'from' => 'date_format:Y',
            'to' => 'date_format:Y'
        ];
        $messages = [
            'surname.required' => 'Please input a valid surname',
            'firstname.required' => 'Please input a valid firstname',
            'url.required' => 'Please input a valid url',
            'from.date_format' => 'Please input a valid year',
            'to.date_format' => 'Please input a valid year',
        ];
        $request->validate($rules, $messages);


        // Obtain data
		$data = [
			'surname' => trim($request->surname),
			'firstname' => trim($request->firstname),
            'name_extension' => $request->name_extension ? trim($request->name_extension) : '',
			'from' => $request->from,
            'to' => $request->to,
            'url' => trim($request->url),
            'took_charge' => $request->took_charge ? trim($request->took_charge) : '',
            'appointed' => $request->appointed ? trim($request->appointed) : '',
            'reign_ended' => $request->reign_ended ? trim($request->reign_ended) : '',
			'reason' => $request->reason,
			'born' => $request->born ? date('Y-m-d', strtotime($request->born)) : '',
			'birthplace' => $request->birthplace ? trim($request->birthplace) : '',
			'died' => $request->died ? trim($request->died) : '',
            'summary' => $request->summary ? trim($request->summary) : '',
            'assistants' => $request->assistants ? trim($request->assistants) : '',
			'caretaker' => ($request->caretaker)? 1:0,
			'getty_image' => $request->getty_image ? trim($request->getty_image) : ''
		];

        // Add / edit data
		if ($request->itemid == 0) {
			Manager::create($data);
		}
		else {
			Manager::where('id', '=', $request->itemid)->update($data);
		}
		
		return redirect('/admin/managers');
    }
	
}
