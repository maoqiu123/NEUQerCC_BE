<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/11/2
 * Time: 17:59
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = "teams";
    protected $fillable = [
        'id','team_name','competition_type','project_name','declaration','good_at',
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
    public function add($team_name,$competition_type,$project_name,$declaration,$good_at){

        $team = new Team();
        $id = rand(1000000,9999999);
        $exit = false;
        while ($exit == false){
            if ($team->where('id',$id)->first()){
                $id = rand(100000000,999999999);
            }else{
                $exit = true;
            }
        }
        $data = [
            'id' => $id,
            'team_name' => $team_name,
            'competition_type' => $competition_type,
            'project_name' => $project_name,
            'declaration' => $declaration,
            'good_at' => $good_at
        ];
        if (Team::create($data)){
            return response()->json(['code'=>0,'msg'=>'保存队伍信息成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'保存队伍信息失败']);
        }
    }
    public function edit($id,$team_name,$competition_type,$project_name,$declaration,$good_at){
        if ($id == ''){
            return response()->json(['code'=>2,'msg'=>'队伍id不能为空']);
        }
        if (!$team = Team::where('id',$id)->first()){
            return response()->json(['code'=>3,'msg'=>'找不到该队伍id']);
        }
        $data = [
            'team_name' => $team_name,
            'competition_type' => $competition_type,
            'project_name' => $project_name,
            'declaration' => $declaration,
            'good_at' => $good_at,
        ];
        if ($team->update($data)){
            return response()->json(['code'=>0,'msg'=>'修改队伍信息成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'修改队伍信息失败']);
        }
    }
    public function del($id){
        if ($id == ''){
            return response()->json(['code'=>2,'msg'=>'队伍id不能为空']);
        }
        if ($team = Team::where('id',$id)->first()){
            if ($team->delete()){
                return response()->json(['code'=>0,'msg'=>'删除队伍成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'删除队伍失败']);
            }
        }else{
            return response()->json(['code'=>3,'msg'=>'找不到该队伍id']);
        }
    }
    public function show($id){
        if ($id == ''){
            return response()->json(['code'=>2,'msg'=>'队伍id不能为空']);
        }
        if ($team = Team::where('id',$id)->first()){

            return response()->json(['code'=>0,'msg'=>'查询队伍成功','data'=>$team]);
        }else{
            return response()->json(['code'=>3,'msg'=>'找不到该队伍id']);
        }
    }
    public function teams_show($page,$size){
        if ($page == '') $page = 1;
        if ($size == '') $size = 8;
        if ($team = Team::orderBy('created_at')->skip($size * $page - $size)->take($size)->get()){
            return response()->json(['code'=>0,'msg'=>'查询队伍成功','data'=>['totalCount' => sizeof($team),'item' => $team]]);
        }else{
            return response()->json(['code'=>1,'msg'=>'找不到该队伍id']);
        }
    }

}