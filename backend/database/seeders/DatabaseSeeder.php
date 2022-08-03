<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Nova\QueueStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Area::factory(1)->create();
        \App\Models\Location::factory(5)->create();
        \App\Models\User::factory(1)->create();
        \App\Models\Admin::factory(1)->create();

        Setting::insert([
            'default_locale' => 'en',
        ]);

//         QueueStatus::insert([
//            [
//                'locale' => 'en',
//                'name'   => '',
//                'color'  => '',
//                'sort'   => ''
//            ]
//         ]);
    }
}
