<?php

namespace App\Http\Controllers;

use App\MainDirectory;
use App\Directories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class DirectoryController extends Controller
{


    function store(Request $request)
    {
        DB::Insert('Insert into directories(`name`, `workstation_id`) VALUES(?,?) ',[$request->name,1]);
        return redirect('/directories');
    }

function ChangeSequence(Request $request){

        foreach ($request->id as $key=>$i) {
            
            Directories::where('id','=',$i)->update(['alternate_id'=>$key+1]);
        }
        return back()->with('done','Sequence Changed');
    }

    function showAll()
    {
        return Directories::where('workstation_id','=',Session::get('workstation_id'))->get();
    }


    function newForm()
    {
        $table=Directories::where('workstation_id','=',Session::get('workstation_id'))->orderby('alternate_id','asc')->get();
        return view('directory_add',array(
            'table' => $table,
            // 'main_directories' => MainDirectory::where('workstation_id','=',Session::get('workstation_id'))->get()
        ));
        // ->with('table',$table);
    }

    function newSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        
            $t=Directories::where('workstation_id','=',Session::get('workstation_id'))->orderby('id','desc')->first();
            if ($t) {
                $alternate_id =$t['id'];
            }else{
                $alternate_id=1;
            }
            
       

        $table = new Directories();
        $table->alternate_id = $alternate_id;
        // $table->maindirectory_id = $request->main_directory_id;
        $table->name = $request->name;
        $table->workstation_id = Session::get('workstation_id');
        $table->save();
        return redirect('/directory/new')->with('done', $request->name. ' is added successfully !');
    }

    function allShow()
    {
        $table = new Directories();
        return view('directory_list')->with('table', Directories::where('workstation_id','=',Session::get('workstation_id'))->orderby('alternate_id','asc')->get());
    }


    function updateForm($id)
    {
        $table = Directories::where('id', '=', $id)->first();
        // $table2=  MainDirectory::where('workstation_id','=',Session::get('workstation_id'))->get();
         return view( 'directory_edit',array('id' => $table->id, 'name' => $table->name));
        

    }

    function updateSubmit(Request $request)
    {
        $this->validate($request, ['name' => 'required',]);

        
        Directories::where('id', $request->id)->update(array('name'=> $request->name));
        return redirect('/directory/all')->with('done', $request->name . ' is updated successfully !');

    }

    function destroy()
    {
        Directories::where('id', $_GET['id'])->delete();
        return "deleted";
    }





}
