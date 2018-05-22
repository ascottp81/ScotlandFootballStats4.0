<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Classes\Api;
use App\Models\CompetitionType;
use App\Models\News;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ApiNewController extends Controller
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
     * List all of the news articles
     *
     * @return JsonResponse
     */
    public function news(): JsonResponse
    {
        $news = News::recent()->get(['id', 'title']);
        $output = [ "news" => $news ];

        return response()->json($output, 200);
    }

    /**
     * List all of the opponents for android
     *
     * @return JsonResponse
     */
    public function opponents(): JsonResponse
    {
        try {
            $data = $this->_api->opponentPlayed('android');
            return response()->json($data, 200);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid Opponent ID'], 404);
        }
    }

    /**
     * List all of the competitions
     *
     * @return JsonResponse
     */
    public function competitions(): JsonResponse
    {
        $competitions = CompetitionType::where('title','<>','Friendly')->orderBy('priority','asc')->get(['id','title','status']);
        $output = [ 'competitions' => $competitions ];

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
        $competitions = CompetitionType::find($typeId)->competitions()->orderBy('year','asc')->orderBy('stage','desc')->get(['id','name']);
        $output = [ 'competitions' => $competitions ];

        return response()->json($output, 200);
    }

}
