<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\IClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3, true),
            'code' => fake()->unique()->numberBetween(100, 200),
            'type' => rand(1,2),
            'class_id' => function () {
                return IClass::where('id','!=',1)->where('id','!=',2)->inRandomOrder()->first()->id;
            },
            'status' => '1',
        ];
    }
}
