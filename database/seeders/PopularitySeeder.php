<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfigPopularity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PopularitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ConfigPopularity::insert([
            [
                'minimum_value' => 0,
                'maximum_value' => 100,
                'type' => 'likes',
                'grade' => 'unsatisfactory'
            ],
            [
                'minimum_value' => 101,
                'maximum_value' => 200,
                'type' => 'likes',
                'grade' => 'below_average'
            ],
            [
                'minimum_value' => 201,
                'maximum_value' => 300,
                'type' => 'likes',
                'grade' => 'good'
            ],
            [
                'minimum_value' => 301,
                'maximum_value' => 400,
                'type' => 'likes',
                'grade' => 'exceptional'
            ],
            [
                'minimum_value' => 401,
                'maximum_value' => 500,
                'type' => 'likes',
                'grade' => 'excellent'
            ],
        ]);
    }
}
