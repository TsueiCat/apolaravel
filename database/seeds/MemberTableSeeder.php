<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use APOSite\Models\User as User;

class MemberTableSeeder extends Seeder
{
    public function run()
    {
        $admin = new User();
        $admin->cwruID = 'jow5';
        $admin->first_name = 'James';
        $admin->last_name = 'Wright';
        $admin->save();
        // TestDummy::times(20)->create('App\Post');
    }
}
