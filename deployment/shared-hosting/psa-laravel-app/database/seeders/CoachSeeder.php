<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coach;

class CoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coaches = [
            [
                'name' => 'Rajesh Kumar',
                'email' => 'rajesh@psa.com',
                'phone' => '9876543210',
                'specialization' => 'Cricket',
                'experience' => 8,
                'qualifications' => 'Level 2 Cricket Coach',
                'is_active' => true
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya@psa.com',
                'phone' => '9876543211',
                'specialization' => 'Football',
                'experience' => 5,
                'qualifications' => 'AFC C License',
                'is_active' => true
            ],
            [
                'name' => 'Amit Singh',
                'email' => 'amit@psa.com',
                'phone' => '9876543212',
                'specialization' => 'Basketball',
                'experience' => 6,
                'qualifications' => 'Basketball Coach Level 1',
                'is_active' => true
            ]
        ];

        foreach ($coaches as $coachData) {
            Coach::create($coachData);
        }
    }
}
