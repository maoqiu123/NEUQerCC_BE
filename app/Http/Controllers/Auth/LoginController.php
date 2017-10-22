<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{

    public function login($phone,$password)
    {
        if ($phone != '' ){
            if($user = User::where('phone',$phone)->first()){
                if (Hash::check($password, $user->password)){
                    return response()->json(['code'=>0,'msg'=>'登陆成功']);
                }else{
                    return response()->json(['code'=>1,'msg'=>'密码错误']);
                }
            }else{
                return response()->json(['code'=>2,'msg'=>'用户名或密码错误']);
            }
        }else{
            return response()->json(['code'=>3,'msg'=>'手机号不能为空']);
        }
    }


//    public function setToken($wechatnum){
//        $user = User::where('wechatnum',$wechatnum)->first();
//        $token = sha1(md5($user->wechatnum . time()));
//        $user->token = $token;
//        Cookie::queue('token',$token);
//        $user->token_exp = time()+7200;
//        if($user->save()){
//            session(['username' => $user->username]);
//            return view('index/index');
//        }else{
//            return response()->json(['code'=>3,'msg'=>'登录失败']);
//        }
//    }

    public function loginout()
    {
        setcookie('token','');
        return view('login/login');
    }




}
