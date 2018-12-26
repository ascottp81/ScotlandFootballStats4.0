<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\PastEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class EventController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the past event list.
     *
     * @param int $id
     * @return View
     */
    public function index(int $id = 0): View
    {
        $eventList = PastEvent::orderBy('date','asc')->get();
        $selectedEvent = PastEvent::find($id);
        return view('admin/events/index', compact('eventList','selectedEvent','id'));
    }

    /**
     * Update the past event records
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'date' => 'required|date_format:Y-m-d',
            'summary' => 'required'
        ];
        $messages = [
            'date.*' => 'Please input a valid date',
            'summary.*' => 'Please input a summary'
        ];
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'date' => date('Y-m-d', strtotime($request->date)),
            'summary' => $request->summary ? trim($request->summary) : ''
        ];

        if ($request->itemid == 0) {
            PastEvent::create($data);
        }
        else {
            PastEvent::where('id', $request->itemid)->update($data);
        }

        return redirect ('/admin/events');
    }
}