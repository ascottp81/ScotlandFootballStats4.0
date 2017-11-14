<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

use Carbon\Carbon;


class NavigationComposer {

    /**
     * Create a new navigation composer.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
		$homeLink = "";
		$opponentsLink = "";
		$playersLink = "";
		$competitionsLink = "";
		$managersLink = "";
		$historyLink = "";
		$rankingsLink = "";
		$stripsLink = "";
		$videosLink = "";
		
		$url = Route::current()->uri;
		$urlSegments = explode("/", $url);
		
		if (in_array($urlSegments[0], array("","fixtures","latest-news","recent-results","articles","match-search"))) {
			$homeLink = 'class="selected"';
		}
		elseif ($urlSegments[0] == "opponents") {
			$opponentsLink = 'class="selected"';
		}
		elseif ($urlSegments[0] == "players") {
			$playersLink = 'class="selected"';
		}
		elseif ($urlSegments[0] == "competitions") {
			$competitionsLink = 'class="selected"';
		}
		elseif ($urlSegments[0] == "managers") {
			$managersLink = 'class="selected"';
		}
		elseif ($urlSegments[0] == "history") {
			$historyLink = 'class="selected"';
		}
		elseif ($urlSegments[0] == "fifa-rankings") {
			$rankingsLink = 'class="selected"';
		}
		elseif ($urlSegments[0] == "strips") {
			$stripsLink = 'class="selected"';
		}
		
		$links = array(
		   'home' => $homeLink,
		   'opponents' => $opponentsLink,
		   'players' => $playersLink,
		   'competitions' => $competitionsLink,
		   'managers' => $managersLink,
		   'history' => $historyLink,
		   'rankings' => $rankingsLink,
		   'strips' => $stripsLink,
		   'videos' => $videosLink
		);
		
        $view->with($links);
    }

}