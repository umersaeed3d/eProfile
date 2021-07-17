<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workstation;
use Session;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        //dd($user->status);
        if (auth()->user()->name == 'admin') {
            $table=Workstation::all();
            return view('workstations')->with('table',$table);
        }else{
              $table = DB::table('workstation_ids')
                 ->join('workstations','workstation_ids.workstation_id','workstations.id')
                 ->where('workstation_ids.user_id','=',auth()->user()->id)
                 ->get(['workstations.name As name','workstations.image as image','workstation_ids.*']);
                                 
            return view('workstations')->with('tables',$table);
        }
        
        
    }
    public function showDashboard($id,$name){
         Session::put('workstation_id',$id);
         Session::put('workstation_name',$name);
        return redirect('/file/directories');
    }
    
}
