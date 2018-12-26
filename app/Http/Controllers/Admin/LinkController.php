<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\ExternalLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class LinkController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the external link list.
     *
     * @param int $id
     * @return View
     */
    public function index(int $id = 0): View
    {
        $linkList = ExternalLink::all();
        $selectedLink = ExternalLink::find($id);
        return view('admin/links/index', compact('linkList','selectedLink','id'));
    }

    /**
     * Update the external link records
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // Validation
        $rules = [
            'title' => 'required',
            'url' => 'required',
            'type' => 'required|min:1',
            'list_order' => 'required|numeric'
        ];
        $messages = [
            'title.*' => 'Please input a title',
            'url.*' => 'Please input a url',
            'type.*' => 'Please select a type',
            'list_order.*' => 'Please input a valid list order number',
        ];
        $request->validate($rules, $messages);

        // Obtain data
        $data = [
            'title' => trim($request->title),
            'url' => trim($request->url),
            'type' => $request->type,
            'list_order' => $request->list_order,
            'summary' => $request->summary ? trim($request->summary) : ''
        ];

        if ($request->itemid == 0) {
            ExternalLink::create($data);
        }
        else {
            ExternalLink::where('id', $request->itemid)->update($data);
        }

        return redirect ('/admin/links');
    }
}