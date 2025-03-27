<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(), // Cria um employee associado
            'value' => $this->faker->randomFloat(2, 100, 10000),
            'sale_date' => $this->faker->date(),
        ];
    }
}