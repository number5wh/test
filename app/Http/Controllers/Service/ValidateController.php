<?php

namespace App\Http\Controllers\Service;

use App\Models\Phonecode;
use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Tool\SMS\SendTemplateSMS;
use App\Models\M3Result;
use Illuminate\Support\Facades\Input;

//use App\Entity\TempEmail;
//use App\Entity\Member;

class ValidateController extends Controller
{
  public function create(Request $request)
  {
    $validateCode = new ValidateCode;
    $request->session()->put('validate_code', $validateCode->getCode());
    return $validateCode->doimg();
  }

  public function sendSMS(Request $request)
  {
//      dd($input);
      $m3res = new M3Result;
//      dd($request->input('phone'));
      $phone = $request->input('phone','');
//      dd($phone);
      if(empty($phone)){
          $m3res->status = 1;
          $m3res->message = '手机号不能为空';
          return $m3res->toJson();
      }
      $charset = '1234567890';
      $code='';
      $_len = strlen($charset) - 1;
      for ($i = 0;$i < 6;++$i) {
          $code .= $charset[mt_rand(0, $_len)];
     }
      $sendSms = new SendTemplateSMS;
      $ms = $sendSms->sendTemplateSMS($phone,array($code,60),1);

      $tmp = Phonecode::where('phone',$phone)->get();
      if(count($tmp) != 0) {
          Phonecode::where('phone', $phone)->delete();
      }
          $phonecode = new Phonecode();
          $phonecode->phone = $phone;
          $phonecode->deadline = date('Y-m-d H:i:s',time()+60*10);
          $phonecode->code = $code;
          $phonecode->save();
          $m3res->message = '发送成功';
          $m3res->status = 0;

      return $m3res->toJson();
  }

//  public function validateEmail(Request $request)
//  {
//    $member_id = $request->input('member_id', '');
//    $code = $request->input('code', '');
//    if($member_id == '' || $code == '') {
//      return '验证异常';
//    }
//
//    $tempEmail = TempEmail::where('member_id', $member_id)->first();
//    if($tempEmail == null) {
//      return '验证异常';
//    }
//
//    if($tempEmail->code == $code) {
//      if(time() > strtotime($tempEmail->deadline)) {
//        return '该链接已失效';
//      }
//
//      $member = Member::find($member_id);
//      $member->active = 1;
//      $member->save();
//
//      return redirect('/login');
//    } else {
//      return '该链接已失效';
//    }
//  }
}
