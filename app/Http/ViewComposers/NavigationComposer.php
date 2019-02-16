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
        $url = Route::current()->uri;
        $urlSegments = explode("/", $url);

        $selected = [];
        if (in_array($urlSegments[0], array("","fixtures","latest-news","recent-results","articles","match-search"))) {
            $selected[] = 'home';
        }
        else {
            $selected[] = $urlSegments[0];
        }

        $titles = ['Home', 'Opponents', 'Players', 'Competitions', 'Managers', 'History', 'FIFA Rankings', 'Strips'];
        $routes = ['home', 'opponents', 'players', 'competitions', 'managers', 'history', 'fifa-rankings', 'strips'];

        $links = [];
        for ($i = 0; $i < sizeof($titles); $i++) {
            $link = new \stdClass();
            $link->title = $titles[$i];
            $link->route = $routes[$i];

            if (in_array($routes[$i], $selected)) {
                $link->selected = true;
            }
            else {
                $link->selected = false;
            }

            $links[] = $link;
        }

        $view->with(['links' => $links]);
    }

}