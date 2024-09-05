<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
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
        // User::factory(10)->create();
        Category::factory(rand(1, 10))->create();
        Category::factory(rand(5, 20))->create();

        for ($i=0; $i < 5; $i++) {
        $product = Product::create([
            'name' => 'Fresh Orange Juice',
            'slug' => 'Fresh Orange Juice' . $i,
            'description' => 'Fresh Orange Juice',
            'price' => 2.5,
            'quantity' => 10
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'Fresh Orange Juice.png',
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'Fresh Orange Juice 2.png',
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'Fresh Orange Juice 3.png',
        ]);

        ProductCategory::create([
            'product_id' => $product->id,
            'category_id' => Category::inRandomOrder()->first()->id,
        ]);

        $product = Product::create([
            'name' => 'Fresh Strawberry Juice',
            'slug' => 'Fresh Strawberry Juice' . $i,
            'description' => 'Fresh Strawberry Juice',
            'price' => 3.5,
            'quantity' => 10
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'Fresh Strawberry Juice.png',
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'Fresh Strawberry Juice 2.png',
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'Fresh Strawberry Juice 3.png',
        ]);

        ProductCategory::create([
            'product_id' => $product->id,
            'category_id' => Category::inRandomOrder()->first()->id,
        ]);
    }
        // Slides::factory(2)->create();
        $this->call(SlideSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
