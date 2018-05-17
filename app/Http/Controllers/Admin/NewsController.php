<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\News;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
     * Show the news list.
     *
     * @return View
     */
    public function index(): View
    {
		$newsList = News::all();	
        return view('admin/news/index', compact('newsList'));
    }
	
	/**
     * Add/Edit News details
     *
	 * @param int $id
     * @return View
     */
    public function article(int $id = 0): View
    {
		$news = News::find($id);
		
        return view('admin/news/article', compact('news','id'));
    }
	
    /**
     * Save News Details.
     *
	 * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
		// Validation
		$rules = [
			'date' => 'required|date_format:Y-m-d',
			'title' => 'required',
			'content' => 'required',
			'type' => 'required|min:1',
		];
		$messages = [
			'date.*' => 'Please input a valid date in the format: 2000-01-01',
			'title.*' => 'Please input a valid title',
			'content.*' => 'Please input valid content',
			'type.*' => 'Please select a valid type'
		];
		$request->validate($rules, $messages);
		
		
		// Obtain data
		$data = [
			'date' => trim($request->date),
			'title' => trim($request->title),
			'content' => trim($request->input('content')),
			'type' => trim($request->type)
		];

		// Add / edit data
		if ($request->itemid == 0) {
			$news = News::create($data);
		}
		else {
			$news = News::where('id', '=', $request->itemid)->update($data);
		}
		
		return redirect('/admin/news');
    }
	
	/**
     * Delete News details
     *
	 * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
		$remove = News::where('id', '=', $id)->delete();
		return redirect('/admin/news');
    }
	
}
