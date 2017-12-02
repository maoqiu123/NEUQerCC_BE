<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/12/2
 * Time: 19:49
 */

namespace App\Http\Controllers;


use App\Other;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function year_add(Request $request){
        $other = new Other();
        return $other->year_add($request->content);
    }
    public function year_del(Request $request){
        $other = new Other();
        return $other->year_del(intval($request->order));
    }
    public function year_show(){
        $other = new Other();
        return $other->year_show();
    }
    public function field_add(Request $request){
        $other = new Other();
        return $other->field_add($request->content);
    }
    public function field_del(Request $request){
        $other = new Other();
        return $other->field_del(intval($request->order));
    }
    public function field_show(){
        $other = new Other();
        return $other->field_show();
    }
}