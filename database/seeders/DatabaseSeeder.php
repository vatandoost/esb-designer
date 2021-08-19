<?php

namespace Database\Seeders;

use App\Models\Ns;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = User::factory()->create();
        $project = Project::factory(2)->for($user)->hasNamespaces(3)->create();
        //Ns::factory(2)->for(Project::factory())->create();
    }
}
