<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/25
 * Time: 16:56
 */

namespace App\Http\Controllers;

use App\Carousel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function add(Request $request){
        if ($carousel = $request->file('carousel')){

        }else{
            return response()->json(['code'=>2,'msg'=>'请插入轮播图']);
        }
        if ($order = $request->order){

        }else{
            return response()->json(['code'=>3,'msg'=>'请输入序号']);
        }
        $obj = new Carousel();
        if ($obj->where('order',$order)->first()){
            return response()->json(['code'=>4,'msg'=>'该序号已存在']);
        }
        return $obj->add($carousel,$order);
    }

    public function del(Request $request){
        if ($order = $request->order){

        }else{
            return response()->json(['code'=>3,'msg'=>'请输入序号']);
        }
        $obj = new Carousel();
        return $obj->del($order);
    }
    public function show(){
        $obj = new Carousel();
        return $obj->show();
    }
}