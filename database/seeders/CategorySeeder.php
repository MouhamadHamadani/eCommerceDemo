<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_name = ["Fruits", "Vegetables", "Dariry", "Choclate", "Biscuts", "Cosmatics", "Juice"];

        foreach ($category_name as $name)
        {
            Category::create([
                "name" => $name
            ]);
        }
    }
}
