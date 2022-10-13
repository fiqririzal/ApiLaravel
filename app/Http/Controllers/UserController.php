<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\UserDetail;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{
    public function index()
    {
        $user = User::with('user_detail')->get();

        return apiResponse(200, 'success', 'List user', $user);

    }
    public function destroy($id) {
        try {
            DB::transaction(function () use ($id) {
                User::where('id', $id)->delete();
            });

            return apiResponse(202, 'success', 'user berhasil dihapus :(');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }
    public function show($id) {
        $user = User::where('id', $id)->first();

        if($user) {
            return apiResponse(200, 'success', 'data '.$user->name, $user->detail);
        }

        return apiResponse(40, 'success', 'User tidak ditemukan :(');
    }
    public function store(UserRequest $request){
        // $request->validated();
        try{
            DB::transaction(function ()use($request) {
                $id = User::insertGetId([
                    'name'=>request('name'),
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                    'created_at'=>date('Y-m-d H-i-s')
                ]);
                UserDetail::insert([
                    'user_id'=>$id,
                    'address'=>$request->address,
                    'phone'=>$request->phone,
                    'hobby'=>$request->hobby,
                    'created_at'=>date('Y-m-d H-i-s')
                ]);
            });
            return apiResponse(201, 'success', 'user berhasil daftar');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }
    public function update(Request $request, $id){
        $rules =[
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'hobby'=>'required'

        ];
        $message =[
            'name.required'=>'mohon isikan nama anda',
            'email.required'=>'mohon isikan email anda',
            'email.email'=>'mohon isikan email valid',
            'email.unique'=>'email sudah terdaftar',
            'password.required'=>'mohon isikan paswwordd anda anda',
            'address.required'=>'mohon isikan alamat anda',
            'phone.required'=>'mohon isikan telepon anda',
            'hobby.required'=>'mohon isikan hobby anda'
        ];

        $validator =Validator::make($request->all(),$rules,$message);
            if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            }
        try{
            DB::transaction(function ()use($request,$id) {
                User::where('id',$id)->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                    'updated_at'=>date('Y-m-d H-i-s')
                ]);
                UserDetail::where('id',$id)->update([
                    'user_id'=>$id,
                    'address'=>$request->address,
                    'phone'=>$request->phone,
                    'hobby'=>$request->hobby,
                    'updated_at'=>date('Y-m-d H-i-s')
                ]);
            });
            return apiResponse(202, 'success', 'user berhasil disunting');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }
}
