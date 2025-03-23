<?php

namespace Database\Seeders;

use App\Models\ShootingTraining;
use App\Models\ShotTraining;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShotTrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'date' => '2023-01-01',
                'duration' => '2',
                'location' => 'Left Corner',
                'shotMade' => '8',
                'attempt' => '10',
            ],
            [
                'date' => '2023-01-01',
                'duration' => '2',
                'location' => 'Right Corner',
                'shotMade' => '8',
                'attempt' => '10',
            ],
            [
                'date' => '2023-01-01',
                'duration' => '2',
                'location' => 'Left Wing',
                'shotMade' => '10',
                'attempt' => '10',
            ],
            [
                'date' => '2023-01-01',
                'duration' => '2',
                'location' => 'Right Wing',
                'shotMade' => '10',
                'attempt' => '10',
            ],
            [
                'date' => '2023-01-01',
                'duration' => '2',
                'location' => 'Top',
                'shotMade' => '9',
                'attempt' => '10',
            ],
        ];

        foreach ($data as $shotTraining) {
            ShotTraining::create($shotTraining);
        }
    }
}
