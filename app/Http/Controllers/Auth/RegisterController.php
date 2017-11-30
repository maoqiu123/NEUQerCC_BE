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

    public function edit($phone,$name,$gender,$major,$grade,$studentid,$good_at,$pic){
        if ($user = User::where('phone',$phone)->first()){
            $user->name = $name;
            $user->gender = $gender;
            $user->major = $major;
            $user->grade = $grade;
            $user->studentid = $studentid;
            $user->good_at = $good_at;
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
            $result['username'] = $user->username;
            $result['phone'] = $user->phone;
            $result['pic'] = $user->pic;
            $result['name'] = $user->name;
            $result['major'] = $user->major;
            $result['grade'] = $user->grade;
            $result['studentid'] = $user->studentid;
            $result['gender'] = $user->gender;
            $result['good_at'] = $user->good_at;
            return response()->json(['code'=>0,'msg'=>'查询用户资料成功','data'=>$result]);
        }else{
            return response()->json(['code'=>1,'msg'=>'查询用户资料失败']);
        }
    }

    public function glory_add($phone,$glory_name,$glory_time,$glory_pic){
        $user = User::where('phone',$phone)->first();
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
            if ($user->save()){
                return response()->json(['code'=>0,'msg'=>'添加荣誉墙成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'添加荣誉墙失败']);
            }
        }else{
            return response()->json(['code'=>2,'msg'=>'证明图片不能为空']);
        }
    }

    public function glory_edit($phone, $order, $glory_name, $glory_time, $glory_pic)
    {
        if (isset($glory_pic)){
            $user = User::where('phone', $phone)->first();
            $glory_names = explode(',', $user->glory_name);
            $glory_times = explode(',', $user->glory_time);
            $glory_pics = explode(',', $user->glory_pic);

            $glory_names[$order - 1] = $glory_name;
            $glory_times[$order - 1] = $glory_time;
            $path = $glory_pic->storeAs('glory_pics', uniqid() . '.jpg');
            $glory_pic = 'http://www.thmaoqiu.cn/saiyou/storage/app/' . $path;
            $glory_pics[$order - 1] = $glory_pic;

            $glory_names = implode(',', $glory_names);
            $glory_times = implode(',', $glory_times);
            $glory_pics = implode(',', $glory_pics);

            $user->glory_name = $glory_names;
            $user->glory_time = $glory_times;
            $user->glory_pic = $glory_pics;

            if ($user->save()){
                return response()->json(['code'=>0,'msg'=>'修改荣誉墙成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'修改荣誉墙失败']);
            }
        }else{
            $user = User::where('phone', $phone)->first();
            $glory_names = explode(',', $user->glory_name);
            $glory_times = explode(',', $user->glory_time);

            $glory_names[$order - 1] = $glory_name;
            $glory_times[$order - 1] = $glory_time;

            $glory_names = implode(',', $glory_names);
            $glory_times = implode(',', $glory_times);

            $user->glory_name = $glory_names;
            $user->glory_time = $glory_times;

            if ($user->save()){
                return response()->json(['code'=>0,'msg'=>'修改荣誉墙成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'修改荣誉墙失败']);
            }
        }
    }

    public function glory_del($phone, $order){
        if ($user = User::where('phone', $phone)->first()){
            $glory_names = explode(',', $user->glory_name);
            $glory_times = explode(',', $user->glory_time);
            $glory_pics = explode(',', $user->glory_pic);
            $orders = explode(',',$order);
            if ($order >= sizeof($glory_names)){
                return response()->json(['code'=>3,'msg'=>'该荣誉墙序号不存在']);
            }
            foreach ($orders as $order){
                unset($glory_names[$order-1]);
                unset($glory_times[$order-1]);
                unset($glory_pics[$order-1]);
            }
            $glory_names = implode(',', $glory_names);
            $glory_times = implode(',', $glory_times);
            $glory_pics = implode(',', $glory_pics);
            $user->glory_name = $glory_names;
            $user->glory_time = $glory_times;
            $user->glory_pic = $glory_pics;

            if ($user->save()){
                return response()->json(['code'=>0,'msg'=>'删除荣誉墙成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'删除荣誉墙失败']);
            }
        }else{
            return response()->json(['code'=>2,'msg'=>'找不到该用户']);
        }
    }

    public function glory_show($phone){
        if ($user = User::where('phone',$phone)->first()){
            $glory_names = explode(',', $user->glory_name);
            $glory_times = explode(',', $user->glory_time);
            $glory_pics = explode(',', $user->glory_pic);
            for ($i = 0;$i < sizeof($glory_names);$i ++){
                $result[$i]['order'] = $i;
                $result[$i]['glory_name'] = $glory_names[$i];
                $result[$i]['glory_time'] = $glory_times[$i];
                $result[$i]['glory_pic'] = $glory_pics[$i];
            }
            return response()->json(['code'=>0,'msg'=>'查询用户荣誉墙资料成功','data'=>$result]);
        }else{
            return response()->json(['code'=>1,'msg'=>'查询用户荣誉墙资料失败']);
        }
    }


}
