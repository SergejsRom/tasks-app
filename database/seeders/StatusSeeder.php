<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Open'],
            ['name' => 'Pending'],
            ['name' => 'In-progress'],
            ['name' => 'In-review'],
            ['name' => 'Accepted'],
            ['name' => 'Rejected'],
            
        ];
        Status::insert($statuses);
    }
}
