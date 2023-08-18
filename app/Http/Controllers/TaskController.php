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

    public function index()
    {
        $tasks = Task::with('user', 'team')->latest()->get()->toArray();

        return $this->showOne($tasks, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required',  'string', 'min:3', 'max:50'],
            'team_id' => ['nullable',  'string'],
            'user_id' => ['required',  'string'],
            'order' => ['required',  'string']
        ]);

        DB::beginTransaction();
        try {
            // if ($request->team_id != '') $task->team_id =  $request->team_id;
            $task = Task::create([
                'name' => $request->name,
                'team_id' => $request->team_id,
                'user_id' => $request->user_id,
                'order' => $request->order
            ]);

            return response()->json([
                'status' => (bool)$task,
                'data' => $task,
                'message' => $task ? 'Task Created!' : 'Error Creating Task'
            ]);
            // return $this->showOne($teams, 200);


        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), 400);
            Log::error(__METHOD__ . $exception->getTraceAsString());
        }

        DB::commit();
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $status = $task->update(
            $request->only(['name', 'category_id', 'user_id', 'order'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Task Updated!' : 'Error Updating Task'
        ]);
    }

    public function destroy(Task $task)
    {
        $status = $task->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Task Deleted!' : 'Error Deleting Task'
        ]);
    }
}
