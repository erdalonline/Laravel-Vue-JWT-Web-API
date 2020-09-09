<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all ();
        $tmp = array();

        foreach ($users as $user) {
            array_push ($tmp, array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'role' => $user->getRole->name,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'email'  => 'required|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required'
        ];

        $messages = [
            'name.required' => 'Kullanıcı adı Gereklidir!',
            'required'      => 'Gerekli alanları giriniz.',
            'email.unique' => 'Bu E-posta daha önce kayıt edilmiş!',
            'password.min' => 'Girilen şifre en az 6 karakter olmalıdır!',
        ];

        $validator = Validator::make ($request->all (), $rules, $messages);

        if ( $validator->fails() )
        {
            return response ()->json($validator->errors (), 401);
        }

        $user = User::create ([
            'name'=>$request->name,
            'role_id'=>$request->role_id,
            'email'=>$request->email,
            'password'=>Hash::make ($request->password),
        ]);

        if ($user) {

            return response ()->json ([
                'error' => 'success',
                'id' => $user->id,
                'name'=> $user->name,
                'role_id'=> $user->role_id,
                'email'=> $user->email,
                'role' => $user->getRole->name
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response ()->json ($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
//            'email'  => 'required|unique:users,email',
            'password' => 'nullable|min:6',
            'role_id' => 'required'
        ];

        $messages = [
            'name.required' => 'Kullanıcı adı Gereklidir!',
            'required'      => 'Gerekli alanları giriniz.',
//            'email.unique' => 'Bu E-posta daha önce kayıt edilmiş!',
            'password.min' => 'Girilen şifre en az 6 karakter olmalıdır!',
        ];

        $validator = Validator::make ($request->all (), $rules, $messages);

        if ( $validator->fails() )
        {
            return response ()->json($validator->errors (), 401);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->role_id = $request->role_id;
        if (!empty($request->password)){
            $user->password = Hash::make ($request->password);
        }
        $user->save();
        if ($user){
            return  response ()->json ($user);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::id () != $id){ // oturumu açık olanı silme
            User::destroy ($id);
            $data['success'] = true;
            $data['message'] = 'Kullanıcı başarı ile silindi';
            return response ()->json ($data);
        }
    }
}
