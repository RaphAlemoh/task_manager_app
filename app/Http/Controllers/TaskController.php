<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        $tasks = Task::with('user', 'team')->latest()->get();

        return $this->showOne($tasks, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'text' => ['required',  'string', 'min:5', 'max:50'],
            'team_id' => ['nullable',  'string']
        ]);

        DB::beginTransaction();
        try {

            $task = new Task();
            $task->text = $request->text;
            if ($request->team_id != '') $task->team_id =  $request->team_id;
            $task->user_id = auth()->user()->id;
            $task->save();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), 400);

            Log::error(__METHOD__ . $exception->getTraceAsString());
        }

        DB::commit();

        return response()->json([
            'message' => 'Task successfully created.'
        ]);
    }

    public function delete(Request $request)
    {
        $task = Task::find($request->id);
        $task->delete();

        return response()->json([
            'message' => 'Task successfully deleted.'
        ]);
    }
}
