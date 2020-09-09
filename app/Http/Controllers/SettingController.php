<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tüm ayarları liste
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        return response ()->json (Setting::getAllSettings ());
    }

    public function update(Request $request){
        if ($request->post ()){
            foreach ($request->all () as $key => $value){
                Setting::set ($key,$value);
            }
        }
        $data['success'] = true;
        $data['message'] = 'Ayarlar başarı ile güncellendi!';
        return response ()->json ($data);
    }
}
