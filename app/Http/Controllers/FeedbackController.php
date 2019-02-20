<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/12/2
 * Time: 19:15
 */

namespace App\Http\Controllers;


use App\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function add(Request $request){
        $feedback = new Feedback();
        return $feedback->add($request->content);
    }
}