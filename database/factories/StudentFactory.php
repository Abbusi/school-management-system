<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $user = \Database\Factories\UserFactory::new()->create();
        return [
            'user_id' => $user->id,
            'name' => fake()->name(),
            'dob' => fake()->dateTimeBetween('-20 years', 'now', 'Asia/Dhaka')->format('d/m/Y'),
            'gender' => rand(1,2),
            'religion' => rand(1,5),
            'blood_group' => rand(1,8),
            'nationality' => substr(fake()->country(), 0, 48),
            'photo' => null,
            'email' => $user->email,
            'phone_no' => fake()->e164PhoneNumber(),
            'extra_activity' => '',
            'note' => '',
            'father_name' => fake()->name('male'),
            'father_phone_no' => fake()->e164PhoneNumber(),
            'mother_name' => fake()->name('female'),
            'mother_phone_no' => fake()->e164PhoneNumber(),
            'guardian' => null,
            'guardian_phone_no' => null,
            'present_address' => fake()->address(),
            'permanent_address' => fake()->address(),
            'status' => '1',
        ];
    }
}
