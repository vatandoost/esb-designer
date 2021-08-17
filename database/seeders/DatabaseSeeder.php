<?php

namespace Database\Seeders;

use App\Models\Ns;
use App\Models\Project;
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
        Ns::factory(2)->create();
        Project::factory(2)->create();

    }
}
