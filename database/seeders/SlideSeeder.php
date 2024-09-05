<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slides;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Slides::factory()->create([
            'image' => 'slide.png',
            'title' => 'Fresh Fruit',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.',
            'link' => '/'
        ]);
        Slides::factory()->create([
            'image' => 'slide-2.png',
            'title' => 'Fresh Vegetables',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.',
        ]);
        Slides::factory()->create([
            'image' => 'slide-3.png',
        ]);
    }
}
