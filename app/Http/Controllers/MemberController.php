<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        
        $str_random = Str::random(5);
        $no_member_otomatis = 'MBR-'.$str_random;
        $members = Member::orderBy('id')->get();

        return view('member.index', [
            'title' => 'master | member',
            'members' => $members,
            'no_member_otomatis' => $no_member_otomatis
        ]);
    }

    public function addMember(Request $request)
    {
        $member = new Member();
        $member->member_code = $request->member_code;
        $member->member_name = $request->member_name;
        $member->member_address = $request->member_address;
        $member->member_phone = $request->member_phone;
        $member->save();

        return response()->json($member);
    }

    public function editMember($id)
    {
        $member = Member::find($id);
        return response()->json($member);
    }

    public function updateMember(Request $request)
    {
        $member = Member::find($request->id);
        $member->member_code = $request->member_code;
        $member->member_name = $request->member_name;
        $member->member_address = $request->member_address;
        $member->member_phone = $request->member_phone;
        $member->save();

        return response()->json($member);
    }

    public function deleteMember($id)
    {
        $member = Member::find($id);
        $member->delete();
        return response()->json(['success' => 'Member has been deleted']);
    }
}
