<?php

namespace App\Http\Controllers;


use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = UserRole::all ();
        $tmp = array();
        foreach ($roles as $role){
            array_push ($tmp, array(
                'value' => $role->id,
                'text' => $role->name,
                'description' => $role->description
            ));
        }
        return response ()->json ($tmp);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Rol adı Gereklidir!',
        ];

        $validator = Validator::make ($request->all (), $rules, $messages);

        if ( $validator->fails() )
        {
            return response ()->json($validator->errors (), 401);
        }

        $userRole = UserRole::create ([
            'name' => $request->name,
            'description' => $request->description
        ]);

        if ($userRole) {
            return response ()->json ([
                'error' => 'success',
                'value' => $userRole->id,
                'text' => $userRole->name,
                'description'=> $userRole->description
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
