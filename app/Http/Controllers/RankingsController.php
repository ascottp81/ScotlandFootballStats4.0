<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class RankingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
	
	/**
	 * Display the FIFA Rankings page.
	 *
	 * @return View
	 */
	public function index(): View
	{
	    $ranking = new Ranking();

        // Meta data
        $metatitle = "FIFA Rankings";
        $metadescription = "A record of Scotland's FIFA Rankings from when they started back in 1992.";


        return view('rankings.index', compact('ranking','metatitle','metadescription'));
    }
	
	/**
	 * Ajax to draw the Ranking chart.
	 *
	 * @return JsonResponse
	 */
	public function chart($start, $end, $chart): JsonResponse
	{

		$columns = [
			["id" => "", "label" => "Date", "pattern" => "", "type" => "string"],
			["id" => "", "label" => "Ranking", "pattern" => "", "type" => "number"]
		];
		
		$rows = [];
		
		$rankings = Ranking::whereBetween('id', [$start, $end])->orderBy('date','asc')->get();
		foreach ($rankings as $ranking) {
			
			$rankingVal = $ranking->ranking;
			if ($chart == 2){
				$rankingVal = $ranking->europe;	
			}
			
			$row = [
				"c" => [
					["v" => $ranking->date->format('M Y'), "f" => null],
					["v" => $rankingVal, "f" => null]
				]
			];
			$rows[] = $row;
		}
		
		$output = ["cols" => $columns, "rows" => $rows];

		return response()->json($output);
	}
		
		
	/**
	 * Ajax to update the date range on the slider.
	 *
	 * @return string
	 */
	public function dateRange($start, $end): string
	{
		$first = Ranking::find($start);
		$last = Ranking::find($end);
		
		return $first->date->format('j F Y') . " - " . $last->date->format('j F Y'); 
	}

}
