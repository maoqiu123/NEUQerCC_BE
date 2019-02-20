<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/12/2
 * Time: 19:23
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    public function add($content){
        $feedback = new Feedback();
        $feedback->content = $content;
        if ($feedback->save()){
            return response()->json(['code'=>0,'msg'=>'已发送意见反馈']);
        }else{
            return response()->json(['code'=>1,'msg'=>'发送意见反馈失败']);
        }
    }
}