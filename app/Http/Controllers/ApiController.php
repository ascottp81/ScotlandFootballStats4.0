<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Classes\Api;
use App\Models\CompetitionType;
use App\Models\News;
use App\Models\Opponent;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    private $_api;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->_api = new Api();
    }

    /**
     * List all of the recent matches
     *
     * @return JsonResponse
     */
    public function recentMatches(): JsonResponse
    {
        try {
            $data = $this->_api->recentMatches();
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'JSON Error'], 404);
        }
    }

    /**
     * List all of the fixtures
     *
     * @return JsonResponse
     */
    public function fixtures(): JsonResponse
    {
        try {
            $data = $this->_api->fixtures();
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'JSON Error'], 404);
        }
    }

    /**
     * List all of the search results
     *
     * @param string $parameters
     * @return JsonResponse
     */
    public function searchResults(string $parameters): JsonResponse
    {
        try {
            $data = $this->_api->searchResults($parameters);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'JSON Error'], 404);
        }
    }

    /**
     * List all of the news articles
     *
     * @return JsonResponse
     */
    public function news(): JsonResponse
    {
        $output = News::recent()->get(['id', 'title']);

        return response()->json($output, 200);
    }

    /**
     * Get the specified news article
     *
     * @param int $articleId
     * @return JsonResponse
     */
    public function newsArticle(int $articleId): JsonResponse
    {
        try {
            $data = $this->_api->newsArticle($articleId);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid News ID'], 404);
        }
    }

    /**
     * List all of the opponents
     *
     * @return JsonResponse
     */
    public function opponents(): JsonResponse
    {
        $output = Opponent::orderBy('name','asc')->get(['id', 'name', 'abbr_name']);

        return response()->json($output, 200);
    }

    /**
     * List all of the matches against specified opponent
     *
     * @param int $opponentId
     * @return JsonResponse
     */
    public function opponentMatches(int $opponentId): JsonResponse
    {
        try {
            $data = $this->_api->opponentMatches($opponentId);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid Opponent ID'], 404);
        }
    }

    /**
     * Get the details for a specified match
     *
     * @param int $matchId
     * @return JsonResponse
     */
    public function match(int $matchId): JsonResponse
    {
        try {
            $data = $this->_api->match($matchId);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid Match ID'], 404);
        }
    }

    /**
     * Get a player list
     *
     * @param string $type
     * @param string $letter
     * @return JsonResponse
     */
    public function players(string $type, string $letter = ""): JsonResponse
    {
        try {
            $data = $this->_api->players($type, $letter);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'JSON Error'], 404);
        }
    }

    /**
     * Get a player's details
     *
     * @param int $playerId
     * @return JsonResponse
     */
    public function player(int $playerId): JsonResponse
    {
        try {
            $data = $this->_api->player($playerId);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid Player ID'], 404);
        }
    }

    /**
     * List all of the match appearances for a specified player
     *
     * @param int $playerId
     * @return JsonResponse
     */
    public function playerMatches(int $playerId): JsonResponse
    {
        try {
            $data = $this->_api->playerMatches($playerId);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid Player ID'], 404);
        }
    }

    /**
     * List all of the competitions
     *
     * @return JsonResponse
     */
    public function competitions(): JsonResponse
    {
        $output = CompetitionType::where('title','<>','Friendly')->orderBy('priority','asc')->get(['id','title','status']);

        return response()->json($output, 200);
    }

    /**
     * List all of the competitions
     *
     * @param int $typeId
     * @return JsonResponse
     */
    public function competitionVersions(int $typeId): JsonResponse
    {
        $output = CompetitionType::find($typeId)->competitions()->orderBy('year','asc')->orderBy('stage','desc')->get(['id','name']);

        return response()->json($output, 200);
    }

    /**
     * Get an individual competition's match details
     *
     * @param int $competitionId
     * @return JsonResponse
     */
    public function competitionMatchDetails(int $competitionId): JsonResponse
    {
        try {
            $data = $this->_api->competitionMatchDetails($competitionId);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'JSON Error'], 404);
        }
    }

    /**
     * Get an individual competition's group tables
     *
     * @param int $competitionId
     * @return JsonResponse
     */
    public function competitionTables(int $competitionId): JsonResponse
    {
        try {
            $data = $this->_api->competitionTables($competitionId);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid Competition ID'], 404);
        }
    }

    /**
     * Get an individual competition's group tables
     *
     * @param int $competitionId
     * @return JsonResponse
     */
    public function competitionTableResults(int $competitionId): JsonResponse
    {
        try {
            $data = $this->_api->competitionTableResults($competitionId);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid Competition ID'], 404);
        }
    }

    /**
     * List all of the managers
     *
     * @return JsonResponse
     */
    public function managers(): JsonResponse
    {
        $data = $this->_api->managers();

        return response()->json($data, 200);
    }

    /**
     * List all of the matches for a specified manager
     *
     * @param int $managerId
     * @return JsonResponse
     */
    public function managerMatches(int $managerId): JsonResponse
    {
        try {
            $data = $this->_api->managerMatches($managerId);
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid Manager ID'], 404);
        }
    }

}
