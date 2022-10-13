<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\UserDetail;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    public function login(Request $request) {
        $rules = [
            'email'     => 'required|email',
            'password'  => 'required|min:8',
        ];

        $message = [
            'email.required'    => 'Mohon isikan email anda',
            'email.email'       => 'Mohon isikan email valid',
            'password.required' => 'Mohon isikan password anda',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        $data = [
            'email'     => $request->email,
            'password'  => $request->password,
        ];

        if(!Auth::attempt($data)) {
            return apiResponse(400, 'error', 'Data tidak terdaftar, akun bodong nya?');
        }

        $token = Auth::user()->createToken('API Token')->accessToken;

        $data   = [
            'token'     => $token,
            'user'      => Auth::user()->detail,
        ];

        return apiResponse(200, 'success', 'berhasil login', $data);
    }

    public function logout(){
        if(Auth::user()){
            $tokens =Auth::user()->tokens->pluck('id');
            Token::WhereIn('id',$tokens)->update([
                'revoked'=>true
            ]);
            RefreshToken::whereIn('access_token_id',$tokens)->update([
                'revoked'=>true
            ]);
        }
        return apiResponse(200, 'success', 'berhasil logout');

    }

    public function register(UserRequest $request){
        $request->validated();
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
}
