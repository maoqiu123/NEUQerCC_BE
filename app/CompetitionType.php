<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/25
 * Time: 16:48
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class CompetitionType extends Model
{
    protected $fillable = [
        'name', 'order'
    ];
    protected $table = 'competition_type';
    public function add($name,$order){
        $type = new CompetitionType();
        $type->name = $name;
        $type->order = $order;
        if ($type->save()){
            return response()->json(['code'=>0,'msg'=>'添加比赛类别成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'添加比赛类别失败']);
        }
    }
    public function del($order){
        $type = new CompetitionType();
        if ($type->where('order',$order)->first()){
            if ($type->where('order',$order)->delete()){
                return response()->json(['code'=>0,'msg'=>'删除比赛类别成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'删除比赛类别失败']);
            }
        }else{
            return response()->json(['code'=>2,'msg'=>'比赛类别未找到']);
        }
    }
    public function show(){
        $type = new CompetitionType();
        if ($types = $type->orderBy('order')->get()){
            for ($i = 0;$i<sizeof($types);$i++){
                $result[$i]['name'] = $types[$i]['name'];
                $result[$i]['order'] = $types[$i]['order'];
            }
            return response()->json(['code'=>0,'msg'=>'查询比赛类别成功','data'=>$result]);
        }else{
            return response()->json(['code'=>1,'msg'=>'查询比赛类别失败']);
        }
    }
}