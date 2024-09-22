<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        // Category::factory(rand(1, 10))->create();
        // Category::factory(rand(5, 20))->create();
        $this->call(DiscountSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        // Slides::factory(2)->create();
        $this->call(SlideSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
