<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\IClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3, true),
            'elective_subject_point_addition' => rand(0,2),
            'marks_distribution_types' => json_encode(array_rand(\App\Http\Helpers\AppHelper::MARKS_DISTRIBUTION_TYPES, 3)),
            'class_id' => function () {
                return IClass::where('id','!=',1)->inRandomOrder()->first()->id;
            },
            'status' => '1',
        ];
    }
}
