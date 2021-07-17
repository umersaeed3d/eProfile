<?php

namespace App\Http\Controllers;

use App\Banks;
use App\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    function login(Request $request)
    {

        $this->validate($request,[
            'name'=>'required',
            'password'=>'required'
        ]);


        $table = db::table('admins')
            ->where('name', 'like', $request->name)
            ->where('password', 'like', $request->password)
            ->count();

        if($table==1){


            $table = db::table('admins')
                ->where('name', 'like', $request->name)
                ->where('password', 'like', $request->password)
                ->first();

            $wid = Workstation::where('id','=',$table->workstation_id)->first();

            session(['app_kb_login_picture'=> $table->picture]);
            session(['app_kb_login_name'=> $table->name]);
            session(['app_kb_login_user_id'=> $table->id]);
            session(['app_kb_login_workstation_id'=> $table->workstation_id]);
            session(['app_kb_login_workstation_name'=> $wid->name]);



            return redirect('/');


        }else{
            Session::flush();
            return redirect('login')->with('invalid', 'Invalid login !');
        }
    }

    function logout()
    {
        Session::flush();
        return redirect('login');
    }



}








