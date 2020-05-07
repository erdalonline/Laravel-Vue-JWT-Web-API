<?php

use Illuminate\Database\Seeder;

class UserRoleTermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = \App\UserRoleTermAction::all (['id']);
        foreach ($actions as $item){
            DB::table('user_role_terms')->insert([
                'role_id' => 1,
                'action_id' => $item->id
            ]);
        }
    }
}
