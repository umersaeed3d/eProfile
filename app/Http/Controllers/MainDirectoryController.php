<?php

namespace App\Http\Controllers;

use App\MainDirectory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class MainDirectoryController extends Controller
{


    function store(Request $request)
    {
        DB::Insert('Insert into main_directories(`name`, `workstation_id`) VALUES(?,?) ',[$request->name,1]);
        return redirect('/maindirectories');
    }


    function showAll()
    {
        return Directories::where('workstation_id','=',Session::get('workstation_id'))->get();
    }


    function newForm()
    {
        $table=MainDirectory::where('workstation_id','=',Session::get('workstation_id'))->orderby('alternate_id','asc')->get();
        return view('main_directory_add')->with('table',$table);
    }

    function newSubmit(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
        ]);

            $t=MainDirectory::where('workstation_id','=',Session::get('workstation_id'))->orderby('id','desc')->first();
            $alternate_id =$t['id'];
 
           

        $table = new MainDirectory();
        $table->alternate_id = $alternate_id;
        $table->name = $request->name;
        $table->workstation_id = Session::get('workstation_id');
        $table->save();
        return redirect('/maindirectory/new')->with('done', $request->name. ' is added successfully !');
    }

    function allShow()
    {
        $table = new MainDirectory();
        return view('main_directory_list')->with('table', MainDirectory::where('workstation_id','=',Session::get('workstation_id'))->orderby('alternate_id','asc')->get());
    }

    function ChangeSequence(Request $request){

    	foreach ($request->id as $key=>$i) {
    		
    		MainDirectory::where('id','=',$i)->update(['alternate_id'=>$key+1]);
    	}
    	return back()->with('done','Sequence Changed');
    }

    function updateForm($id)
    {
        $table = MainDirectory::where('id', '=', $id)->first();
        $table2=  MainDirectory::where('workstation_id','=',Session::get('workstation_id'))->get();
         return view( 'main_directory_edit',array('id' => $table->id, 'name' => $table->name,'directories'=>$table2,));
        

    }

    function updateSubmit(Request $request)
    {
       
        $this->validate($request, ['name' => 'required',]);
        MainDirectory::where('id', $request->id)->update(array('name'=> $request->name));
        return redirect('/maindirectory/all')->with('done', $request->name . ' is updated successfully !');

    }

    function destroy(Request $request)
    {
        MainDirectory::where('id', $request->id)->delete();
        return redirect('/maindirectory/all')->with('done', 'Select item is deleted successfully !');
    }





}
