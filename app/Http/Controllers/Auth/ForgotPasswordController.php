<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\User;
use App\Easemob;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest');
//    }
    public function forgot($phone,$password){
        $user = User::where('phone',$phone)->first();
        if ($password == ''){
            return response()->json(['code'=>1,'msg'=>'密码不能为空']);
        }
        if ($user->password = bcrypt($password)){
            $user->save();
            $options = [
                'client_id' => 'YXA6VdyDgPesEeej4u9_Bmthuw',
                'client_secret' => 'YXA6nUFxy0XqHLiTu5X7FXgIH3CnAEE',
                'org_name' => '1129180112178143',
                'app_name' => 'neuqercc',
            ];
            $chat = new Easemob($options);
            if ($chat->resetPassword($phone,$user->password)){
                return response()->json(['code'=>0,'msg'=>'密码重置成功']);
            }else{
                return response()->json(['code'=>3,'msg'=>'环信密码重置失败']);
            }

        }else{
            return response()->json(['code'=>2,'msg'=>'密码重置失败']);
        }
    }
}
