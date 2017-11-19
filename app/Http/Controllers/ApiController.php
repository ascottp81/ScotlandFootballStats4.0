<?php

namespace App\Http\Controllers;

use App\Models\Opponent;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * List all of the opponents
     *
     * @return JSON
     */
    public function opponents()
    {
        $output = Opponent::orderBy('name','asc')->get(['id', 'name', 'abbr_name']);
        return response()->json($output, 201);
    }

    public function index()
    {
        //$output = Article::all();

        $output = Article::get(['id', 'title', 'user_id'])->all();

        $app = app();
        $i = 0;
        foreach ($output as $op) {
            $op->date = "1980";

            $op->more = $app->make('stdClass');
            $op->more->name = "SCott";
            $op->more->surname = "Pinkerton";
            $op->more->title = "mr";

            $op->test = $i;
            $i++;

            //$op->user = $op->user()->first();
            $op->user = $op->user()->get(['name'])->first();
            unset($op->user_id);

        }

        //return $output[1]->more->name;

        return $output;
    }
}
