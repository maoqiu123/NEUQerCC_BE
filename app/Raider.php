<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/11/29
 * Time: 15:39
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Raider extends Model
{
    protected $fillable = [
        'id','name','desc','pic'
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
    private $accessKey = 'yi-qu1G_W7fSnAcH2GiLvg4BIbB0Bu2swKBXW_P8';
    private $secretKey = 'Nu1ntfUCCBkPEVQYMZfi2Pvsb0VqBefecvjlNQu2';
    public function add($id,$name,$desc,$pic){
        if (!isset($id)){
            return response()->json(['code' => 2,'msg' => '攻略id不能为空']);
        }elseif (Raider::where('id',$id)->first()){
            return response()->json(['code'=>3,'msg'=>'该攻略id已存在']);
        }
        $auth = new Auth($this->accessKey, $this->secretKey);
        $bucket = 'maoqiu';
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        $key = uniqid().'.jpg';  //自动生成的文件名
        if ($uploadMgr->putFile($token,$key,$pic)){
            $data = [
                'id' => $id,
                'name' => $name,
                'desc' => $desc,
                'pic' => 'http://otq91javs.bkt.clouddn.com/'.$key,
            ];
        }else{
            return response()->json(['code'=>4,'msg'=>'七牛云连接失败']);
        }
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
                $auth = new Auth($this->accessKey, $this->secretKey);
                $bucket = 'maoqiu';
                // 生成上传Token
                $token = $auth->uploadToken($bucket);
                // 构建 UploadManager 对象
                $uploadMgr = new UploadManager();
                $key = uniqid().'.jpg';  //自动生成的文件名
                if ($uploadMgr->putFile($token,$key,$pic)){
                    $picNames = explode('/',$raider->pic);
                    $picName = $picNames[sizeof($picNames)-1];
                    $config = new \Qiniu\Config();
                    $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
                    if ($bucketManager->delete($bucket, $picName)){
                        $raider->pic = 'http://otq91javs.bkt.clouddn.com/'.$key;
                    }else{
                        return response()->json(['code'=>4,'msg'=>'七牛云连接失败']);
                    }
                }else{
                    return response()->json(['code'=>4,'msg'=>'七牛云连接失败']);
                }
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
            $picNames = explode('/',$raider->pic);
            $picName = $picNames[sizeof($picNames)-1];
            $auth = new Auth($this->accessKey, $this->secretKey);
            $bucket = 'maoqiu';
            $config = new \Qiniu\Config();
            $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
            $bucketManager->delete($bucket, $picName);
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