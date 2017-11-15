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


    public function register($phone, $password)
    {
        $user = new User();
        if ($phone != '') {
            $data = [
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
        $msg['code'] = $array['code'];
        $msg['msg'] = $array['msg'];
        $msg['data']['captcha'] = $captcha;
        return response()->json($msg);

    }

    public function edit($phone,$name,$gender,$major,$grade,$studentid,$good_at,$pic,$glory_name,$glory_time,$glory_pic){
        if ($user = User::where('phone',$phone)->first()){
            $user->name = $name;
            $user->gender = $gender;
            $user->major = $major;
            $user->grade = $grade;
            $user->studentid = $studentid;
            $user->good_at = $good_at;

            if ($glory_pic != ''){
                $path1 = $glory_pic->storeAs('glory_pics',uniqid().'.jpg');
                if ($user->glory_name != '' || $user->glory_time != '' || $user->glory_pic != ''){
                    $user->glory_name = $user->glory_name.','.$glory_name;
                    $user->glory_time = $user->glory_time.','.$glory_time;
                    $user->glory_pic = $user->glory_pic.','.'http://www.thmaoqiu.cn/saiyou/storage/app/'.$path1;
                }else{
                    $user->glory_name = $glory_name;
                    $user->glory_time = $glory_time;
                    $user->glory_pic = 'http://www.thmaoqiu.cn/saiyou/storage/app/'.$path1;
                }
            }else{
                if ($user->glory_name != '' && $user->glory_time != '' && $user->glory_pic != ''){
                    $user->glory_name = $user->glory_name.','.$glory_name;
                    $user->glory_time = $user->glory_time.','.$glory_time;
                }else{
                    $user->glory_name = $glory_name;
                    $user->glory_time = $glory_time;
                }
            }

            if ($pic != ''){
                $path2 = $pic->storeAs('pics', uniqid().'.jpg');
                $user->pic = 'http://www.thmaoqiu.cn/saiyou/storage/app/'.$path2;
            }

            if ($user->save()){
                return response()->json(['code'=>0,'msg'=>'修改用户信息成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'修改用户信息失败']);
            }

        }else{
            return response()->json(['code'=>2,'msg'=>'用户不存在']);
        }
    }

    public function show($phone){
        if ($user = User::where('phone',$phone)->first()){
            return response()->json(['code'=>0,'msg'=>'查询用户资料成功','data'=>$user]);
        }else{
            return response()->json(['code'=>1,'msg'=>'查询用户资料失败']);
        }


    }


}
