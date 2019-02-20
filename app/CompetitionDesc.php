<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/25
 * Time: 16:48
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class CompetitionDesc extends Model
{
    protected $fillable = [
        'name', 'desc', 'short_desc', 'registration_time','competition_time','pic','type',
    ];
    protected $table = 'competition_desc';
    protected $hidden = [
        'created_at','updated_at',
    ];
    private $accessKey = 'yi-qu1G_W7fSnAcH2GiLvg4BIbB0Bu2swKBXW_P8';
    private $secretKey = 'Nu1ntfUCCBkPEVQYMZfi2Pvsb0VqBefecvjlNQu2';
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
            $auth = new Auth($this->accessKey, $this->secretKey);
            $bucket = 'maoqiu';
            // 生成上传Token
            $token = $auth->uploadToken($bucket);
            // 构建 UploadManager 对象
            $uploadMgr = new UploadManager();
            $key = uniqid().'.jpg';  //自动生成的文件名
            if ($uploadMgr->putFile($token,$key,$pic)){
                $data = [
                    'name' => $name,
                    'desc' => $desc,
                    'short_desc' => $short_desc,
                    'registration_time' => $registration_time,
                    'competition_time' => $competition_time,
                    'pic' => 'http://sy.thmaoqiu.cn/'.$key,
                    'type' => $type,
                ];
            }else{
                return response()->json(['code'=>4,'msg'=>'七牛云连接失败']);
            }
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
            $auth = new Auth($this->accessKey, $this->secretKey);
            $bucket = 'maoqiu';
            // 生成上传Token
            $token = $auth->uploadToken($bucket);
            // 构建 UploadManager 对象
            $uploadMgr = new UploadManager();
            $key = uniqid().'.jpg';  //自动生成的文件名
            if ($uploadMgr->putFile($token,$key,$pic)){
                $picNames = explode('/',$competitiondesc->pic);
                $picName = $picNames[sizeof($picNames)-1];
                $auth = new Auth($this->accessKey, $this->secretKey);
                $bucket = 'maoqiu';
                $config = new \Qiniu\Config();
                $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
                if ($bucketManager->delete($bucket, $picName)){
                    $data = [
                        'name' => $name,
                        'desc' => $desc,
                        'short_desc' => $short_desc,
                        'registration_time' => $registration_time,
                        'competition_time' => $competition_time,
                        'pic' => 'http://sy.thmaoqiu.cn/'.$key,
                        'type' => $type,
                    ];
                }else{
                    return response()->json(['code'=>4,'msg'=>'七牛云连接失败']);
                }
            }else{
                return response()->json(['code'=>4,'msg'=>'七牛云连接失败']);
            }
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
            $picNames = explode('/',$competitiondesc->pic);
            $picName = $picNames[sizeof($picNames)-1];
            $auth = new Auth($this->accessKey, $this->secretKey);
            $bucket = 'maoqiu';
            $config = new \Qiniu\Config();
            $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
            $bucketManager->delete($bucket, $picName);
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

    public function descs_show($page,$size){
        if ($page == '') $page = 1;
        if ($size == '') $size = 3;
        if ($competitiondesc = CompetitionDesc::orderBy('created_at')->skip($size * $page - $size)->take($size)->get()){
            $result = null;
            for ($i = 0;$i < sizeof($competitiondesc);$i ++){
                $result[$i]['id'] = $competitiondesc[$i]->id;
                $result[$i]['name'] = $competitiondesc[$i]->name;
                $result[$i]['short_desc'] = $competitiondesc[$i]->short_desc;
                $result[$i]['registration_time'] = $competitiondesc[$i]->registration_time;
                $result[$i]['competition_time'] = $competitiondesc[$i]->competition_time;
            }
            return response()->json(['code'=>0,'msg'=>'查询比赛成功','data'=>['totalCount' => sizeof($competitiondesc),'page' => $page,'item' => $result]]);
        }else{
            return response()->json(['code'=>1,'msg'=>'查询比赛失败']);
        }
    }

    public function search($content){
        $desc = CompetitionDesc::get();
        for ($i = 0;$i < sizeof($desc);$i++){
            if (str_contains($desc[$i]['name'],$content)){
                $result[$i] = $desc[$i];
            }
        }
        if(empty($result)){
            return response()->json(['code'=>1,'msg'=>'搜索比赛失败']);
        }else{
            return response()->json(['code'=>0,'msg'=>'搜索比赛成功','data'=>$result]);
        }
    }



}