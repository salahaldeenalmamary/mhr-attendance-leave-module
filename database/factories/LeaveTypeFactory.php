<?php

namespace Database\Factories;

use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveTypeFactory extends Factory
{
    protected $model = LeaveType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word() . ' Leave',
            'description' => $this->faker->sentence(),
            'default_annual_entitlement' => $this->faker->numberBetween(5, 30),
            'requires_approval' => $this->faker->boolean(70), // 70% chance
            'is_paid' => $this->faker->boolean(80), // 80% chance
        ];
    }
}
