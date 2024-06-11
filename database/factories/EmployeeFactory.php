<?php

namespace Database\Factories;
use App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * 
     */
    protected $model = Employee::class;
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'employee_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'user_ip' => $this->faker->ipv4,
            'user_mac' => $this->faker->macAddress,
        ];
    }
}
