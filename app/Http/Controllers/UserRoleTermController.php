<?php

namespace App\Http\Controllers;

use App\UserRole;
use App\UserRoleTerm;
use App\UserRoleTermAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;

class UserRoleTermController extends Controller
{
    /**
     * Rolleri listeler.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoleActions($id)
    {
        $roleCheck=UserRole::find ($id);
        if (!$roleCheck) {
            return response ()->json ([
                'error'=>'novariable',
                'type'=>'danger',
                'message'=>'Böyle bir rol yok!'
            ], 401);
        }

        $activeActions=UserRoleTerm::where ('role_id', $id)->get ();
        $allActions=UserRoleTermAction::all ();

        $actionListTmp=array();

        /**
         * izin verilen ve verilmeyen methodları belirleme
         */

        foreach ($allActions as $action) {
            foreach ($activeActions as $active) {
                if ($active->action_id == $action->id) {
                    $action->selected=true;
                    array_push ($actionListTmp, $action);
                    unset($action);
                    break;
                }
            }
            if (isset($action)) {
                $action->selected=false;
                array_push ($actionListTmp, $action);
            }
        }

        /**
         * methodları top_id ana controller'a göre gruplama
         */
        $actionListTmp=collect ($actionListTmp)->toArray ();
        $tmp=array();
        foreach ($actionListTmp as $item) {
            if ($item['top_id'] == 0) {
                $item['sub']=array();
                $tmp[$item['id']]=$item;
            } else {
                array_push ($tmp[$item['top_id']]['sub'], $item);
            }
        }

        return response ()->json ($tmp);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setRoleActions(Request $request, $id)
    {


        try {
            $oldActions=Http::withToken ($request->bearerToken ())->get (route ('getActions', $id));
            if (!$oldActions->ok ()) {
                throw new \Exception('roller getirilemedi!');
            }

            $oldActions = json_decode ($oldActions->body (), true);

            /**
             * rolleri karşılaştırma
             */

            foreach ($request->all () as $index => $value) {
                foreach ($value['sub'] as $subItem => $subValue){
                     if($oldActions[$index]['sub'][$subItem]['selected'] == false && $subValue['selected'] == true) // yoksa ekle
                     {
                         /**
                          * rol yoksa ekle
                          */
                            $newRoleterm = new UserRoleTerm();
                            $newRoleterm->role_id = $id;
                            $newRoleterm->action_id = $subValue['id'];
                            $newRoleterm->save ();
                            if (!$newRoleterm){
                                throw new Exception('Rol eklenirken bir hata oluştu daha sonra tekrar deneyin!');
                            }
                     }
                     else if($oldActions[$index]['sub'][$subItem]['selected'] == true && $subValue['selected'] == false) // var sa sil
                     {
                         /**
                          * rol iptal edilmiş ise sil ..
                          */

                         $deleteRoleTerm = UserRoleTerm::where('action_id',$subValue['id'])->where('role_id',$id)->delete();

                         if (!$deleteRoleTerm){
                             throw new Exception('Rol silinirken bir hata oluştu daha sonra tekrar deneyin!');
                         }
                     }
                     else{

                     }
                }
            }

            $newActions = Http::withToken ($request->bearerToken ())->get (route ('getActions', $id));
            if (!$newActions->ok ()) {
                throw new \Exception('yeni roller getirilemedi!');
            }
            return response ($newActions);

        } catch (\Exception $exception) {
            return response ()->json ([
                'error'=>'fatal error',
                'type'=>'danger',
                'message'=>$exception->getMessage ()
            ]);
        }

    }

}
