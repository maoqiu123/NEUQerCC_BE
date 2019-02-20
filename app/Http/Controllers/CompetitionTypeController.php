<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/25
 * Time: 16:56
 */

namespace App\Http\Controllers;


use App\CompetitionType;
use Illuminate\Http\Request;

class CompetitionTypeController extends Controller
{
    public function add(Request $request){
        $type = new CompetitionType();
        if ($name = $request->name){

        }else{
            return response()->json(['code'=>2,'msg'=>'请输入比赛类型']);
        }
        if ($order = $request->order){
            if ($type->where('order',$order)->first()){
                return response()->json(['code'=>4,'msg'=>'该比赛序号已存在']);
            }
            return $type->add($name,$order);
        }else{
            return response()->json(['code'=>3,'msg'=>'请输入比赛序号']);
        }
    }

    public function del(Request $request){
        $type = new CompetitionType();
        if ($order = $request->order){
            return $type->del($order);
        }else{
            return response()->json(['code'=>3,'msg'=>'请输入比赛序号']);
        }
    }

    public function show(){
        $type = new CompetitionType();
        return $type->show();
    }

}