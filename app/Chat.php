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
                if ($phone == $friend_phone){
                    return response()->json(['code'=>6,'msg'=>'不能添加自己为好友']);
                }
                $options = [
                    'client_id' => 'YXA6VdyDgPesEeej4u9_Bmthuw',
                    'client_secret' => 'YXA6nUFxy0XqHLiTu5X7FXgIH3CnAEE',
                    'org_name' => '1129180112178143',
                    'app_name' => 'neuqercc',
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
                    'client_id' => 'YXA6VdyDgPesEeej4u9_Bmthuw',
                    'client_secret' => 'YXA6nUFxy0XqHLiTu5X7FXgIH3CnAEE',
                    'org_name' => '1129180112178143',
                    'app_name' => 'neuqercc',
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
                'client_id' => 'YXA6VdyDgPesEeej4u9_Bmthuw',
                'client_secret' => 'YXA6nUFxy0XqHLiTu5X7FXgIH3CnAEE',
                'org_name' => '1129180112178143',
                'app_name' => 'neuqercc',
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
                    for ($j=0;$j<sizeof($data['data']);$j++){
                        $user = User::where('phone',$data['data'][$j])->first();
                        $result[$j]['phone'] = $data['data'][$j];
                        $result[$j]['username'] = $user->username;
                        $result[$j]['pic'] = $user->pic;
                    }

                    return response()->json(['code' => 0, 'msg' => '好友查询成功','data' => $result]);
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

    public function search($content){

        $user = new User();
        $users = $user->all();
        $j = 0;
        for ($i = 0;$i < sizeof($users);$i++){
            if (strpos($users[$i]['username'],$content) === false){

            } else {
                $data[$j]['phone'] = $users[$i]['phone'];
                $data[$j]['username'] = $users[$i]['username'];
                $data[$j]['pic'] = $users[$i]['pic'];
                $j++;
            }
        }
        if (isset($data)){
            return response()->json(['code'=>0,'msg'=>'搜索用户成功','data'=>$data]);
        }else{
            return response()->json(['code'=>1,'msg'=>'无匹配用户']);
        }

    }
    public function getChatRecord($ql){
        $options = [
            'client_id' => 'YXA6VdyDgPesEeej4u9_Bmthuw',
            'client_secret' => 'YXA6nUFxy0XqHLiTu5X7FXgIH3CnAEE',
            'org_name' => '1129180112178143',
            'app_name' => 'neuqercc',
        ];
        $chat = new Easemob($options);
        $result = $chat->getChatRecord($ql);
        return response()->json(['code'=>0,'msg'=>'查询消息记录成功','data'=>$result]);
    }
}