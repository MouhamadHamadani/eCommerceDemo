<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_name = ["Fruits", "Vegetables", "Dairy", "Chocolate", "Biscuits", "Cosmetics", "Juice"];

        foreach ($category_name as $name)
        {
            Category::create([
                "name" => $name,
                "image" => $name . ".png",
                "slug" => Str::slug($name),
                "description" => $name
            ]);
        }
    }
}
