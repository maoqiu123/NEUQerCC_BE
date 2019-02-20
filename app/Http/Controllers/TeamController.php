<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/11/2
 * Time: 17:59
 */

namespace App\Http\Controllers;


use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function add(Request $request){
        $team = new Team();
        return $team->add($request->phone,$request->team_name,$request->competition_desc,$request->project_name,$request->declaration,$request->good_at);
    }
    public function edit(Request $request){
        $team = new Team();
        return $team->edit(intval($request->team_id),$request->team_name,$request->competition_desc,$request->project_name,$request->declaration,$request->good_at);
    }
    public function member_add(Request $request){
        $team = new Team();
        return $team->member_add(intval($request->team_id),$request->phone,$request->team_position);
    }
    public function member_del(Request $request){
        $team = new Team();
        return $team->member_del(intval($request->team_id),$request->phone);
    }
    public function member_show(Request $request){
        $team = new Team();
        return $team->member_show(intval($request->team_id));
    }
    public function del(Request $request){
        $team = new Team();
        return $team->del(intval($request->team_id));
    }
    public function show(Request $request){
        $team = new Team();
        return $team->show(intval($request->team_id));
    }
    public function teams_show(Request $request){
        $team = new Team();
        return $team->teams_show(intval($request->page),intval($request->size));
    }

    public function recommend(Request $request){
        $team = new Team();
        return $team->recommend($request->phone,intval($request->page),intval($request->size));
    }
    public function search(Request $request){
        $team = new Team();
        return $team->search($request->content);
    }
}