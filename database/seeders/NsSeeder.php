<?php

namespace Database\Seeders;

use App\Models\Ns;
use Illuminate\Database\Seeder;

class NsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ns::factory(2)->create();
    }
}
