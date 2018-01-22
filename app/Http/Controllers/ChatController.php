<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2018/1/22
 * Time: 15:37
 */

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function addFriend(Request $request){
        $chat = new Chat();
        return $chat->addFriend($request->phone,$request->friend_phone);
    }
    public function deleteFriend(Request $request){
        $chat = new Chat();
        return $chat->deleteFriend($request->phone,$request->friend_phone);
    }
    public function showFriends(Request $request){
        $chat = new Chat();
        return $chat->showFriends($request->phone);
    }

}