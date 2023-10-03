<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $news = 'News';
        $sports = 'Sports';
        $business = 'Business';
        $tech = 'Tech';
        $others = 'Others';

        $list = collect([
            $news,
            $sports,
            $business,
            $tech,
            $others,
        ])->map(function ($category) {
            return [
                'name' => $category,
                'slug' => Str::slug($category, '-'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        })->toArray();

        DB::table('categories')->insert($list);
    }
}
