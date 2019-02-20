<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2018/3/25
 * Time: 20:58
 */

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Http\Request;

class NoticeController
{
    public function add(Request $request){
        $notice = new Notice();
        return $notice->add($request->sendNum,$request->recvNum,$request->teamId,$request->userName,$request->teamName,$request->type);
    }
    public function get(Request $request){
        $notice = new Notice();
        return $notice->get($request->recvNum);
    }
    public function del(Request $request){
        $notice = new Notice();
        return $notice->del($request->noticeId);
    }
}