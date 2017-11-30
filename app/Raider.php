<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/11/29
 * Time: 15:39
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Raider extends Model
{
    protected $fillable = [
        'id','name','desc','pic'
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
    public function add($id,$name,$desc,$pic){
        if (!isset($id)){
            return response()->json(['code' => 2,'msg' => '攻略id不能为空']);
        }elseif (Raider::where('id',$id)->first()){
            return response()->json(['code'=>3,'msg'=>'该攻略id已存在']);
        }
        $path = $pic->storeAs('raiders',uniqid().'.jpg');
        $data = [
            'id' => $id,
            'name' => $name,
            'desc' => $desc,
            'pic' => 'http://www.thmaoqiu.cn/saiyou/storage/app/'.$path,
        ];
        $raider = new Raider();
        if ($raider->create($data)){
            return response()->json(['code' => 0,'msg'=>'添加大神攻略成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'添加大神攻略失败']);
        }
    }
    public function edit($id,$name,$desc,$pic){
        if (!isset($id)){
            return response()->json(['code' => 2,'msg' => '攻略id不能为空']);
        }
        if ( $raider = Raider::where('id',$id)->first()){
            if (isset($name)){
                $raider->name = $name;
            }
            if (isset($desc)){
                $raider->desc = $desc;
            }
            if (isset($pic)){
                $path = $pic->storeAs('raiders',uniqid().'.jpg');
                $raider->pic = 'http://www.thmaoqiu.cn/saiyou/storage/app/'.$path;
            }
            if ($raider->save()){
                return response()->json(['code' => 0,'msg'=>'修改大神攻略成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'修改大神攻略失败']);
            }
        }else{
            return response()->json(['code'=>3,'msg'=>'该攻略id不存在']);
        }
    }
    public function del($id){
        if ($raider = Raider::where('id',$id)->first()){
            if ($raider->delete()){
                return response()->json(['code'=>0,'msg'=>'删除大神攻略成功']);
            }else{
                return response()->json(['code'=>2,'msg'=>'删除大神攻略失败']);
            }

        }else{
            return response()->json(['code'=>1,'msg'=>'删除大神攻略失败,请检查攻略id是否正确']);
        }

    }
    public function show($id){
        if ($raider = Raider::where('id',$id)->first()){
            $competitiondesc = CompetitionDesc::where('id',$id)->first();
            $result['id'] = $competitiondesc->id;
            $result['desc'] = $competitiondesc->desc;
            $result['pic'] = $competitiondesc->pic;
            $result['type'] = $competitiondesc->type;
            $result['god_name'] = $raider->name;
            $result['god_desc'] = $raider->desc;
            $result['god_pic'] = $raider->pic;
            return response()->json(['code'=>0,'msg'=>'查询比赛和大神攻略成功','data'=>$result]);
        }else{
            return response()->json(['code'=>1,'msg'=>'查询比赛和大神攻略失败,请检查id是否正确']);
        }

    }

}