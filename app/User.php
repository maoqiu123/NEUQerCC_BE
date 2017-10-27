<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'phone', 'password',
    ];
    protected $table = 'users';
    protected $hidden = [
        //
    ];

    public function uservalidate($username){
//        if ($username == '')return response()->json(['code'=>3,'msg'=>'姓名不能为空']);
//        if ($gender == '')return response()->json(['code'=>3,'msg'=>'性别不能为空']);
//        if ($relationship == '')return response()->json(['code'=>3,'msg'=>'与学生关系不能为空']);
//        if ($phone == '')return response()->json(['code'=>3,'msg'=>'手机号不能为空']);
//        if ($children == '')return response()->json(['code'=>3,'msg'=>'学生账号不能为空']);
//        if ($grade == '')return response()->json(['code'=>3,'msg'=>'年级不能为空']);
//        if ($class == '')return response()->json(['code'=>3,'msg'=>'班级不能为空']);
//        if ($studentid == '')return response()->json(['code'=>3,'msg'=>'学号不能为空']);
//        if ($course == '')return response()->json(['code'=>3,'msg'=>'课程不能为空']);
//        if ($jobnum == '')return response()->json(['code'=>3,'msg'=>'工号不能为空']);


    }

}