<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/25
 * Time: 16:48
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class CompetitionDesc extends Model
{
    protected $fillable = [
        'name', 'desc', 'short_desc', 'registration_time','competition_time','pic','type',
    ];
    protected $table = 'competition_desc';
    public function add($name,$desc,$short_desc,$registration_time,$competition_time,$pic,$type){
        $competitiondesc = new CompetitionDesc();
        if ($time = strtotime($registration_time)){
        }else{
            $registration_time = date('Y-m-d',time());;
        }
        if ($time = strtotime($competition_time)){
        }else{
            $competition_time = date('Y-m-d',time());
        }
        if ($pic != ''){
            $path = $pic->storeAs('competitions',uniqid().'.jpg');
            $data = [
                'name' => $name,
                'desc' => $desc,
                'short_desc' => $short_desc,
                'registration_time' => $registration_time,
                'competition_time' => $competition_time,
                'pic' => 'http://www.thmaoqiu.cn/saiyou/storage/app/'.$path,
                'type' => $type,
            ];
        }else{
            $data = [
                'name' => $name,
                'desc' => $desc,
                'short_desc' => $short_desc,
                'registration_time' => $registration_time,
                'competition_time' => $competition_time,
                'type' => $type,
            ];
        }
        if ($competitiondesc->create($data)){
            return response()->json(['code'=>0,'msg'=>'创建比赛成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'创建比赛失败']);
        }
    }

    public function edit($id,$name,$desc,$short_desc,$registration_time,$competition_time,$pic,$type){
        $competitiondesc = CompetitionDesc::where('id',$id)->first();
        if ($name == ''){
            $name = $competitiondesc['name'];
        }
        if ($desc == ''){
            $desc = $competitiondesc['desc'];
        }
        if ($short_desc == ''){
            $desc = $competitiondesc['short_desc'];
        }
        if ($type == ''){
            $type = $competitiondesc['type'];
        }
        if ($registration_time == '' || !strtotime($registration_time)){
            $registration_time = $competitiondesc['registration_time'];
        }
        if ($competition_time == '' || !strtotime($competition_time)){
            $competition_time = $competitiondesc['competition_time'];
        }
        if ($pic != ''){
            $path = $pic->storeAs('competitions',uniqid().'.jpg');
            $data = [
                'name' => $name,
                'desc' => $desc,
                'short_desc' => $short_desc,
                'registration_time' => $registration_time,
                'competition_time' => $competition_time,
                'pic' => 'http://www.thmaoqiu.cn/saiyou/storage/app/'.$path,
                'type' => $type,
            ];
        }else{
            $data = [
                'name' => $name,
                'desc' => $desc,
                'short_desc' => $short_desc,
                'registration_time' => $registration_time,
                'competition_time' => $competition_time,
                'type' => $type,
            ];
        }
        if ($competitiondesc->update($data)){
            return response()->json(['code'=>0,'msg'=>'修改比赛成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'修改比赛失败']);
        }

    }

    public function del($id){
        if($competitiondesc = CompetitionDesc::where('id',$id)->first()){
            if ($competitiondesc->delete()){
                return response()->json(['code'=>0,'msg'=>'删除比赛成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'删除比赛失败']);
            }
        }else{
            return response()->json(['code'=>3,'msg'=>'该比赛id不存在']);
        }
    }

    public function show($id){
        if($competitiondesc = CompetitionDesc::where('id',$id)->first()){
            $result['id'] = $competitiondesc['id'];
            $result['name'] = $competitiondesc['name'];
            $result['desc'] = $competitiondesc['desc'];
            $result['short_desc'] = $competitiondesc['short_desc'];
            $result['registration_time'] = $competitiondesc['registration_time'];
            $result['competition_time'] = $competitiondesc['competition_time'];
            $result['pic'] = $competitiondesc['pic'];
            return response()->json(['code'=>0,'msg'=>'查询成功','data'=>$result]);
        }else{
            return response()->json(['code'=>3,'msg'=>'该比赛id不存在']);
        }
    }

}