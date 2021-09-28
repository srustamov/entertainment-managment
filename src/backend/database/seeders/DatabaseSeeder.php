<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
         \App\Models\Area::factory(1)->create();
         \App\Models\Location::factory(5)->create();
         \App\Models\User::factory(1)->create();
         \App\Models\Admin::factory(1)->create();
    }
}
