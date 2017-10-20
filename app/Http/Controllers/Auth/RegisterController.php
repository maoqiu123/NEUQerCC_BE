<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use SmsManager;
use \Yunpian\Sdk\YunpianClient;

class RegisterController extends Controller
{

    use RegistersUsers;

    public function register($phone, $password,$username)
    {
        $user = new User();
        if ($phone != '') {
            $data = [
                'username' => $username,
                'password' => bcrypt($password),
                'phone' => $phone,
            ];
            if ($user->where('phone', $phone)->first()) {
                return response()->json(['code' => 1, 'msg' => '手机号已存在']);
            } else if ($user->create($data)) {
                return response()->json(['code' => 0, 'msg' => '注册成功']);
            } else {
                return response()->json(['code' => -1, 'msg' => '注册失败']);
            }
        }else{
            return response()->json(['code'=>2,'msg'=>'请输入手机号']);
        }

    }

    public function sms($mobile)
    {
        $ch = curl_init();
        // 必要参数
        $apikey = "84242e501fcf74e08f4053fc3d88a7cb"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
        $captcha = rand(1000,9999);
        $text="【聚点信息科技公司】您的验证码是".$captcha;
        // 发送短信
        $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
        curl_setopt_array($ch, array(
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,));
        curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $json_data = curl_exec($ch);
        //如果curl发生错误，打印出错误
        if(curl_error($ch) != ""){
            echo 'Curl error: ' .curl_error($ch);
        }
//解析返回结果（json格式字符串）
        $array = json_decode($json_data,true);
//        echo '<pre>';print_r($array);
        $array['captcha'] = $captcha;
        return response()->json($array);

    }


}
