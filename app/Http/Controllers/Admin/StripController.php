<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Strip;

use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StripController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	/**
     * Show the strip list.
     *
     * @return View
     */
    public function index(): View
    {
		$stripList = Strip::all();
        return view('admin/strips/index', compact('stripList'));
    }
	
	/**
     * Add/Edit strip details
     *
     * @param int $id
     * @return View
     */
    public function strip(int $id = 0): View
    {
		$strip = strip::find($id);
		
        return view('admin/strips/strip', compact('strip','id'));
    }
	
    /**
     * Save strip Details.
     *
	 * @param Request $request
     * @return RedirectResponse
     */
    public function stripUpdate(Request $request) : RedirectResponse
    {
        // Validation
        $rules = [
            'name' => 'required',
            'year_from' => 'required|date_format:Y',
            'year_to' => 'required|date_format:Y',
            'type' => 'required|min:1',
            'colour' => 'required'
        ];
        $messages = [
            'name.*' => 'Please input a tag name',
            'year_from.*' => 'Please input a valid from year',
            'year_to.*' => 'Please input a valid to year',
            'type.*' => 'Please select a type',
            'colour.*' => 'Please input a colour',
        ];
        $request->validate($rules, $messages);


        // Obtain data
		$data = [
			'name' => trim($request->name),
			'year_from' => $request->year_from,
            'year_to' => $request->year_to,
            'type' => $request->type,
            'colour' => trim($request->colour),
            'match' => $request->match ? trim($request->match) : '',
            'complete' => ($request->complete)? 1:0,
            'designer' => $request->designer ? trim($request->designer) : '',
            'note' => $request->note ? trim($request->note) : '',
			'getty_image' => $request->getty_image ? trim($request->getty_image) : ''
		];

        // Add / edit data
		if ($request->itemid == 0) {
			strip::create($data);
		}
		else {
			strip::where('id', '=', $request->itemid)->update($data);
		}
		
		return redirect('/admin/strips');
    }
	
}
