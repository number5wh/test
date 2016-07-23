<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

use App\Http\Requests;

class MemberController extends Controller
{
    public function all()
    {
        return Member::all();
    }
}
