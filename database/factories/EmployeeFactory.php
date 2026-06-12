<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $user = \Database\Factories\UserFactory::new()->create();
        $designation = [2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20];
        return [
            'user_id' => $user->id,
            'role_id' => \App\Http\Helpers\AppHelper::USER_TEACHER,
            'id_card' => str_pad(fake()->unique()->numberBetween(1, 99), 10, '0', STR_PAD_LEFT),
            'name' => fake()->name(),
            'designation' => $designation[array_rand($designation, 1)],
            'qualification' => fake()->word(),
            'dob' => fake()->dateTimeBetween('-20 years', 'now', 'Asia/Dhaka')->format('d/m/Y'),
            'gender' => rand(1,2),
            'religion' => rand(1,5),
            'email'     => $user->email,
            'phone_no'  => fake()->e164PhoneNumber(),
            'address' => fake()->address(),
            'joining_date' => fake()->dateTimeBetween('-5 years', 'now', 'Asia/Dhaka')->format('d/m/Y'),
            'photo'     => null,
            'signature' => null,
            'shift' => rand(1,2),
            'duty_start' => '09:00 am',
            'duty_end'  => '05:00 pm',
            'status' => '1'
        ];
    }
}
