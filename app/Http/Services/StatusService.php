<?php

namespace App\Http\Services;

use App\Models\Status;

class StatusService
{
    private $model;
    public function __construct()
    {
        $this->model = new Status();
    }

    public function fetchFromSlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
