<?php

namespace App\Http\Controllers;


use App\Setting;

class HomeController extends Controller
{
    public function index(){

        $app =Setting::add  ('app_name','Laravel');
        dd ($app);


    }
}
