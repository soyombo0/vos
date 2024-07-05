<?php

namespace App\Http\Services;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskService
{
    public function index(Request $request)
    {
        if ($request->has('status')) {
            $status = request()->query('status');
            return TaskResource::collection(Task::query()->where('status', $status)->get())
                ->response()
                ->setStatusCode(200);
        }

        if ($request->has('date')) {
            $date = request()->query('date');
            return TaskResource::collection(Task::query()->whereDate('created_at', $date)->get())
                ->response()
                ->setStatusCode(200);
        }

        return TaskResource::collection(Task::all())
            ->response()
            ->setStatusCode(200);
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();

        return Task::query()->create($data);
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $data = $request->validated();

        $task->update($data);

        return $task;
    }
}
