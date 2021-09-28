<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Samir',
            'email' => 'rustemovv96@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$9HvV4pXxwV/zY00fvU6y4ud6Cc1Nk/48gl5e1CirXpSemMElBf/d2',
            'remember_token' => Str::random(10),
        ];
    }
}
