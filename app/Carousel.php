<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Carousel extends Authenticatable
{
    protected $fillable = [
        'order', 'url',
    ];
    protected $table = 'carousels';
    public function add($carousel,$order){
        $path = $carousel->storeAS(
            'carousels',uniqid().'.jpg'
        );
        $url = 'http://www.thmaoqiu.cn/poetry/storage/app/'.$path;
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
            if ($carousels->where('order',$order)->delete()){
                return response()->json(['code'=>0,'msg'=>'删除轮播图成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'删除轮播图失败']);
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