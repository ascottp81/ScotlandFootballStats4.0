<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Club;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ClubController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the club list.
     *
     * @param int $id
     * @return View
     */
    public function index(int $id = 0): View
    {
        $clubList = Club::orderBy('name','asc')->get();
        $selectedClub = Club::find($id);
        return view('admin/clubs/index', compact('clubList','selectedClub','id'));
    }

    /**
     * Update the club records
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
            Club::create($data);
        }
        else {
            Club::where('id', $request->itemid)->update($data);
        }

        return redirect ('/admin/clubs');
    }
}