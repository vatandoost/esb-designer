<?php

namespace Database\Factories;

use App\Models\Db;
use Illuminate\Database\Eloquent\Factories\Factory;

class DbFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Db::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
