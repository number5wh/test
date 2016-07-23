<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Phonecode;
use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Http\Requests;

class MemberController extends Controller
{
    public function all()
    {
        return Member::all();
    }

    public function findByid($id){
        return Member::find($id);
    }

    public function register(Request $request)
    {
        $m3 = new M3Result();
        $email = $request->input('email','');
        $phone = $request->input('phone','');
        $password = $request->input('password','');
        $confirm = $request->input('confirm','');
        $phone_code = $request->input('phone_code','');
        $validate_code = $request->input('validate_code','');
        $pc = Phonecode::where('phone',$phone)->first();
        if($phone != null){
            if($pc->code == $phone_code){
                if(strtotime($pc->deadline)<time()){
                    $m3->status = 7;
                    $m3->message = '验证码过期';
                    return $m3->toJson();
                }
                $member = new Member();
                $member->phone = $phone;
                $member->password = md5('test' + $password);
                $member->save();
                $m3->status = 0;
                $m3->message = '注册成功';
                return $m3->toJson();
            }
        }
      else{
          $session_code = session('validate_code');
          if($session_code != $validate_code){
              $m3->status = 8;
              $m3->message = '验证码不正确';
              return $m3->toJson();
          }
          $member = new Member;
          $member->email = $email;
          $member->password = md5('test' + $password);
          $member->save();

          $m3->status = 0;
          $m3->message = '注册成功';
          return $m3->toJson();
      }


    }
}
