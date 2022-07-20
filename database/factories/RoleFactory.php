<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'music_genre' => 'Pop',
            'age' => '26',
            'address'=>$this->faker->address,
            'lat'=>$this->faker->latitude(38, 39),
            'lng'=>$this->faker->longitude(2, 3)
        ];
    }
}
