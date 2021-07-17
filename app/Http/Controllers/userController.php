<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Workstation;
use App\User;
use App\Workstation_id;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    function showCreatePage()
    {
    	$workstation = Workstation::all();
        return view('user_create')->with('table',$workstation);
    }

    function submitCreatePage(Request $request)
    {
    	//
    	//dd($request->workstation);
        $this->validate($request, [
            'name' => 'required',
            'email'=> 'required',
            'password'=> 'required|min:6',
        ]);
        
        $w="";
        foreach ($request->workstation as $value) {
        	$b=explode(",", $value);
        	//dd($value);
        	//dd($b);
        	$w .=$b[1].",";
        }
       
       $a=substr($w, 0,-1);
        $file=$request->file('file');
        // dd($file);
        $filename=$file->getClientOriginalName();
        $extention=$file->getClientOriginalExtension();
        $allowedFileExtension = ['jpg','jpeg', 'png', 'JPG', 'PNG','JPEG'];
       $check=in_array($extention, $allowedFileExtension);
       if($check){
        $file->move( 'uploads/files/users',$filename);
         DB::table('users')->insert(
       
    ['name' =>$request->name,'email' => $request->email, 'password' => Hash::make($request->password), 'workstation_name' => $a,'image'=>$filename ]
);

         $last = User::orderBy('id','desc')->first();
        $user_id=$last['id'];
         foreach ($request->workstation as $id) {
         	$c=explode(",",$id);
            $names=new Workstation_id();
            $names->workstation_id=$c[0];
            $names->user_id=$user_id;
            $names->save();
        }
    }else{
        dd("no move");
    }


        return redirect('user/new')->with('done', $request->name . ' is added !');


    }

    function showAllPage()
    {


    	$table=User::where("workstation_name","!=",NULL)->get();

// $arr =  [];
// $a = [];
//     	$user = User::all();
//     	foreach ($user as $i) {
//     		      $table = DB::table('users')
//                  ->join('workstation_ids','users.id','workstation_ids.user_id')
//                  ->join('workstations','workstations.id','workstation_ids.workstation_id')
//                  ->where('users.id','=',$i->id)
//                  ->get(['workstations.name As workstation_name']);
//                  array_push($a,$i);
//                  array_push($a,$table);
//                  array_push($arr,$a);

//     	}
    	        // $table = DB::table('mergeds')
             //     ->join('users','mergeds.user_id','users.id')
             //     ->get(['users.name As user_name','mergeds.*']);

        // $table = DB::table('users')
        //          ->join('workstation_ids','users.id','workstation_ids.user_id')
        //          ->join('workstations','workstations.id','workstation_ids.workstation_id')
        //          ->get(['users.*','workstations.name As workstation_name']);
                // return $arr;
        return view('user_list')->with('table', $table);
    }


    function EditPage($id)
    {
    	// $work = Workstation::all();
        $table = User::where('id', '=', $id)->get();

        if ($table) {

            foreach ($table as $i) {

                return view( 'user_edit',array(
                    'id' => $i->id,
                    'name' => $i->name,
                    // 'pass' => $i->password,
                    'email' => $i->email,
                    'image' => $i->image,
                ));
            }
        } else {
            return "item not found";
        }
    }

    function submitUpdatePage(Request $request)
    {



        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            
        ]);
            $file=$request->file('file');

                

        if ($file != null && $request->pass != "") {
            $filename=$file->getClientOriginalName();
            $extention=$file->getClientOriginalExtension();
            $allowedFileExtension = ['jpg','jpeg', 'png', 'JPG', 'PNG','JPEG'];
            $check=in_array($extention, $allowedFileExtension);
       if($check){
            $file->move( 'uploads/files/users',$filename);

            User::where('id', $request->id)->update(array(
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->pass),
            'image'=> $filename,
        

            ));
        }

            
        }elseif($request->pass != "" && $file==null){
            User::where('id', $request->id)->update(array(
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->pass),
            // 'image'=> $filename,
        

            ));
        } elseif ($file != null && $request->pass == "") {
            $filename=$file->getClientOriginalName();
            $extention=$file->getClientOriginalExtension();
            $allowedFileExtension = ['jpg','jpeg', 'png', 'JPG', 'PNG','JPEG'];
            $check=in_array($extention, $allowedFileExtension);
       if($check){
            $file->move( 'uploads/files/users',$filename);

            User::where('id', $request->id)->update(array(
            'name'=> $request->name,
            'email'=> $request->email,
            // 'password'=> Hash::make($request->pass),
            'image'=> $filename,
        

            ));
        }

            
        }elseif($request->pass == ""  && $file==null){
            User::where('id', $request->id)->update(array(
            'name'=> $request->name,
            'email'=> $request->email,
            // 'password'=> Hash::make($request->pass),
            // 'image'=> $filename,
        

            ));
        }

        
        return redirect('/user/all')->with('done', $request->name . ' is updated !');


    }

    function destroy(Request $request)
    {


        $d=User::where('id', $request->id)->delete();

        return redirect('/user/all')->with('done', 'Selected user is deleted successfully!');


    }
}
