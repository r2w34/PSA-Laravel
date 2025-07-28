<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sport;
use App\Models\Batch;

class SportsAndBatchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Sports
        $sports = [
            [
                'name' => 'Cricket',
                'description' => 'Traditional cricket training with focus on batting, bowling, and fielding',
                'fee_structure' => [
                    'monthly' => 2000,
                    'quarterly' => 5500,
                    'yearly' => 20000
                ],
                'is_active' => true
            ],
            [
                'name' => 'Football',
                'description' => 'Football training covering all aspects of the game',
                'fee_structure' => [
                    'monthly' => 1800,
                    'quarterly' => 5000,
                    'yearly' => 18000
                ],
                'is_active' => true
            ],
            [
                'name' => 'Basketball',
                'description' => 'Basketball skills development and team play',
                'fee_structure' => [
                    'monthly' => 1500,
                    'quarterly' => 4200,
                    'yearly' => 15000
                ],
                'is_active' => true
            ],
            [
                'name' => 'Tennis',
                'description' => 'Individual tennis coaching and group sessions',
                'fee_structure' => [
                    'monthly' => 2500,
                    'quarterly' => 7000,
                    'yearly' => 25000
                ],
                'is_active' => true
            ],
            [
                'name' => 'Badminton',
                'description' => 'Badminton training for all skill levels',
                'fee_structure' => [
                    'monthly' => 1200,
                    'quarterly' => 3300,
                    'yearly' => 12000
                ],
                'is_active' => true
            ]
        ];

        foreach ($sports as $sportData) {
            Sport::create($sportData);
        }

        // Get created sports
        $cricket = Sport::where('name', 'Cricket')->first();
        $football = Sport::where('name', 'Football')->first();
        
        // Get created coaches
        $cricketCoach = \App\Models\Coach::where('specialization', 'Cricket')->first();
        $footballCoach = \App\Models\Coach::where('specialization', 'Football')->first();

        // Create Batches
        $batches = [
            [
                'name' => 'Morning Batch A',
                'sport_id' => $cricket->id,
                'coach_id' => $cricketCoach->id,
                'schedule' => [
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                    'start_time' => '06:00',
                    'end_time' => '08:00'
                ],
                'max_capacity' => 20,
                'current_capacity' => 0,
                'skill_level' => 'beginner',
                'is_active' => true
            ],
            [
                'name' => 'Morning Batch B',
                'sport_id' => $football->id,
                'coach_id' => $footballCoach->id,
                'schedule' => [
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                    'start_time' => '08:30',
                    'end_time' => '10:30'
                ],
                'max_capacity' => 20,
                'current_capacity' => 0,
                'skill_level' => 'intermediate',
                'is_active' => true
            ],
            [
                'name' => 'Evening Batch A',
                'sport_id' => $cricket->id,
                'coach_id' => $cricketCoach->id,
                'schedule' => [
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                    'start_time' => '16:00',
                    'end_time' => '18:00'
                ],
                'max_capacity' => 25,
                'current_capacity' => 0,
                'skill_level' => 'beginner',
                'is_active' => true
            ],
            [
                'name' => 'Evening Batch B',
                'sport_id' => $football->id,
                'coach_id' => $footballCoach->id,
                'schedule' => [
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                    'start_time' => '18:30',
                    'end_time' => '20:30'
                ],
                'max_capacity' => 25,
                'current_capacity' => 0,
                'skill_level' => 'advanced',
                'is_active' => true
            ],
            [
                'name' => 'Weekend Special',
                'sport_id' => $cricket->id,
                'coach_id' => $cricketCoach->id,
                'schedule' => [
                    'days' => ['saturday', 'sunday'],
                    'start_time' => '09:00',
                    'end_time' => '12:00'
                ],
                'max_capacity' => 30,
                'current_capacity' => 0,
                'skill_level' => 'beginner',
                'is_active' => true
            ]
        ];

        foreach ($batches as $batchData) {
            Batch::create($batchData);
        }
    }
}
