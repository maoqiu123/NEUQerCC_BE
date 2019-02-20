<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Carousel extends Model
{
    protected $fillable = [
        'order', 'url',
    ];
    protected $table = 'carousels';
    private $accessKey = 'yi-qu1G_W7fSnAcH2GiLvg4BIbB0Bu2swKBXW_P8';
    private $secretKey = 'Nu1ntfUCCBkPEVQYMZfi2Pvsb0VqBefecvjlNQu2';
    public function add($carousel,$order){
        $auth = new Auth($this->accessKey, $this->secretKey);
        $bucket = 'maoqiu';
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        $key = uniqid().'.jpg';  //自动生成的文件名
        if ($uploadMgr->putFile($token,$key,$carousel)){
            $url = 'http://sy.thmaoqiu.cn/'.$key;
        }else{
            return response()->json(['code'=>5,'msg'=>'七牛云连接失败']);
        }
        $carousels = new Carousel();
        $carousels->url = $url;
        $carousels->order = $order;
        if ($carousels->save()){
            return response()->json(['code'=>0,'msg'=>"轮播图添加成功"]);
        }else{
            return response()->json(['code'=>1,'msg'=>'轮播图添加失败']);
        }
    }

    public function del($order){
        $carousels = new Carousel();
        if ($carousels->where('order',$order)->first()){

            $picNames = explode('/',$carousels->url);
            $picName = $picNames[sizeof($picNames)-1];
            $auth = new Auth($this->accessKey, $this->secretKey);
            $bucket = 'maoqiu';
            $config = new \Qiniu\Config();
            $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
            $bucketManager->delete($bucket, $picName);
            if ($carousels->where('order', $order)->delete()) {
                return response()->json(['code' => 0, 'msg' => '删除轮播图成功']);
            } else {
                return response()->json(['code' => 1, 'msg' => '删除轮播图失败']);
            }
        }else{
            return response()->json(['code'=>4,'msg'=>'轮播图未找到']);
        }
    }
    public function show(){
        $carousels = new Carousel();
        if ( $result = $carousels->orderBy('order')->take(3)->get()){

        }else{
            return response()->json(['code'=>1,'msg'=>'查询轮播图失败']);
        }
        if (sizeof($result)<=3){
            $num = sizeof($result)-1;
        }else{
            $num = 2;
        }
        for ($i=0;$i<=$num;$i++){
            $result2[$i]['order'] = $result[$i]['order'];
            $result2[$i]['url'] = $result[$i]['url'];
        }
        return response()->json(['code'=>0,'msg'=>'查询轮播图成功','data'=>$result2]);
    }

}