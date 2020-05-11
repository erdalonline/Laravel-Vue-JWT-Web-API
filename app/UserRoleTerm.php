<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRoleTerm extends Model
{
    //
    protected $fillable = ['role_id', 'action_id'];

    public function actions(){
        return $this->hasMany('App\UserRoleTermAction');
    }

}
