<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return response()->json(Team::all()->toArray());
    }

    public function store(Request $request)
    {
        $team = Team::create($request->only('name'));

        return response()->json([
            'status' => (bool)$team,
            'message' => $team ? 'Team Created' : 'Error Creating Team'
        ]);
    }

    public function show(Team $team)
    {
        return response()->json($team);
    }

    public function tasks(Team $team)
    {
        return response()->json($team->tasks()->orderBy('order')->get());
    }

    public function update(Request $request, Team $team)
    {
        $status = $team->update($request->only('name'));

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Team Updated!' : 'Error Updating Team'
        ]);
    }

    public function destroy(Team $team)
    {
        $status = $team->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Team Deleted' : 'Error Deleting Team'
        ]);
    }
}
