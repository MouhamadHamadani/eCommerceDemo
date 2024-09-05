<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ["name" => "Orange", "images" => 3, "category" => 1],
            ["name" => "Strawberries", "images" => 3, "category" => 1],
            ["name" => "Cucumber", "images" => 2, "category" => 2],
            ["name" => "Lettuce", "images" => 2, "category" => 2],
            ["name" => "Tomato", "images" => 3, "category" => 2],
            ["name" => "Cheese", "images" => 3, "category" => 3],
            ["name" => "Milk", "images" => 4, "category" => 3],
            ["name" => "Chocolate Bar", "images" => 2, "category" => 4],
            ["name" => "Biscuits", "images" => 3, "category" => 5],
            ["name" => "Shampoo", "images" => 0, "category" => 6],
            ["name" => "Hand Soap", "images" => 0, "category" => 6],
            ["name" => "Hair Brush", "images" => 0, "category" => 6],
            ["name" => "Fresh Orange Juice", "images" => 3, "category" => 7],
            ["name" => "Fresh Strawberry Juice", "images" => 3, "category" => 7],
        ];

        foreach ($products as $product)
        {
            $prod = Product::create([
                "name" => $product["name"],
                "slug" => strtolower($product["name"]),
                "description" => $product["name"],
                "price" => rand(2, 50),
                "quantity" => rand(2, 100),
            ]);

            if($product["images"] > 0)
            {
                for ($i = 1; $i <= $product["images"]; $i++)
                {
                    ProductImage::create([
                        'product_id' => $prod->id,
                        'image' => $product["name"] . " ($i).png",
                    ]);
                }
            }
            else
            {
                ProductImage::create([
                    'product_id' => $prod->id,
                    'image' => $product["name"] . ".png",
                ]);
            }

            ProductCategory::create([
                'product_id' => $prod->id,
                'category_id' => $product["category"],
            ]);
        }
    }
}
