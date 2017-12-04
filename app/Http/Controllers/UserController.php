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
        return $edit->edit($request->username,$request->phone,$request->name,$request->gender,$request->major,$request->grade,$request->studentid,$request->good_at,$request->file('pic'));
    }
    public function show(Request $request){
        $show = new RegisterController();
        return $show->show($request->phone);
    }
    public function team_list(Request $request){
        $team_list = new RegisterController();
        return $team_list->team_list($request->phone);
    }
    public function glory_add(Request $request){
        $glory = new RegisterController();
        return $glory->glory_add($request->phone,$request->glory_name,$request->glory_time,$request->file('glory_pic'));
    }
    public function glory_edit(Request $request){
        $glory = new RegisterController();
        return $glory->glory_edit($request->phone,intval($request->order),$request->glory_name,$request->glory_time,$request->file('glory_pic'));
    }
    public function glory_del(Request $request){
        $glory = new RegisterController();
        return $glory->glory_del($request->phone,intval($request->order));
    }
    public function glory_show(Request $request){
        $show = new RegisterController();
        return $show->glory_show($request->phone);
    }
    public function login(Request $request){
        $login = new LoginController();
        return $login->login($request->phone,$request->password);
    }

    public function forgot(Request $request){
        $forgot = new ForgotPasswordController();
        return $forgot->forgot($request->phone, $request->password);
    }



//    public function loginout(Request $request){
//        $login = new LoginController();
//        return $login->loginout();
//    }
}