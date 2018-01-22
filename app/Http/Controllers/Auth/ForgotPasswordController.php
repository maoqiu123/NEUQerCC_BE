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
                'client_id' => 'YXA6v_G1cP6kEee68LNk5ttwmQ',
                'client_secret' => 'YXA6Fh6SNyZBkz2KnJ0Yz9VU0SCmxJM',
                'org_name' => '1134180121178783',
                'app_name' => 'saiyou',
            ];
            $chat = new Easemob($options);
            $chat->resetPassword($phone,$user->password);
            return response()->json(['code'=>0,'msg'=>'密码重置成功']);
        }else{
            return response()->json(['code'=>2,'msg'=>'密码重置失败']);
        }
    }
}
