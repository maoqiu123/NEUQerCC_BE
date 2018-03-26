<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2018/3/25
 * Time: 20:54
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $hidden = [
        'id','created_at','updated_at'
    ];
    protected $fillable = [
        'noticeId','sendNum','recvNum','teamId','userName','teamName','type'
    ];

    public function add($sendNum,$recvNum,$teamId,$userName,$teamName,$type){
        if (!isset($recvNum)){
            $teams = new Team();
            $team = $teams->where('id', $teamId)->first();
            $teamPosition = explode(",", $team->team_position);
            $teamMember = explode(",", $team->team_member);
            for($i=0;$i<sizeof($teamPosition);$i++){
                if ($teamPosition[$i] == 1){
                    $recvNum = $teamMember[$i];
                    break;
                }
            }
        }

        $notice = new Notice();
        $notices = $notice->all();
        $boo = false;
        for ($i=0;$i<sizeof($notices);$i++){
            if ($notices[$i]['sendNum'] == $sendNum){
                if ($notices[$i]['recvNum'] == $recvNum){
                    if ($notices[$i]['teamId'] == $teamId){
                        if ($notices[$i]['type'] == $type){
                            $boo = true;
                            break;
                        }else{
                            $boo = false;
                            continue;
                        }
                    }else{
                        $boo = false;
                        continue;
                    }
                }else{
                    $boo = false;
                    continue;
                }
            }else{
                $boo = false;
                continue;
            }
        }

        if ($boo == false){
            $data = [
                'noticeId' => uniqid(),
                'sendNum' => $sendNum,
                'recvNum' => $recvNum,
                'userName' => $userName,
                'teamId' => $teamId,
                'teamName' => $teamName,
                'type' => $type
            ];
            if ($notice->create($data)){
                return response()->json(['code'=>0,'msg'=>'添加通知成功']);
            }else{
                return response()->json(['code'=>1,'msg'=>'添加通知失败']);
            }
        }else{
            return response()->json(['code'=>2,'msg'=>'请勿重复发送请求']);
        }

    }

    public function get($recvNum){
        $notice = new Notice();
        if ($notice = $notice->where('recvNum',$recvNum)->get()){
            return response()->json(['code'=>0,'msg'=>'拉取数据成功','data'=>$notice]);
        }else{
            return response()->json(['code'=>1,'msg'=>'拉取数据失败']);
        }
    }

    public function del($noticeId){
        $notice = new Notice();
        $notice = $notice->where('noticeId',$noticeId)->first();
        if($notice->delete()){
            return response()->json(['code'=>0,'msg'=>'删除通知成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'删除通知失败']);
        }
    }

}