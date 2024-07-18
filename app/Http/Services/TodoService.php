<?php

namespace App\Http\Services;

use Illuminate\Support\Str;
use App\Models\Todo;

class TodoService
{
    private $model;
    public function __construct()
    {
        $this->model = new Todo();
    }

    public function fetch($id)
    {
        return $this->model->find($id);
    }

    public function list()
    {
        return $this->model->all();
    }

    public function create($request)
    {
        $slug = Str::slug($request['title'] . '-' . now()->timestamp);
        $request['slug'] = $slug;

        return $this->model->create($request);
    }

    public function update($data, $id)
    {
        $model = $this->fetch($id);

        $model->title       = $data['title'];
        $model->description = isset($data['description']) ? $data['description'] : null;
        $model->status_id   = $data['status_id'];
        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->fetch($id);
        return $model?->delete() ?? false;
    }


}
