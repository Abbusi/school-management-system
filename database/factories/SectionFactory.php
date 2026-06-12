<?php

namespace Database\Factories;

use App\Models\Section;
use App\Models\IClass;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition(): array
    {
        return [
            'name' => strtoupper(fake()->unique()->randomLetter()),
            'capacity' => rand(20,40),
            'class_id' => function(){
                return IClass::where('id','!=',1)->inRandomOrder()->first()->id;
            },
            'teacher_id' => function () {
                return Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first()->id;
            },
            'note' => fake()->sentence(),
            'status' => '1',
        ];
    }
}
