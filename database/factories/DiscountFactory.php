<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $percentage = rand(0, 1);
        $start_date = fake()->dateTimeBetween('-10 days');
        $end_date = fake()->dateTimeInInterval($start_date, '+' . rand(1, 10) . ' days');
        return [
            'name' => fake()->word(),
            'discount_amount' => $percentage ? null : rand(5, 50),
            'discount_percentage' => $percentage ? rand(5, 50) : null,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
