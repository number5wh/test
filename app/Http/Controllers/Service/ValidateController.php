<?php

namespace App\Http\Controllers\Service;

use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Tool\SMS\SendTemplateSMS;
//use App\Entity\TempPhone;
use App\Models\M3Result;
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
     $charset = '1234567890';
    $code='';
     $_len = strlen($charset) - 1;
     for ($i = 0;$i < 6;++$i) {
      $code .= $charset[mt_rand(0, $_len)];
    }
     $sendSms = new SendTemplateSMS;
     $sendSms->sendTemplateSMS("18649717581",array($code,60),1);
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
