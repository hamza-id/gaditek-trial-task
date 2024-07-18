<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\TodoRequest;
use App\Http\Services\TodoService;
use App\Helpers\ResponseHelper;
use App\Http\Services\StatusService;
use Exception;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $todos = $this->todoService->list();
            return ResponseHelper::success($todos, 'Todos retrieved successfully.');
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve todos.', 500, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request)
    {
        try {
            $statusService = new StatusService();
            $status        = $statusService->fetchFromSlug($request->status);

            //replace status from status id
            $validatedData = $this->mergeStatusId($request->validated(), $status->id);

            $todo = $this->todoService->create($validatedData);
            return ResponseHelper::success($todo, 'Todo created successfully.', 201);
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to create todo.', 500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $todo = $this->todoService->fetch($id);
            return ResponseHelper::success($todo, 'Todo retrieved successfully.');
        } catch (Exception $e) {
            return ResponseHelper::error('Todo not found.', 404, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, string $id)
    {
        try {
            $statusService = new StatusService();
            $status        = $statusService->fetchFromSlug($request->status);

            //replace status from status id
            $validatedData = $this->mergeStatusId($request->validated(), $status->id);

            $todo = $this->todoService->update($validatedData, $id);

            return ResponseHelper::success($todo, 'Todo updated successfully.');
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to update todo.', 500, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->todoService->delete($id);
            return ResponseHelper::success(null, 'Todo deleted successfully.');
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to delete todo.', 500, $e->getMessage());
        }
    }

    private function mergeStatusId($validatedData, $status_id)
    {
        $validatedData['status_id'] = $status_id;
        unset($validatedData['status']);
        return $validatedData;
    }
}
