<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'title'       => 'Pending',
                'description' => 'Task is still in progress.',
                'slug'        => Str::slug('pending'),
            ],
            [
                'title'       => 'Completed',
                'description' => 'Task has been finished.',
                'slug'        => Str::slug('completed'),
            ],
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate(['slug' => $status['slug']], $status);
        }
    }
}
