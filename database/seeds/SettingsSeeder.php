<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ('settings')->insert ([
                [
                    'option_name'=>'site_name',
                    'option_value'=>'New App',
                ],
                [
                    'option_name'=>'site_mail',
                    'option_value'=>'info@new.app',
                ],
                [
                    'option_name'=>'google_analytics',
                    'option_value'=>'',
                ],
                [
                    'option_name'=>'header_code',
                    'option_value'=>'',
                ],
                [
                    'option_name'=>'footer_code',
                    'option_value'=>'',
                ]
            ]
        );
    }
}
