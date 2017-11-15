<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/10
 * Time: 20:01
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $register = new RegisterController();
        return $register->register( $request->phone,$request->password);
    }
    public function sms(Request $request){
        $sms = new RegisterController();
        return $sms->sms($request->phone);
    }
    public function edit(Request $request){
        $edit = new RegisterController();
        return $edit->edit($request->phone,$request->name,$request->gender,$request->major,$request->grade,$request->studentid,$request->good_at,$request->file('pic'),$request->glory_name,$request->glory_time,$request->file('glory_pic'));
    }
    public function login(Request $request){
        $login = new LoginController();
        return $login->login($request->phone,$request->password);
    }

    public function forgot(Request $request){
        $forgot = new ForgotPasswordController();
        return $forgot->forgot($request->phone, $request->password);
    }
    public function show(Request $request){
        $show = new RegisterController();
        return $show->show($request->phone);
    }

//    public function loginout(Request $request){
//        $login = new LoginController();
//        return $login->loginout();
//    }
}