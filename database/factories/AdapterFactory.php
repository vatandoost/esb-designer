<?php

namespace Database\Factories;

use App\Models\Adapter;
use App\Statics\AdapterType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdapterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Adapter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'type' => array_rand(array_keys(AdapterType::labels())),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
