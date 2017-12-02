<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/12/2
 * Time: 19:52
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    protected $hidden=[
        'created_at','updated_at'
    ];
    public function year_add($content){
        $other = Other::where('name','year')->first();
        if ($other->content == '' || $other->content == null){
            $other->content = $content;
        }else{
            $other->content = $other->content . ',' . $content;
        }
        if ($other->save()){
            return response()->json(['code'=>0,'msg'=>'添加年份成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'添加年份失败']);
        }
    }
    public function year_del($order){
        if ($order != 0){
            $other = Other::where('name','year')->first();
            $contents = explode(',',$other->content);
            unset($contents[$order-1]);
            $other->content = implode(',',$contents);
            if ($other->save()){
                return response()->json(['code'=>0,'msg'=>'删除年份成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'删除年份失败']);
            }
        }else{
            return response()->json(['code'=>2,'msg'=>'该序号年份不存在']);
        }

    }
    public function year_show(){
        if ($other = Other::where('name','year')->first()){
            $contents = explode(',',$other->content);
            for ($i = 0;$i < sizeof($contents);$i ++){
                $result[$i]['order'] = $i + 1;
                $result[$i]['year'] = $contents[$i];
            }
            return response()->json(['code'=>0,'msg'=>'查找年份成功','data'=>$result]);
        }else{
            return response()->json(['code'=>1,'msg'=>'查找年份失败']);
        }
    }


    public function field_add($content){
        $other = Other::where('name','field')->first();
        if ($other->content == '' || $other->content == null){
            $other->content = $content;
        }else{
            $other->content = $other->content . ',' . $content;
        }
        if ($other->save()){
            return response()->json(['code'=>0,'msg'=>'添加领域成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'添加领域失败']);
        }
    }
    public function field_del($order){
        if ($order != 0){
            $other = Other::where('name','field')->first();
            $contents = explode(',',$other->content);
            unset($contents[$order-1]);
            $other->content = implode(',',$contents);
            if ($other->save()){
                return response()->json(['code'=>0,'msg'=>'删除领域成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'删除领域失败']);
            }
        }else{
            return response()->json(['code'=>2,'msg'=>'该序号领域不存在']);
        }

    }
    public function field_show(){
        if ($other = Other::where('name','field')->first()){
            $contents = explode(',',$other->content);
            for ($i = 0;$i < sizeof($contents);$i ++){
                $result[$i]['order'] = $i + 1;
                $result[$i]['field'] = $contents[$i];
            }
            return response()->json(['code'=>0,'msg'=>'查找领域成功','data'=>$result]);
        }else{
            return response()->json(['code'=>1,'msg'=>'查找领域失败']);
        }
    }
}