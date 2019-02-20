<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/11/29
 * Time: 15:36
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Raider;
use Illuminate\Http\Request;

class RaiderController extends Controller
{
    public function add(Request $request){
        $raider = new Raider();
        return $raider->add($request->id,$request->name,$request->desc,$request->file('pic'));
    }
    public function edit(Request $request){
        $raider = new Raider();
        return $raider->edit($request->id,$request->name,$request->desc,$request->file('pic'));
    }
    public function del(Request $request){
        $raider = new Raider();
        return $raider->del($request->id);
    }
    public function show(Request $request){
        $raider = new Raider();
        return $raider->show($request->id);
    }

}