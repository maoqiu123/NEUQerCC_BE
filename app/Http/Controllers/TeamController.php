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
        return $team->add($request->team_name,$request->competition_type,$request->project_name,$request->declaration,$request->good_at);
    }
    public function edit(Request $request){
        $team = new Team();
        return $team->edit(intval($request->team_id),$request->team_name,$request->competition_type,$request->project_name,$request->declaration,$request->good_at);
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
}