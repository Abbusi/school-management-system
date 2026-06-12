<?php

namespace Database\Factories;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveFactory extends Factory
{
    protected $model = Leave::class;

    public function definition(): array
    {
        return [
            'employee_id' => function () {
                return Employee::inRandomOrder()->first()->id;
            },
            'leave_type' => rand(1,2),
            'leave_date' => fake()->dateTimeThisMonth('now', 'Asia/Dhaka')->format('d/m/Y'),
            'document' => null,
            'description' => fake()->sentence(),
            'status' => rand(1,3)
        ];
    }
}
