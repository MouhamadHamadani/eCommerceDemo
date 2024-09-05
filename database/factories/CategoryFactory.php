<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->text(rand(10,20));
        $category = Category::inRandomOrder()->first();
        $parent_id = null;
        if($category != null || $category != "")
        {
            $parent_id = $category->id;
        }
        return [
            'name' => $name,
            'image' => fake()->imageUrl(1024,1024,$name),
            'slug' => $name,
            'description' => fake()->paragraph(),
            'parent_id' => $parent_id
        ];
    }
}
