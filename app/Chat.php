<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2018/1/22
 * Time: 16:53
 */

namespace App;

use App\Easemob;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function addFriend($phone,$friend_phone){
        if (isset($phone)){
            if (isset($friend_phone)){
                $options = [
                    'client_id' => 'YXA6v_G1cP6kEee68LNk5ttwmQ',
                    'client_secret' => 'YXA6Fh6SNyZBkz2KnJ0Yz9VU0SCmxJM',
                    'org_name' => '1134180121178783',
                    'app_name' => 'saiyou',
                ];
                $chat = new Easemob($options);
                $data = $chat->showFriends($phone);
                for ($i = 0;$i < sizeof($data['data']);$i ++){
                    if ($data['data'][$i] == $friend_phone){
                        return response()->json(['code'=>4,'msg'=>'该好友已存在']);
                    }
                }
                $users = $chat->getUsers();
                $boole = false;
                for ($i = 0;$i < sizeof($users['entities']);$i++){
                    if ($friend_phone == $users['entities'][$i]['username']){
                        $boole = true;
                        break;
                    }
                }
                if ($boole == true){
                    if ($chat->addFriend($phone,$friend_phone)){
                        return response()->json(['code'=>0,'msg'=>'好友添加成功']);
                    }else{
                        return response()->json(['code'=>3,'msg'=>'好友添加失败，请检查电话是否正确']);
                    }
                }else{
                    return response()->json(['code'=>5,'msg'=>'该用户不存在']);
                }
            }else{
                return response()->json(['code'=>2,'msg'=>'好友电话不存在']);
            }
        }else{
            return response()->json(['code'=>1,'msg'=>'电话不存在']);
        }
    }

    public function deleteFriend($phone,$friend_phone){
        if (isset($phone)){
            if (isset($friend_phone)){
                $options = [
                    'client_id' => 'YXA6v_G1cP6kEee68LNk5ttwmQ',
                    'client_secret' => 'YXA6Fh6SNyZBkz2KnJ0Yz9VU0SCmxJM',
                    'org_name' => '1134180121178783',
                    'app_name' => 'saiyou',
                ];
                $chat = new Easemob($options);
                $data = $chat->showFriends($phone);
                for ($i = 0;$i < sizeof($data['data']);$i ++){
                    if ($data['data'][$i] == $friend_phone){
                        if ($chat->deleteFriend($phone,$friend_phone)){
                            return response()->json(['code'=>0,'msg'=>'好友删除成功']);
                        }else{
                            return response()->json(['code'=>3,'msg'=>'好友删除失败，请检查电话是否正确']);
                        }
                        break;
                    }else{
                        return response()->json(['code'=>4,'msg'=>'该好友不存在']);
                    }
                }
            }else{
                return response()->json(['code'=>2,'msg'=>'好友电话不存在']);
            }
        }else{
            return response()->json(['code'=>1,'msg'=>'电话不存在']);
        }
    }

    public function showFriends($phone)
    {
        if (isset($phone)) {
            $options = [
                'client_id' => 'YXA6v_G1cP6kEee68LNk5ttwmQ',
                'client_secret' => 'YXA6Fh6SNyZBkz2KnJ0Yz9VU0SCmxJM',
                'org_name' => '1134180121178783',
                'app_name' => 'saiyou',
            ];
            $chat = new Easemob($options);
            $users = $chat->getUsers();
            $boole = false;
            for ($i = 0;$i < sizeof($users['entities']);$i++){
                if ($phone == $users['entities'][$i]['username']){
                    $boole = true;
                    break;
                }
            }
            if ($boole == true){
                if ($data = $chat->showFriends($phone)) {
                    return response()->json(['code' => 0, 'msg' => '好友查询成功','data' => $data['data']]);
                } else {
                    return response()->json(['code' => 3, 'msg' => '好友查询失败，请检查电话是否正确']);
                }
            }else{
                return response()->json(['code'=>5,'msg'=>'该用户不存在']);
            }
        } else {
            return response()->json(['code' => 1, 'msg' => '电话不存在']);
        }
    }
}