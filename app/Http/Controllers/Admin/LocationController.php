<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Location;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class LocationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the location list.
     *
     * @param int $id
     * @return View
     */
    public function index(int $id = 0): View
    {
        $locationList = Location::orderBy('name','asc')->get();
        $selectedLocation = Location::find($id);
        return view('admin/locations/index', compact('locationList','selectedLocation','id'));
    }

    /**
     * Update the location records
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name.*' => 'Please input a name'
        ];
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'name' => trim($request->name)
        ];

        if ($request->itemid == 0) {
            Location::create($data);
        }
        else {
            Location::where('id', $request->itemid)->update($data);
        }

        return redirect ('/admin/locations');
    }
}