<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/25
 * Time: 16:56
 */

namespace App\Http\Controllers;



use App\CompetitionDesc;
use Illuminate\Http\Request;

class CompetitionDescController extends Controller
{
    public function add(Request $request){
        $desc = new CompetitionDesc();
        return $desc->add($request->name,$request->desc,$request->short_desc,$request->registration_time,$request->competition_time,$request->file('pic'),$request->type);
    }

    public function edit(Request $request){
        $desc = new CompetitionDesc();
        if (intval($request->id) == ''){
            return response()->json(['code'=>2,'msg'=>'比赛id不能为空']);
        }
        return $desc->edit(intval($request->id),$request->name,$request->desc,$request->short_desc,$request->registration_time,$request->competition_time,$request->file('pic'),$request->type);
    }

    public function del(Request $request){
        $desc = new CompetitionDesc();
        if (intval($request->id) == ''){
            return response()->json(['code'=>2,'msg'=>'比赛id不能为空']);
        }
        return $desc->del(intval($request->id));
    }

    public function show(Request $request){
        $desc = new CompetitionDesc();
        if (intval($request->id) == ''){
            return response()->json(['code'=>2,'msg'=>'比赛id不能为空']);
        }
        return $desc->show(intval($request->id));
    }
    public function descs_show(Request $request){
        $desc = new CompetitionDesc();
        return $desc->descs_show(intval($request->page),intval($request->size));
    }
}