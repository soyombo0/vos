<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Http\Services\TaskService;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service)
    {
    }

    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    public function store(TaskStoreRequest $request)
    {
        return TaskResource::make($this->service->store($request))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Task $task)
    {
        return TaskResource::make($task)
            ->response()
            ->setStatusCode(200);
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        return TaskResource::make($this->service->update($request, $task))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ])->setStatusCode(204);
    }
}
