<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Article;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
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
		$articleList = Article::all();
        return view('admin/articles/index', compact('articleList'));
    }
	
	/**
     * Add/Edit Article details
     *
	 * @param int $id
     * @return View
     */
    public function details(int $id = 0): View
    {
		$article = Article::find($id);
		
        return view('admin/articles/details', compact('article','id'));
    }
	
    /**
     * Save Article Details.
     *
	 * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
		// Validation
		$rules = [
			'title' => 'required',
			'link_text' => 'required',
			'url' => 'required'
		];
		$messages = [
			'title.*' => 'Please input a valid title',
			'link_text.*' => 'Please input valid link text',
			'url.*' => 'Please input a valid url'
		];
		$request->validate($rules, $messages);
		
		
		// Obtain data
		$data = [
			'title' => trim($request->title),
            'link_text' => trim($request->link_text),
            'url' => trim($request->url),
			'content' => $request->input('content') ?? ''
		];

		// Add / edit data
		if ($request->itemid == 0) {
			Article::create($data);
		}
		else {
			Article::where('id', '=', $request->itemid)->update($data);
		}
		
		return redirect('/admin/articles');
    }
	
	/**
     * Delete News details
     *
	 * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
		$remove = Article::where('id', '=', $id)->delete();
		return redirect('/admin/articles');
    }
	
}
