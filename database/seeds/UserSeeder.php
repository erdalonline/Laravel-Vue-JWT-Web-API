<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table ('users')->insert ([
            'name'=>'Yusuf ERDAL',
            'role_id' => 1,
            'email'=>'admin@admin.com',
            'password'=>\Illuminate\Support\Facades\Hash::make ('password')
        ]);
    }
}
