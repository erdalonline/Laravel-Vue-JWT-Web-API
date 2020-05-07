<?php

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            [
                'name' => 'Administrator',
                'description' => 'Tüm yetkilere sahip.'
            ],
            [
                'name' => 'Editor',
                'description' => 'Sadece düzenleme yetkisine sahip..'
            ],
        ]);
    }
}
