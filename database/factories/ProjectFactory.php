<?php

namespace Database\Factories;

use App\Models\Ns;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $namespace = Ns::take(1)->first();
        $owner = User::take(1)->first();
        return [
            'name' => $this->faker->text(50),
            'namespace_id' => $namespace->id,
            'owner_id' => $owner->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
