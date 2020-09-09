<?php

namespace App\Http\Middleware;

use App\UserRoleTerm;
use App\UserRoleTermAction;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check ()){
            $action = $request->route ()->getActionName ();
            $roleActionId = UserRoleTermAction::where('action',$action)->first(['id']);
            if($roleActionId){
                $roleCheck = UserRoleTerm::where('action_id',$roleActionId->id)->where('role_id',Auth::user ()->role_id)->first();
                if($roleCheck){
                   return $next($request);
                }
            }
        }
        return response ()->json ([
            'error' => 'perrmission',
            'type' => 'danger',
            'message' => 'Bu işlem için yetkiniz yok !'
        ],401);
    }
}
