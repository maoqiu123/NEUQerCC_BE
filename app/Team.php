<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/11/2
 * Time: 17:59
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;

class Team extends Model
{
    protected $table = "teams";
    protected $fillable = [
        'id','team_name','competition_desc','declaration','good_at','team_member','team_position',
    ];
    protected $hidden = [
        'created_at','updated_at','project_name'
    ];
    public function add($phone,$team_name,$competition_desc,$project_name,$declaration,$good_at)
    {
        $team_id = rand(1000000,9999999);
        $exit = false;
        while ($exit == false){
            if ($team = Team::where('id',$team_id)->first()){
                $team_id = rand(100000000,999999999);
            }else{
                $exit = true;
            }
        }

        if ($user = User::where('phone',$phone)->first()){
            if ($user->team_id == '' || $user->team_id == null){
                $user->team_id = $team_id;
            }else{
                $user->team_id = $user->team_id . ',' . $team_id;
            }
            $user->save();
        }else{
            return response()->json(['code'=>2,'msg'=>'此队长信息不存在']);
        }
        $data = [
            'id' => $team_id,
            'team_name' => $team_name,
            'competition_desc' => $competition_desc,
//            'project_name' => $project_name,
            'declaration' => $declaration,
            'good_at' => $good_at,
            'team_member' => $user->phone,
            'team_position' => '0'
            ];
        if (Team::create($data)){
            return response()->json(['code'=>0,'msg'=>'保存队伍信息成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'保存队伍信息失败']);
        }
    }


    public function member_add($team_id,$phone,$team_position){
        if ($team_id == ''){
            return response()->json(['code'=>3,'msg'=>'队伍id不能为空']);
        }
        if (!$team = Team::where('id',$team_id)->first()){
            return response()->json(['code'=>4,'msg'=>'找不到该队伍id']);
        }
        if (!isset($team_position)){
            $team_position = 2;
        }
        if ($user = User::where('phone',$phone)->first()){
            for ($i = 0;$i < sizeof($team_members = explode(',',$team->team_member));$i++){
                if ($team_members[$i] == $phone){
                    return response()->json(['code'=>5,'msg'=>'该用户已存在于小队中']);
                }
            }
            if ($user->team_id == '' || $user->team_id == null){
                $user->team_id = $team_id;
            }else{
                $user->team_id = $user->team_id . ',' . $team_id;
            }
            if ($team->team_member == '' || $team->team_member == null){
                $team->team_member = $user->phone;
                $team->team_position = $team_position;
            }else{
                $team->team_member = $team->team_member . ',' . $user->phone;
                $team->team_position = $team->team_position . ',' . $team_position;
            }

            if ($user->save() && $team->save()){
                return response()->json(['code'=>0,'msg'=>'添加成员成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'添加队员失败']);
            }
        }else{
            return response()->json(['code'=>2,'msg'=>'此用户信息不存在']);
        }
    }

    public function member_del($team_id,$phone){
        if ($team_id == ''){
            return response()->json(['code'=>3,'msg'=>'队伍id不能为空']);
        }
        if (!$team = Team::where('id',$team_id)->first()){
            return response()->json(['code'=>4,'msg'=>'找不到该队伍id']);
        }
        if ($user = User::where('phone',$phone)->first()){
            $team_members = explode(',',$team->team_member);
            $team_positions = explode(',',$team->team_position);
            for ($i = 0;$i < sizeof($team_members);$i++){
                if ($team_members[$i] == $phone){
                    unset($team_members[$i]);
                    unset($team_positions[$i]);
                    break;
                }
            }
            $team_ids = explode(',',$user->team_id);
            for ($i = 0;$i < sizeof($team_ids);$i++){
                if ($team_ids[$i] == $team_id){
                    unset($team_ids[$i]);
                    break;
                }
            }
            $team->team_member = implode(',',$team_members);
            $team->team_position = implode(',',$team_positions);
            $user->team_id = implode(',',$team_ids);
            if ($user->save() && $team->save()){
                return response()->json(['code'=>0,'msg'=>'删除成员成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'删除队员失败']);
            }
        }else{
            return response()->json(['code'=>2,'msg'=>'此用户信息不存在']);
        }
    }

    public function member_show($team_id){
        if ($team = Team::where('id',$team_id)->first()){
            $team_members = explode(',',$team->team_member);
            $team_positions = explode(',',$team->team_position);
            for ($i = 0;$i < sizeof($team_members);$i++){
                if ($user = User::where('phone',$team_members[$i])->first()){
                    $result[$i]['name'] = $user->name;
                    $result[$i]['namesee'] = $user->namesee;
                    $result[$i]['good_at'] = $user->good_at;
                    if ($team_positions[$i] == 0){
                        $result[$i]['team_position'] = '队长';
                    }elseif($team_positions[$i] == 1){
                        $result[$i]['team_position'] = '副队长';
                    }else{
                        $result[$i]['team_position'] = '队员';
                    }
                }else{
                    return response()->json(['code'=>1,'msg'=>"用户$team_members[$i]不存在"]);
                }
            }
            return response()->json(['code'=>0,'msg'=>'查询成员信息成功','data'=>$result]);
        }else{
            return response()->json(['code'=>2,'msg'=>'该队伍不存在']);
        }


    }


    public function edit($team_id,$team_name,$competition_desc,$project_name,$declaration,$good_at){
        if ($team_id == ''){
            return response()->json(['code'=>2,'msg'=>'队伍id不能为空']);
        }
        if (!$team = Team::where('id',$team_id)->first()){
            return response()->json(['code'=>3,'msg'=>'找不到该队伍id']);
        }
        $data = [
            'team_name' => $team_name,
            'competition_desc' => $competition_desc,
//            'project_name' => $project_name,
            'declaration' => $declaration,
            'good_at' => $good_at,
        ];
        if ($team->update($data)){
            return response()->json(['code'=>0,'msg'=>'修改队伍信息成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'修改队伍信息失败']);
        }
    }


    public function del($team_id){
        if ($team_id == ''){
            return response()->json(['code'=>2,'msg'=>'队伍id不能为空']);
        }

        if ($team = Team::where('id', $team_id)->first()) {
            $members = explode(',', $team->team_member);
            $errors = 0;
            foreach ($members as $phone) {
                if ($user = User::where('phone', $phone)->first()) {
                    $team_ids = explode(',', $user->team_id);
                    for ($i = 0; $i < sizeof($team_ids); $i++) {
                        if ($team_ids[$i] == $team_id) {
                            unset($team_ids[$i]);
                            break;
                        }
                    }
                    $user->team_id = implode(',', $team_ids);
                    $user->save();
                } else {
                    $errors = $errors + 1;
                }
            }
            if ($team->delete()){
                return response()->json(['code' => 0, 'msg' => '删除队伍成功，有'.$errors.'个用户异常']);
            }else{
                return response()->json(['code' => 1, 'msg' => '删除队伍失败']);
            }
        } else {
            return response()->json(['code' => 3, 'msg' => '找不到该队伍id']);
        }
    }


    public function show($team_id){
        if ($team_id == ''){
            return response()->json(['code'=>2,'msg'=>'队伍id不能为空']);
        }
        if ($team = Team::where('id',$team_id)->first()){
            $team_members = explode(',',$team->team_member);
            $team_positions = explode(',',$team->team_position);

                $result['id'] = $team->id;
                $result['team_name'] = $team->team_name;
                $result['competition_desc'] = $team->competition_desc;
                $result['declaration'] = $team->declaration;
                $result['good_at'] = $team->good_at;
                for ($i = 0;$i < sizeof($team_members);$i++) {
                    if ($user = User::where('phone', $team_members[$i])->first()) {
                        $result['team_member'][$i]['name'] = $user->name;
                        $result['team_member'][$i]['namesee'] = $user->namesee;
                        $result['team_member'][$i]['good_at'] = $user->good_at;
                        if ($team_positions[$i] == 0) {
                            $result['team_member'][$i]['team_position'] = '队长';
                        } elseif ($team_positions[$i] == 1) {
                            $result['team_member'][$i]['team_position'] = '副队长';
                        } else {
                            $result['team_member'][$i]['team_position'] = '队员';
                        }
                    } else {
                        return response()->json(['code' => 1, 'msg' => "用户$team_members[$i]不存在"]);
                    }
                }

            return response()->json(['code'=>0,'msg'=>'查询队伍成功','data'=>$result]);
        }else{
            return response()->json(['code'=>3,'msg'=>'找不到该队伍id']);
        }
    }


    public function teams_show($page,$size){
        if ($page == '') $page = 1;
        if ($size == '') $size = 8;
        if ($team = Team::orderBy('created_at')->skip($size * $page - $size)->take($size)->get()){
            for ($i = 0;$i < sizeof($team);$i++){
                $result[$i]['id'] = $team[$i]->id;
                $result[$i]['team_name'] = $team[$i]->team_name;
                $result[$i]['competition_desc'] = $team[$i]->competition_desc;
                $result[$i]['declaration'] = $team[$i]->declaration;
                $result[$i]['good_at'] = $team[$i]->good_at;
            }
            return response()->json(['code'=>0,'msg'=>'查询队伍成功','data'=>['totalCount' => sizeof($team),'page'=>$page,'item' => $result]]);
        }else{
            return response()->json(['code'=>1,'msg'=>'查询队伍失败']);
        }
    }


    public function recommend($competition_desc,$page,$size){
        if ($page == '') $page = 1;
        if ($size == '') $size = 8;
        if ($competition_desc == ''){
            if ($team = Team::orderBy('created_at')->skip($size * $page - $size)->take($size)->get()){
                return response()->json(['code'=>0,'msg'=>'查询队伍成功','data'=>['totalCount' => sizeof($team),'page'=>$page,'item' => $team]]);
            }else{
                return response()->json(['code'=>1,'msg'=>'查询队伍失败']);
            }
        }
        if ($team = Team::where('competition_desc', $competition_desc)->orderBy('created_at')->skip($size * $page - $size)->take($size)->get()) {
            return response()->json(['code' => 0, 'msg' => '查询队伍成功', 'data' => ['totalCount' => sizeof($team),'page'=>$page, 'item' => $team]]);
        } else {
            return response()->json(['code' => 1, 'msg' => '查询队伍失败']);
        }
    }

    public function search($content){
        $team = Team::get();
        $j = 0;
        for ($i = 0;$i < sizeof($team);$i++){
            if (str_contains($team[$i]['team_name'],$content)){
                $result[$j++] = $team[$i];
            }
        }
        if(empty($result)){
            return response()->json(['code'=>1,'msg'=>'搜索队伍失败']);
        }else{
            return response()->json(['code'=>0,'msg'=>'搜索队伍成功','data'=>$result]);
        }

    }

}