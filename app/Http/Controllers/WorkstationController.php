<?php

namespace App\Http\Controllers;

use App\Workstation;
use Illuminate\Http\Request;
use App\Vendor;
use Illuminate\Support\Facades\DB;

class WorkstationController extends Controller
{
    function showCreatePage()
    {

        return view('workstation_create');
    }

    function submitCreatePage(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'image'=> 'required'
        ]);
        $allowedFileExtension = ['jpg', 'png'];
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedFileExtension);
            if ($check)
            {
                $file->move('uploads/files/workstation/',$filename);
                
                
                
            }else
                {
                    return back()->with('done', 'Sorry Only png,jpg,doc,docx,xls,xlsx,pdf allowed!');
                }



        $table = new Workstation();
        $table->name = $request->name;
        $table->image = $filename;
        $table->save();


        return redirect('workstation/new')->with('done', $request->name . 'is added !');


    }

    function showAllPage()
    {

        $table = new Workstation();
        return view('workstation_list')->with('table', $table->all());
    }


    function EditPage($id)
    {

        $table = Workstation::where('id', '=', $id)->get();

        if ($table) {

            foreach ($table as $i) {

                return view( 'workstation_edit',array(
                    'id' => $i->id,
                    'name' => $i->name,
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
        ]);



        Workstation::where('id', $request->id)->update(array(
            'name'=> $request->name,

    ));

        return redirect('/workstation/all')->with('done', $request->name . ' is updated !');


    }

    function destroy(Request $request)
    {


        $d=Workstation::where('id', $request->id)->delete();

        return redirect('workstation/all')->with('done', 'Selected workstation is deleted successfully!');


    }


    function setting(Request $request)
    {


        Workstation::where('id', $request->id)->delete();

        return redirect('workstation.list')->with('message', $request->name . 'is deleted !');


    }





}








