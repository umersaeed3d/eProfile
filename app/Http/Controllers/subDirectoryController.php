<?php

namespace App\Http\Controllers;
use App\Directories;
use App\SubDirectory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Names;

class subDirectoryController extends Controller
{


    function store(Request $request)
    {
        DB::Insert('Insert into sub_directories(`name`, `workstation_id`) VALUES(?,?) ',[$request->name,1]);
        return redirect('/maindirectories');
    }


    function showAll()
    {
        return Directories::where('workstation_id','=',Session::get('workstation_id'))->get();
    }


    function newForm()
    {
        $table=SubDirectory::where('workstation_id','=',Session::get('workstation_id'))->orderby('alternate_id','asc')->get();
        $dir=Directories::where('workstation_id','=',Session::get('workstation_id'))->orderby('alternate_id','asc')->get();
        return view('sub_directory_add',array(
        	'table'=>$table,'main_dir'=>$dir
        ));
    // )->with('table',$table);
    }

    function newSubmit(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
        ]);

            $t=SubDirectory::where('workstation_id','=',Session::get('workstation_id'))->orderby('id','desc')->first();
           	if ($t) {
           		$alternate_id =$t['id'];
           	}else{
           		$alternate_id=1;
           	}

            
 
           

        $table = new SubDirectory();
        $table->alternate_id = $alternate_id;
        $table->name = $request->name;
        $table->directory_id = $request->main_directory_id;
        $table->workstation_id = Session::get('workstation_id');
        $table->save();

        Directories::where('id','=',$request->main_directory_id)->update(['is_sub'=>1]);
        return redirect('/subdirectory/new')->with('done', $request->name. ' is added successfully !');
    }

    function allShow()
    {
        $table = DB::table('sub_directories')
        		->join('directories','sub_directories.directory_id','directories.id')
        		->get(['sub_directories.*','directories.name AS directory']);
        		
        return view('sub_directory_list')->with('table',$table );
    }

    function ChangeSequence(Request $request){

    	foreach ($request->id as $key=>$i) {
    		
    		SubDirectory::where('id','=',$i)->update(['alternate_id'=>$key+1]);
    	}
    	return back()->with('done','Sequence Changed');
    }

    function updateForm($id)
    {
        $table = SubDirectory::where('id', '=', $id)->first();
        // $table2=  MainDirectory::where('workstation_id','=',Session::get('workstation_id'))->get();
         return view( 'sub_directory_edit',array('id' => $table->id, 'name' => $table->name));
        

    }

    function updateSubmit(Request $request)
    {
       
        $this->validate($request, ['name' => 'required',]);
        SubDirectory::where('id', $request->id)->update(array('name'=> $request->name));
        return redirect('/subdirectory/all')->with('done', $request->name . ' is updated successfully !');

    }

    function destroy()
    {
        SubDirectory::where('id', $_GET['id'])->delete();
        $names=Names::where('sub_id','=',$_GET['id'])->get();
        foreach ($names as $key ) {
            Names::find($key->id)->delete();
        }
        return "Deleted";
    }





}
