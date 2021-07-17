<?php

namespace App\Http\Controllers;
use App\MyClass\customFPDF;
use App\User;
use App\SubDirectory;
use Mail;
use App\Merged;
use Fpdf;
use Session;
use App\Directories;
use App\Files;
use App\Names;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Directory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Ilovepdf;
use \ConvertApi\ConvertApi;

date_default_timezone_set("Asia/Karachi");
class FilesController extends Controller
{


   


     public function generateletterPDF($source, $output, $header,$footer) {




 
            $pdf = new \setasign\Fpdi\Fpdi('Portrait','mm',array(215.9,279.4));
            

            $pagecount = $pdf->setSourceFile($source);

            for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) 
            {
                $pdf->AddPage();
                $tppl = $pdf->importPage($pageNo);

                $pdf->useTemplate($tppl);
                 
                $pdf->Image($header,0,0,225,50); // X start, Y start, X width, Y width in mm
                $pdf->Image($footer,0,100,225,180); // X start, Y start, X width, Y width in mm
             
            
            } 

            $pdf->Output($output, "F");
    }
    

    public function generatePDF($source, $output, $header,$footer) {

 	
            $pdf = new \setasign\Fpdi\Fpdi('Portrait','mm',array(215.9,279.4));
            

            $pagecount = $pdf->setSourceFile($source);

            for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) 
            {
                $pdf->AddPage();
                $tppl = $pdf->importPage($pageNo);

                $pdf->useTemplate($tppl);
                 
                $pdf->Image($header,0,0,225,150); // X start, Y start, X width, Y width in mm
                $pdf->Image($footer,0,130,225,150); // X start, Y start, X width, Y width in mm
             
            
            } 

            $pdf->Output($output, "F");
    }

    
             


    public function randomString($length = 6) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    function newForm()
    {
        $directories=Directories::where('workstation_id', '=', Session::get('workstation_id'))->orderby('alternate_id','asc')->get();
        return view('file_add')->with('table',$directories );


    }

    public function newSubmit(Request $request)
    {
        
        $this->validate($request, ['directory' => 'required', 'file' => 'required',]);
        $allowedFileExtension = ['pdf', 'jpg','jpeg', 'png', 'docx', 'doc' ,'xls', 'xlsx','PDF', 'JPG', 'PNG', 'DOCX', 'DOC' ,'XLS', 'XLSX','JPEG'];
        $fil = $request->file('file');
        $j=0;
        if (count($request->check)==count($fil)) {
            $files=$fil;
        }else{
            $files=$request->check;
        }
        // dd($files);

        foreach ($request->check as $file) 
        {
            $filename = $file;
            $extension = explode(".",$file);

            $check = in_array($extension[1], $allowedFileExtension);
            
            // dd($extension[1]);

            
            if ($check)
            {
                foreach ($fil as $f) {
                    if ($f->getClientOriginalName()==$file) {
                        
                        $f->move('uploads/files/',$filename); 
                    }
                }   
                

                if ($extension[1]=='pdf' || $extension[1]=='pdf') 
                {
                     $this->generatePDF("uploads/files/".$filename, "uploads/files/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    $this->generateletterPDF("uploads/files/".$filename, "uploads/files/".$filename."_letter.pdf","uploads/files/letter_header.png","uploads/files/letter_footer.png");
                }
                if ($extension[1]=='jpg' || $extension[1]=='png' || $extension[1]=='JPG' || $extension[1]=='PNG' || $extension[1]=='jpeg' || $extension[1]=='JPEG') 
                {
                    //instance of FPDF
                    $fpdf=new \App\MyClass\customFPDF;
                    $fpdf->AddPage("P");
                    $fpdf->centreImage('uploads/files/'.$filename);
                    // $fpdf->Image('uploads/files/'.$filename);
                    $fpdf->Output('F','uploads/files/'.$filename.'.pdf');

                     $this->generatePDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    $this->generateletterPDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_letter.pdf","uploads/files/letter_header.png","uploads/files/letter_footer.png");
            
                }
                 if ($extension[1]=='doc' || $extension[1]=='DOC')
                 
                {
                    return back()->with('done','Sorry doc is not available right now,please convert it to docx then uplaod');
                    // $PHPWord = new \PhpOffice\PhpWord\PHPWord();

                    // $document =  \PhpOffice\PhpWord\IOFactory::load('uploads/files/'.$filename);

                    // // Save File

                    // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007');

                    // $objWriter->save('uploads/files/'.$extension[1].'.docx');
                    // exit();
                        
                    // $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    // $document = $phpWord->loadTemplate('uploads/files/'.$extension[1].'.docx');
                    // $document->saveAs('uploads/files/temp'.$j.'.docx');

                    // \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    // \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    // //Load temp file
                    // $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/temp'.$j.'.docx'); 

                    // //Save it
                    // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
                    // $xmlWriter->save('uploads/files/'.$filename.'.pdf');  

                    // $this->generatePDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    // $this->generateletterPDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_letter.pdf","uploads/files/letter_header.png","uploads/files/letter_footer.png");
                }
                if ($extension[1]=='docx' || $extension[1]=='DOCX')
                {
                        
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $document = $phpWord->loadTemplate('uploads/files/'.$filename);
                    $document->saveAs('uploads/files/temp'.$j.'.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/temp'.$j.'.docx'); 

                    //Save it
                    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
                    $xmlWriter->save('uploads/files/'.$filename.'.pdf');  

                    $this->generatePDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    $this->generateletterPDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_letter.pdf","uploads/files/letter_header.png","uploads/files/letter_footer.png");
                }
                elseif ($extension[1]=='xls' || $extension[1]=='xlsx' || $extension[1]=='XLS' || $extension[1]=='XLSX') 
                {
                
                
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
                    $spreadsheet = $reader->load('uploads/files/'.$filename); 
                    $ws = $spreadsheet->getActiveSheet(); 
                    $ws->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                    $ws->getPageSetup()->setFitToWidth(1);
                    $ws->getPageSetup()->setFitToHeight(1);
                    $ws->setShowGridlines(false);
                    
                    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Dompdf');

                        
                    $writer->save('uploads/files/'.$filename.'.pdf');

                     $this->generatePDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    $this->generateletterPDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_letter.pdf","uploads/files/letter_header.png","uploads/files/letter_footer.png");
                   
                    
                }
                
            }else
                {
                    return redirect('/file/new')->with('done', 'Sorry Only png,jpg,doc,docx,xls,xlsx,pdf allowed!');
                }
            $data[]=$filename;
            $j++;
        }
     
        $table = new Files();
        $table->user_id=auth()->user()->id;
        $table->name = json_encode($data);      
        $table->directories_id = $request->directory;
        if ($request->sub_directory != null) {
            $table->sub_id=$request->sub_directory;
        }
        // $table->move_id = $request->sub_directory;
        $table->main_id = $request->directory;
        $table->workstation_id = Session::get('workstation_id');
        $table->save(); 

        $last = Files::orderBy('id','desc')->first();
        $id=$last['id'];
          

       
        foreach ($data as $name) {
            $names=new Names();
            $names->files_id=$id;
            $names->user_id=auth()->user()->id;
            $names->directory_id = $request->directory;
            $names->main_id = $request->directory;
            if ($request->sub_directory != null) {
            $names->sub_id=$request->sub_directory;
        }
            $names->names=$name;
            $names->save();
        }
        
     
        

        return redirect('/file/new')->with('done', 'files are added successfully !');

    }

    function allShow()
    {
        $directories=Directories::where('workstation_id','=',Session::get('workstation_id'))->orderby('alternate_id','asc')->get();
       
        return view('all_files')->with('table',$directories );

    }

    function MoveFileForm(Request $req)
    {

       foreach ($req->checked as $i) {
           $table=Names::where('id','=',$i)->first();

            $file = new Files();
          $file->name=$this->randomString();
          $file->directories_id=$req->directory;
          $file->main_id=$req->directory;
          $file->user_id=$table->user_id;
          // $file->user_id=$table->user_id;
         // $file->move_id=$table->directory_id;
          $file->workstation_id=Session::get('workstation_id');
          $file->save();
          $last=Files::orderby('id','desc')->first();
           $copy=new Names();
           $copy->names=$table->names;
           $copy->files_id=$last->id;
           $copy->user_id=$table->user_id;
           $copy->status=$table->status;
           $copy->title=$table->title;
           $copy->directory_id=$req->directory;
           $copy->main_id=$req->directory;
           $copy->save();

           Names::find($i)->delete();
       }
       return back()->with('success','Files Moved Successfully');
       

    }
    function CopyFileForm(Request $req)
    {
       foreach ($req->check as $i) {
           $table=Names::where('id','=',$i)->first();

            $file = new Files();
          $file->name=$this->randomString();
          $file->directories_id=$req->directory;
          $file->main_id=$req->directory;
          $file->user_id=$table->user_id;
         // $file->move_id=$table->directory_id;
          $file->workstation_id=Session::get('workstation_id');
          $file->save();
          $last=Files::orderby('id','desc')->first();
           $copy=new Names();
           $copy->names=$table->names;
           $copy->files_id=$last->id;
           $copy->user_id=$table->user_id;
           $copy->status=$table->status;
           $copy->title=$table->title;
           $copy->directory_id=$req->directory;
           $copy->main_id=$req->directory;
           $copy->save();

         

           
       }
       return back()->with('success','Files Copies Successfully');
       

    }

     function allShowFiles()
    {
        $directories=Directories::where('workstation_id','=',Session::get('workstation_id'))->orderby('alternate_id','asc')->get();
        return view('files')->with('table',$directories );

    }
    function byArchive(){
        $directories=Directories::where('workstation_id','=',Session::get('workstation_id'))->orderby('alternate_id','asc')->get();
        return view('archive_files')->with('table',$directories );
    }

    function byYears($id)
    {

        return view('by_years')->with('table', Files::select('year')->distinct()->where('directory_id','=',$id)->get());

    }

    function byFile($d)
    {
        $file=Directories::where('workstation_id','=',1)->find($d);
        return view('by_files')->with('getfiles',$file->files );

    }

    function archiveBack()
    {
         DB::table('names')
        ->where('id', $_GET['id'])  
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array('status' => 0));

        
        return "BACK";
    }

    function delete()
    {
        Names::find($_GET['id'])->delete();
        return "DELETED";
    }

     function archiveBackdir()
    {
         DB::table('directories')
        ->where('id', $_GET['id'])  
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array('is_archive' => 0));

        
        return "BACK";
    }

    function deletedir()
    {
        Directories::find($_GET['id'])->delete();
        return "DELETED";
    }

    function archive()
    {
        
       // $file=Names::find($id);
        //$d=json_decode($file->name);
        

        // foreach ($d as $key=>$n) {
        //     $da=explode('.', $n);
        //     if ($da[0]==$name) {
        //         unset($d[$key]);

        //     }
        // }
        // sort($d);
        // $updated=json_encode($d);
        $id=$_GET['id'];
        DB::table('names')
        ->where('id', $id)  
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array('status' => 1));

        
        return "Done";
    }
    function archivefromDir()
    {
        
       // $file=Names::find($id);
        //$d=json_decode($file->name);
        

        // foreach ($d as $key=>$n) {
        //     $da=explode('.', $n);
        //     if ($da[0]==$name) {
        //         unset($d[$key]);

        //     }
        // }
        // sort($d);
        // $updated=json_encode($d);
        $id=$_GET['id'];
        DB::table('directories')
        ->where('id', $id)  
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array('is_archive' => 1));

        
        return "Done";
    }
     function updateFile(Request $request)
    {
         $this->validate($request, ['ff' => 'required', 'file' => 'required',]);
        $allowedFileExtension = ['pdf', 'jpg', 'png', 'docx','xls','xlsx'];
        // $ff=explode(",", $request->ff);
        // $id=$ff[1];
        // $name=$ff[0];
        $id=$request->ff;
        $file=$request->file('file');
        $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedFileExtension);
            if ($check)
            {
                $file->move('uploads/files/',$filename);
                
                
                
            }else
                {
                    return redirect('/file/new')->with('done', 'Sorry Only png , jpg , doc,docx,xls,xlsx allowed!');
                }
        
        //$fff=Files::find($id);


        //$d=json_decode($fff->name);
        
        // foreach ($d as $k=>$n) {
        //     if ($n==$name) {
        //         unset($d[$k]);
               

        //     }
        // }
        //  sort($d);
        
        // array_push($d, $filename);
        

        
        
       // $updated=json_encode($d);

        DB::table('names')
        ->where('id', $id)  
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array('names' => $filename));

        
        return back()->with('done','File has been updated successfully');
    }
    function getdownload($d)
    {
        $file = "uploads/files/".$d;
        // $file="../uploads/files/".$d;
        return response()->download($file,basename($file));
    }
    function getmergedownload($d)
    {
        $file = "uploads/files/merged/".$d;
        // $file="../uploads/files/".$d;
        return response()->download($file,basename($file));
    }
    function updateShow()
    {
        $directories=Directories::where('workstation_id', '=', Session::get('workstation_id'))->get();

        return view('file_update')->with('directories',$directories);

        // ->with('table',$directories );
    }
    public function filesAjax(){
        $check_dir=array();
        $exit=true;
        $color="light-grey";
        $html=array();
        $su=array();
        $id=$_GET['id'];
        $file=Directories::where('workstation_id','=',Session::get('workstation_id'))->find($id);
        // dd($file->is_sub);
        foreach ($file->files as $f) {

            $name = Files::find($f->id);
            //$name=json_decode($f->name);
            $c=null;
            foreach ($name->names as $n) {

                //$na=explode('.', $n->names);
                $e=explode(".", $n->names);
                $name=$e[0];
                $ex=$e[1];
                if($n->status==0){
                    if ($n->title==NULL) {
                        $title="None";
                    }else{
                        $title=$n->title;
                    }
                    
                 if(count($html) % 2 == 0){ 
                        $c = "white !important";  
                    } 
                    else{ 
                        $c= "lightgrey !important"; 
                    } 
                    if ($f->sub_id==0) {
                        
                          array_push($html,
                        

                        '<li class="uk-nestable-item"><div class="uk-nestable-panel" style="background-color:'.$c.';">
                                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                        
                        <input class="uk-checkbox" type="checkbox" onclick="func()" name="check[]" value="'.$n->names.'" >



                        <a href="/download/'.$n->names.'" title="Click here to downlaod">'.$n->names.'</a>
                        <span style="margin-left:5%;color:grey;">Title: '.$title.'</span>
                       
                        <button type="button" class="uk-button-danger" onclick="archive('.$n->id.',$(this))" class="uk-float-right uk-button-danger" style="float:right">Archive</button>                        
                        </div></li>');
                         
                    }else{
                        // dd(in_array($f->sub_id,$check_dir));
                        if (in_array($f->sub_id,$check_dir)==false) {
                                 $sub=SubDirectory::where('id','=',$f->sub_id)->first();

                         array_push($su,

                        ' 
                        
                            
                        <li class="uk-nestable-item uk-parent uk-collapsed" >
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" id="collapsed" data-nestable-action="toggle" onclick="sendsubid('.$sub->id.',$(this))"></div>
                                    '.$sub->name.'    
                            </div>
                            <ul class="sub'.$sub->id.'" style="list-style-type:none" id="'.$sub->id.'">
                                
                            </ul>
                        </li>
                        
                        
                    ');
                        }
                       
                         array_push($check_dir, $f->sub_id);
                          
                    }

                    
                  
                }
                             }

        }
        foreach ($su as $key) {
             array_push($html, $key);
        }
       
        

        return $html;
    }
 public function directoriesAjaxAll(){
        $color="light-grey";
        $html=array();
        $id=$_GET['id'];
        $file=Directories::where('workstation_id','=',Session::get('workstation_id'))->where('maindirectory_id','=',$id)->where('is_archive','=',0)->get();

        // return $file;
            //$name=json_decode($f->name);
            $c=null;
            foreach ($file as $n) {
                 $user_id=User::where('id','=',$n->user_id)->first();
                    $count=Names::where('directory_id','=',$n->id)->where('status','=',0)->get()->count();
                //$na=explode('.', $n->names);
                
                    if($n->is_file != 1){
                    array_push($html,

                        ' 
                        
                            
                        <li class="uk-nestable-item uk-parent uk-collapsed">
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" data-nestable-action="toggle" onclick="sendid('.$n->id.')"></div>
                                    '.$n->name.'<span style="float:right">Files: '.$count.'</span>    
                            </div>
                            <ul class="'.$n->id.'" style="list-style-type:none">
                                
                            </ul>
                        </li>
                        
                        
                    ');
                    }else{
                         array_push($html,

                        '<li class="uk-nestable-item"><div class="uk-nestable-panel" >
                                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                        
                        



                        <a href="/download/'.$n->name.'" title="Click here to downlaod">'.$n->name.'</a>
                         <span style="margin-left:5%;color:grey;">Uploaded By: '.$user_id->name.'</span>
                        <span style="margin-left:5%;color:grey;">Uploaded At: '.$n->created_at.'</span>
                        
                       
                                                
                        </div></li>');
                    }
                }
                             

        
        return $html;
    }
    public function subFilesAjax(){

        $color="light-grey";
        $html=array();
        $id=$_GET['id'];
        $file=Names::where('sub_id','=',$id)->where('status','=',0)->get();

        // return $file;
            //$name=json_decode($f->name);
            
            foreach ($file as $n) {
                    
                
                   
                         array_push($html,

                        '<li class="uk-nestable-item"><div class="uk-nestable-panel" >
                                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                        
                        <input class="uk-checkbox" type="checkbox" onclick="func()" name="check[]" value="'.$n->names.'" >



                        <a href="/download/'.$n->names.'" title="Click here to downlaod">'.$n->names.'</a>
                        
                       
                        <button type="button" class="uk-button-danger" onclick="archive('.$n->id.',$(this))" class="uk-float-right uk-button-danger" style="float:right">Archive</button>                        
                        </div></li>');
                    
                }
                             

        
        return $html;
    }

    public function subFilesAjaxAll(){

        $color="light-grey";
        $html=array();
        $id=$_GET['id'];
        $file=Names::where('sub_id','=',$id)->where('status','=',0)->get();

        // return $file;
            //$name=json_decode($f->name);
            
            foreach ($file as $n) {
                    
                 $user_id=User::where('id','=',$n->user_id)->first();
                   
                         array_push($html,

                        '<li class="uk-nestable-item"><div class="uk-nestable-panel" style="background-color:white;">
                                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                        
                        


                        
                        <a href="/download/'.$n->names.'" title="Click here to downlaod">'.$n->names.'</a>
                        <span style="margin-left:5%;color:grey;">Uploaded By: '.$user_id->name.'</span>
                        <span style="margin-left:5%;color:grey;">Uploaded At: '.$n->created_at.'</span>
                        
                       
                                                
                        </div></li>');
                    
                }
                             

        
        return $html;
    }

     public function subFilesAjaxArchive(){

        $color="light-grey";
        $html=array();
        $id=$_GET['id'];
        $file=Names::where('sub_id','=',$id)->where('status','=',1)->get();

        // return $file;
            //$name=json_decode($f->name);
            
            foreach ($file as $n) {
                    
                
                   
                          array_push($html,
                        '<li class="uk-nestable-item"><div class="uk-nestable-panel">
                                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                        
                        <a href="/download/'.$n->names.'" title="Click here to downlaod">'.$n->names.'</a>
                        <button onclick="moveback('.$n->id.',$(this))" class="uk-button-success uk-float-right">Move Back</button> 
                         <button onclick="per('.$n->id.',$(this))" class="uk-button-danger uk-float-right">Permenantly Delete</button> 

                        </div></li>');
                    
                }
                             

        
        return $html;
    }

        public function directoriesAjaxArchive(){
        $color="light-grey";
        $html=array();
        $id=$_GET['id'];
        $file=Directories::where('workstation_id','=',Session::get('workstation_id'))->where('maindirectory_id','=',$id)->get();

        // return $file;
            //$name=json_decode($f->name);
            $c=null;
            foreach ($file as $n) {
                    $count=Names::where('directory_id','=',$n->id)->where('status','=',0)->get()->count();
                //$na=explode('.', $n->names);
                
                    if($n->is_file != 1){
                    array_push($html,

                        ' 
                        
                            
                        <li class="uk-nestable-item uk-parent uk-collapsed">
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" data-nestable-action="toggle" onclick="sendid('.$n->id.')"></div>
                                    '.$n->name.'<span style="float:right">Files: '.$count.'</span>    
                            </div>
                            <ul class="'.$n->id.'" style="list-style-type:none">
                                
                            </ul>
                        </li>
                        
                        
                    ');
                    }else{
                        if ($n->is_archive==1) {
                             array_push($html,
                        '<li class="uk-nestable-item"><div class="uk-nestable-panel">
                                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                        
                        <a href="/download/'.$n->name.'" title="Click here to downlaod">'.$n->name.'</a>
                        <button onclick="movebackdir('.$n->id.',$(this))" class="uk-button-success uk-float-right">Move Back</button> 
                         <button onclick="perdir('.$n->id.',$(this))" class="uk-button-danger uk-float-right">Permenantly Delete</button> 

                        </div></li>');
                        }
                       
                    }
                }
                             

        
        return $html;
    }

 public function GetSubDirectories(){
        
        $html=array();
        $id=$_GET['id'];
        $file=SubDirectory::where('workstation_id','=',Session::get('workstation_id'))->where('directory_id','=',$id)->get();

        
            foreach ($file as $n) {

                //$na=explode('.', $n->names);
                

                    array_push($html,'<option value="'.$n->id.'">'.$n->name.'</option>');
                }
                             

        
        return $html;
    }

public function allFiles(){
    // $f=Files::where('workstation_id','=',Session::get('workstation_id'))->get();

    // foreach ($f as $key ) {
    //     $n=Files::find($key->id);
    //     foreach ($n->names as $k) {
            
    //         Names::where('id','=',$k->id)->update(['directory_id'=>$key->directories_id]);
    //     }
    // }
   // exit();
    $check_dir=array();
        $exit=true;
        $su=array();
        $color="light-grey";
        $html=array();
        $id=$_GET['id'];
        $file=Directories::where('workstation_id','=',Session::get('workstation_id'))->find($id);

        foreach ($file->files as $f) {
                
            $name = Files::find($f->id);

            //$name=json_decode($f->name);
            $c=null;
            foreach ($name->names as $n) {
                // dd($n->directory_id.",".$f->move_id);
               
                    

                
                $user_id=User::where('id','=',$n->user_id)->first();
                

                //$na=explode('.', $n->names);
                $e=explode(".", $n->names);
                $name=$e[0];
                $ex=$e[1];
                if($n->status==0){
                    if ($n->title==NULL) {
                        $title="None";
                    }else{
                        $title=$n->title;
                    }
                    
                 if(count($html) % 2 == 0){ 
                        $c = "white !important";  
                    } 
                    else{ 
                        $c= "lightgrey !important"; 
                    } 
                    
                    if ($f->sub_id==0) {
                        
                                             array_push($html,

                        '<li class="uk-nestable-item"><div class="uk-nestable-panel" style="background-color:'.$c.';">
                                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                        
                        


                        <input type="checkbox" name="check[]" value="'.$n->id.'" onclick="func()">
                        <a href="/download/'.$n->names.'" title="Click here to downlaod">'.$n->names.'</a>
                        <span style="margin-left:5%;color:grey;">Uploaded By: '.$user_id->name.'</span>
                        <span style="margin-left:5%;color:grey;">Uploaded At: '.$n->created_at.'</span>
                        
                       
                                                
                        </div></li>');
                         
                    }else{
                         if (in_array($f->sub_id,$check_dir)==false) {
                                 $sub=SubDirectory::where('id','=',$f->sub_id)->first();

                         array_push($su,

                        ' 
                        
                            
                        <li class="uk-nestable-item uk-parent uk-collapsed" >
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" id="collapsed" data-nestable-action="toggle" onclick="sendsubid('.$sub->id.',$(this))"></div>
                                    '.$sub->name.'    
                            </div>
                            <ul class="sub'.$sub->id.'" style="list-style-type:none" id="'.$sub->id.'">
                                
                            </ul>
                        </li>
                        
                        
                    ');
                        }
                       
                         array_push($check_dir, $f->sub_id);
                          
                    }
                    }

                
            }
          }//foreach

        
         foreach ($su as $key) {
             array_push($html, $key);
        }
        return $html;
    }


     public function archivefilesAjax(){
        $check_dir=array();
        $exit=true;
        $su=array();
        $html=array();
        $id=$_GET['id'];
        $file=Directories::where('workstation_id','=',Session::get('workstation_id'))->find($id);
        // dd($id);
        foreach ($file->files as $f) {

            $name = Files::find($f->id);
            //$name=json_decode($f->name);
            foreach ($name->names as $n) {
                
                //$na=explode('.', $n->names);

                if($n->status==1){
                    
                     if ($f->sub_id==0) {
                          array_push($html,
                        '<li class="uk-nestable-item"><div class="uk-nestable-panel">
                                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                        
                        <a href="/download/'.$n->names.'" title="Click here to downlaod">'.$n->names.'</a>
                        <button onclick="moveback('.$n->id.',$(this))" class="uk-button-success uk-float-right">Move Back</button> 
                         <button onclick="per('.$n->id.',$(this))" class="uk-button-danger uk-float-right">Permenantly Delete</button> 

                        </div></li>');
                    }else{
                         if (in_array($f->sub_id,$check_dir)==false) {
                                 $sub=SubDirectory::where('id','=',$f->sub_id)->first();

                         array_push($su,

                        ' 
                        
                            
                        <li class="uk-nestable-item uk-parent uk-collapsed" >
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" id="collapsed" data-nestable-action="toggle" onclick="sendsubid('.$sub->id.',$(this))"></div>
                                    '.$sub->name.'    
                            </div>
                            <ul class="sub'.$sub->id.'" style="list-style-type:none" id="'.$sub->id.'">
                                
                            </ul>
                        </li>
                        
                        
                    ');
                        }
                       
                         array_push($check_dir, $f->sub_id);
                          
                    }
                    }
                    
                   
                }
            }

        
         foreach ($su as $key) {
             array_push($html, $key);
        }
        return $html;
    }


       public function filesUpdateAjax(){
        $html=array();
        $id=$_GET['id'];
        $file=Directories::where('workstation_id','=',Session::get('workstation_id'))->find($id);
        foreach ($file->files as $f) {
             $name = Files::find($f->id);
            foreach ($name->names as $n) {
                
                array_push($html,
                    '<option value="'.$n->id.'" >'.$n->names.'</option>');
            }

        }
        return $html;
    }
    public function mergeFiles(Request $request){
        // dd($request->ff);
       
        
      $desk_file=$request->file('upload');
      if ($desk_file!=null) {
        $z=1;
          foreach ($desk_file as $file) {
            $filename=$file->getClientOriginalName();
            $extension=$file->getClientOriginalExtension();
             $file->move('uploads/files/',$filename); 
              if ($extension=='pdf' || $extension=='pdf') 
                {
                     $this->generatePDF("uploads/files/".$filename, "uploads/files/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    $this->generateletterPDF("uploads/files/".$filename, "uploads/files/".$filename."_letter.pdf","uploads/files/letter_header.png","uploads/files/letter_footer.png");
                }
                if ($extension=='jpg' || $extension[1]=='png' || $extension[1]=='JPG' || $extension[1]=='PNG' || $extension[1]=='jpeg' || $extension[1]=='JPEG') 
                {
                    //instance of FPDF
                    // $fpdf=new \Crabbly\FPDF\FPDF;
                    // $fpdf->AddPage();
                    // $fpdf->Image('uploads/files/'.$filename);
                    // $fpdf->Output('F','uploads/files/'.$filename.'.pdf');
                    
                     $fpdf=new \App\MyClass\customFPDF;
                    $fpdf->AddPage("P");
                    $fpdf->centreImage('uploads/files/'.$filename);
                    // $fpdf->Image('uploads/files/'.$filename);
                    $fpdf->Output('F','uploads/files/'.$filename.'.pdf');

                     $this->generatePDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    $this->generateletterPDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_letter.pdf","uploads/files/letter_header.png","uploads/files/letter_footer.png");
            
                }
                 if ($extension=='doc' || $extension=='DOC')
                 
                {
                    return back()->with('done','Sorry doc is not available right now,please convert it to docx then uplaod');
                   
                }
                if ($extension=='docx' || $extension=='DOCX')
                {
                        
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $document = $phpWord->loadTemplate('uploads/files/'.$filename);
                    $document->saveAs('uploads/files/temp'.$z.'.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/temp'.$z.'.docx'); 

                    //Save it
                    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
                    $xmlWriter->save('uploads/files/'.$filename.'.pdf');  

                    $this->generatePDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    $this->generateletterPDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_letter.pdf","uploads/files/letter_header.png","uploads/files/letter_footer.png");
                }
                elseif ($extension=='xls' || $extension=='xlsx' || $extension=='XLS' || $extension=='XLSX') 
                {
                
                
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
                    $spreadsheet = $reader->load('uploads/files/'.$filename); 
                    $ws = $spreadsheet->getActiveSheet(); 
                    $ws->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                    $ws->getPageSetup()->setFitToWidth(1);
                    $ws->getPageSetup()->setFitToHeight(1);
                    $ws->setShowGridlines(false);
                    
                    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Dompdf');

                        
                    $writer->save('uploads/files/'.$filename.'.pdf');

                     $this->generatePDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    $this->generateletterPDF("uploads/files/".$filename.".pdf", "uploads/files/".$filename."_letter.pdf","uploads/files/letter_header.png","uploads/files/letter_footer.png");
                   
                    
                }
                
           $z++;
          }
      }
        

        $exit=false;
        $sr_no=$this->randomString();
        //getting files name from request 
        $files=$request->ssf;
        
        $filename=$request->filename;
        $sh=array();
        //$time=time();         
        //instance of PDFMERGER
        $pdf = new \Jurosh\PDFMerge\PDFMerger;
        $TOC = new \Jurosh\PDFMerge\PDFMerger;
        $PDF = new \Jurosh\PDFMerge\PDFMerger;
        $P = new \Jurosh\PDFMerge\PDFMerger;
        $W = new \Jurosh\PDFMerge\PDFMerger;
        $L = new \Jurosh\PDFMerge\PDFMerger;


        //instance of FPDF
        // $fpdf=new \Crabbly\FPDF\FPDF;
        // $fpdf->AddPage();
        //$fpdf->SetFont('Arial','',10);
        //$fpdf->Cell(0,0,'Title',0,1,'C');

        //instance of PHPWORD


        
             if ($request->zz != null || $request->ff != null) 
             {
            $k=1;
             $phpWord = new \PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection();
$header = array('size' => 18, 'bold' => true);
// 1. Basic table
 $section->addTextBreak();
 $section->addTextBreak();
 $section->addTextBreak();
 $section->addTextBreak();
$section->addText(htmlspecialchars('CONTENTS'), $header,array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));
 $section->addTextBreak();
$table = $section->addTable();
$pagebreak=true;
if ($request->format_toc=='1') {
    $o=1;
    for ($r = 0; $r < count($request->toc); $r++) {
        if ($r<=30) {
            $table->addRow();
            $table->addCell(9999, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($request->toc[$r]));
            $table->addCell(700, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($o),array( 'bold' => false),array('align'=>'center','valign'=>'center'));
        }
    


    if ($r>30) {

         if ($pagebreak==true) {
                     $section->addPageBreak();
                     
                     $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $table2 = $section->addTable();
                     $pagebreak=false;
          }        
         
         $table2->addRow();
            $table2->addCell(9999, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($request->toc[$r]));
            $table2->addCell(700, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($o),array( 'bold' => false),array('align'=>'center','valign'=>'center'));
        
    }
    // $table->addCell(1750)->addText(htmlspecialchars("Row 1, Cell 2"));
   $o++;
    }
                    $phpWord->save('uploads/files/TOC/'.$filename.'.docx');
                  $document = $phpWord->loadTemplate('uploads/files/TOC/'.$filename.'.docx');
                    $document->saveAs('uploads/files/TOC/temp.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/TOC/temp.docx'); 

                    //Save it
                    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
                    $xmlWriter->save('uploads/files/TOC/'.$filename.'.pdf');  
                 if ($request->toc_watermark=='1') {
                       $this->generatePDF("uploads/files/TOC/".$filename.".pdf", "uploads/files/TOC/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                        $pdf->addPDF('uploads/files/TOC/'.$filename.'_watermark.pdf');
                    }else{
                    
                        $pdf->addPDF('uploads/files/TOC/'.$filename.'.pdf');
                    }
    for ($p=0; $p <count($request->toc) ; $p++) { 
        $h=$p+1;
        // $section->addPageBreak();
         $php01 = new \PhpOffice\PhpWord\PhpWord();
        $section = $php01->addSection();

                for ($i=0; $i <13 ; $i++) { 
                   $section->addTextBreak();
                }
               

                
                
               
                
                //$phpWord->addFontStyle('r2Style', array('bold'=>true, 'italic'=>false, 'size'=>12));
                //$phpWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));
                $section->addText($h.'.', array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));
                $section->addText($request->toc[$p], array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));

                 $php01->save('uploads/files/separator'.$h.'.docx');
                  $document01 = $php01->loadTemplate('uploads/files/separator'.$h.'.docx');
                    $document01->saveAs('uploads/files/temp.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $php01 = \PhpOffice\PhpWord\IOFactory::load('uploads/files/temp.docx'); 

                    //Save it
                    $xmlWriter01 = \PhpOffice\PhpWord\IOFactory::createWriter($php01 , 'PDF');
                    $xmlWriter01->save('uploads/files/separator'.$h.'.pdf');  
                 
    }

}elseif ($request->format_toc=='a') {
     
    for ($r = 'a',$o=0; $o < count($request->toc); $r++,$o++) {
    if ($o<=30) {
                    $table->addRow();
                    $table->addCell(9999, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($request->toc[$o]));
                    $table->addCell(700, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($r),array( 'bold' => false),array('align'=>'center','valign'=>'center'));
                }
            


            if ($o>30) {

                 if ($pagebreak==true) {
                             $section->addPageBreak();
                             
                             $section->addTextBreak();
                            $section->addTextBreak();
                            $section->addTextBreak();
                            $section->addTextBreak();
                            $table2 = $section->addTable();
                             $pagebreak=false;
                  }        
                 
                 $table2->addRow();
                    $table2->addCell(9999, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($request->toc[$o]));
                    $table2->addCell(700, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($r),array( 'bold' => false),array('align'=>'center','valign'=>'center'));
                
            }
    }
                    $phpWord->save('uploads/files/TOC/'.$filename.'.docx');
                  $document = $phpWord->loadTemplate('uploads/files/TOC/'.$filename.'.docx');
                    $document->saveAs('uploads/files/TOC/temp.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/TOC/temp.docx'); 

                    //Save it
                    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
                    $xmlWriter->save('uploads/files/TOC/'.$filename.'.pdf');  
                 if ($request->toc_watermark=='1') {
                       $this->generatePDF("uploads/files/TOC/".$filename.".pdf", "uploads/files/TOC/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                        $pdf->addPDF('uploads/files/TOC/'.$filename.'_watermark.pdf');
                    }else{
                    
                        $pdf->addPDF('uploads/files/TOC/'.$filename.'.pdf');
                    }

    for ($p=0,$z='a'; $p <count($request->toc) ; $p++,$z++) { 
        $h=$p+1;
        $php01 = new \PhpOffice\PhpWord\PhpWord();
        $section = $php01->addSection();

                for ($i=0; $i <13 ; $i++) { 
                   $section->addTextBreak();
                }
               

                
                
               
                
                //$phpWord->addFontStyle('r2Style', array('bold'=>true, 'italic'=>false, 'size'=>12));
                //$phpWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));
                $section->addText($z.'.', array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));
                $section->addText($request->toc[$p], array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));
                 $php01->save('uploads/files/separator'.$h.'.docx');
                  $document01 = $php01->loadTemplate('uploads/files/separator'.$h.'.docx');
                    $document01->saveAs('uploads/files/temp.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $php01 = \PhpOffice\PhpWord\IOFactory::load('uploads/files/temp.docx'); 

                    //Save it
                    $xmlWriter01 = \PhpOffice\PhpWord\IOFactory::createWriter($php01 , 'PDF');
                    $xmlWriter01->save('uploads/files/separator'.$h.'.pdf');  
    }
    // $table->addCell(1750)->addText(htmlspecialchars("Row 1, Cell 2"));
    
    
}




                
                // Adding Text element to the Section having font styled by default...
                //$section->addTitle("Title");
// 2. Advanced table

                    //  $phpWord->save('uploads/files/TOC/'.$filename.'.docx');
                    //   $document = $phpWord->loadTemplate('uploads/files/TOC/'.$filename.'.docx');
                    // $document->saveAs('uploads/files/TOC/temp.docx');

                    // \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    // \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    // //Load temp file
                    // $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/TOC/temp.docx'); 

                    // //Save it
                    // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
                    // $xmlWriter->save('uploads/files/TOC/'.$filename.'.pdf');  
                    // if ($request->toc_watermark=='1') {
                    //    $this->generatePDF("uploads/files/TOC/".$filename.".pdf", "uploads/files/TOC/".$filename."_watermark.pdf","uploads/files/watermark_header.png","uploads/files/watermark_footer.png");
                    //     $pdf->addPDF('uploads/files/TOC/'.$filename.'_watermark.pdf');
                    // }else{
                    
                    //     $pdf->addPDF('uploads/files/TOC/'.$filename.'.pdf');
                    // }
// 

           
                
            

        
             foreach ($files as $value)
            {
            

                $extensions=explode(".", $value);

           
                
            
                // $phpWord = new \PhpOffice\PhpWord\PhpWord();
                // $section = $phpWord->addSection();

                // for ($i=0; $i <12 ; $i++) { 
                //    
                // }
               

                // $title=Names::where('names','=',$value)->first();

                // if ($title->title != NULL) {
                //     $text = $title->title;    
                // }else{
                //     $text = $extensions[0];
                // }
                
               
                
                // //$phpWord->addFontStyle('r2Style', array('bold'=>true, 'italic'=>false, 'size'=>12));
                // //$phpWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));
                // $section->addText($text, array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));


                
                // // Adding Text element to the Section having font styled by default...
                // //$section->addTitle("Title");
                // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                // $objWriter->save('uploads/files/title_'.$k.'.docx');
                // \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
                //     \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                //     //Load temp file
                // $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/title_'.$k.'.docx'); 

                //     //Save it
                // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
                // $xmlWriter->save('uploads/files/title'.$k.'.pdf');  

                // $pdf->addPDF('uploads/files/title'.$k.'.pdf', 'all', 'vertical');
            

            if($extensions[1]=='pdf')
            {
                if ($request->ff != null) {
                    foreach ($request->ff as $f) {
                    if ($f==$value) {
                        $pdf->addPDF('uploads/files/'.$value.'_watermark.pdf', 'all', 'vertical');
                        $exit=true;
                    } 

                }
                }
                
                if ($request->zz!=null) {
                    
                     foreach ($request->zz as $f) {
                    if ($f==$value) {
                        $pdf->addPDF('uploads/files/'.$value.'_letter.pdf', 'all', 'vertical');
                        $exit=true;
                    } 

                }
                }
                if ($exit==false) {
                    $pdf->addPDF('uploads/files/'.$value, 'all', 'vertical');
                }
                
             $exit=false;   
            }
            

            elseif ($extensions[1]=='jpg' || $extensions[1]=='png' || $extensions[1]=='JPG' || $extensions[1]=='PNG' || $extensions[1]=='JPEG' || $extensions[1]=='jpeg') 
            {

            
               if ($request->ff!=null) {
                  foreach ($request->ff as $f) {
                    if ($f==$value) {

                        $pdf->addPDF('uploads/files/'.$value.'_watermark.pdf', 'all', 'vertical');
                        $exit=true;
                    } 


                }
               }
               
                 if ($request->zz!=null) {
                   
                     foreach ($request->zz as $f) {
                    if ($f==$value) {
                        $pdf->addPDF('uploads/files/'.$value.'_letter.pdf', 'all', 'vertical');
                        $exit=true;
                    } 

                }
                }
                if ($exit==false) {
                    $pdf->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                }

                $exit=false;
            }
            

            elseif ($extensions[1]=='docx' || $extensions[1]=='doc') 
            {
                if ($request->ff!=null) {
                   foreach ($request->ff as $f) {
                    if ($f==$value) {
                        $pdf->addPDF('uploads/files/'.$value.'_watermark.pdf', 'all', 'vertical');
                        $exit=true;
                    } 

                }
                }
              
                  if ($request->zz!=null) {
                    
                     foreach ($request->zz as $f) {
                    if ($f==$value) {
                        $pdf->addPDF('uploads/files/'.$value.'_letter.pdf', 'all', 'vertical');
                        $exit=true;
                    } 

                }
                }
                if ($exit==false) {
                    $pdf->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                }
        
            $exit=false;
            }
            
            elseif ($extensions[1]=='xls' || $extensions[1]=='xlsx') {

               
                if ($request->ff!=null) {
                    foreach ($request->ff as $f) {
                    if ($f==$value) {
                        $pdf->addPDF('uploads/files/'.$value.'_watermark.pdf', 'all', 'vertical');
                        $exit=true;
                    } 

                }
                }
                   
                    if ($request->zz!=null) {
                    
                     foreach ($request->zz as $f) {
                    if ($f==$value) {
                        $pdf->addPDF('uploads/files/'.$value.'_letter.pdf', 'all', 'vertical');
                        $exit=true;
                    } 

                }
                }
                if ($exit==false) {
                    $pdf->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                }
                $exit=false;
            }
            
            $k++;

        }//endforeach
        
       
        
        $pdf->merge('file','uploads/files/merged/'.$filename."_formated.pdf" );
        // $ilovepdf = new \Ilovepdf\Ilovepdf('project_public_c1df82eee7732956524500d947ac4d5b_M6_avfd304b0f389354873ac80eb1bddd62f5','secret_key_7a00216dc9f58244778f3c6495d9682e_QHKse0bd6410d87df08a51e19b4f72b741e5e');

        // // Choose your processing tool and create a new task
        // $myTaskCompress = $ilovepdf->newTask('compress');

        // // Add files to task for upload
        // $file1 = $myTaskCompress->addFile('uploads/files/merged/'.$filename."_formated.pdf");


        // // Execute the task
        // $myTaskCompress->execute();

        // // Download the packaged files
        // $myTaskCompress->download();
        // $myTaskCompress->toBrowser();
        $name_for_mail=$filename."_formated.pdf";
        }//endif
        //  elseif ($request->typ=="1") {
        //     $k=1;

            

        
        //      foreach ($files as $value)
        //     {
            

        //         $extensions=explode(".", $value);

           
                
            
        //         // $phpWord = new \PhpOffice\PhpWord\PhpWord();
        //         // $section = $phpWord->addSection();

        //         // for ($i=0; $i <12 ; $i++) { 
        //         //     $section->addTextBreak();
        //         // }
               

        //         // $title=Names::where('names','=',$value)->first();

        //         // if ($title->title != NULL) {
        //         //     $text = $title->title;    
        //         // }else{
        //         //     $text = $extensions[0];
        //         // }
                

                
        //         // //$phpWord->addFontStyle('r2Style', array('bold'=>true, 'italic'=>false, 'size'=>12));
        //         // //$phpWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));
        //         // $section->addText($text, array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));


                
        //         // // Adding Text element to the Section having font styled by default...
        //         // //$section->addTitle("Title");
        //         // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        //         // $objWriter->save('uploads/files/title_'.$k.'.docx');
        //         // \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
        //         //     \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        //         //     //Load temp file
        //         // $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/title_'.$k.'.docx'); 

        //         //     //Save it
        //         // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
        //         // $xmlWriter->save('uploads/files/title'.$k.'.pdf');  

        //         // $pdf->addPDF('uploads/files/title'.$k.'.pdf', 'all', 'vertical');
            

        //     if($extensions[1]=='pdf')
        //     {
        //         foreach ($request->ff as $f) {
        //             if ($f==$value) {
        //                 $pdf->addPDF('uploads/files/'.$value.'_letter.pdf', 'all', 'vertical');
        //                 $exit=true;
        //             } 

        //         }
        //         if ($exit==false) {
        //             $pdf->addPDF('uploads/files/'.$value, 'all', 'vertical');
        //         }
                
        //      $exit=false;   
        //     }
            

        //     elseif ($extensions[1]=='jpg' || $extensions[1]=='png') 
        //     {

            
               
        //        foreach ($request->ff as $f) {
        //             if ($f==$value) {
        //                 $pdf->addPDF('uploads/files/'.$value.'_letter.pdf', 'all', 'vertical');
        //                 $exit=true;
        //             } 

        //         }
        //         if ($exit==false) {
        //             $pdf->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        //         }

        //         $exit=false;
        //     }
            

        //     elseif ($extensions[1]=='docx' || $extensions[1]=='doc') 
        //     {
                
        //        foreach ($request->ff as $f) {
        //             if ($f==$value) {
        //                 $pdf->addPDF('uploads/files/'.$value.'_letter.pdf', 'all', 'vertical');
        //                 $exit=true;
        //             } 

        //         }
        //         if ($exit==false) {
        //             $pdf->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        //         }
        
        //     $exit=false;
        //     }
            
        //     elseif ($extensions[1]=='xls' || $extensions[1]=='xlsx') {

               
               
        //            foreach ($request->ff as $f) {
        //             if ($f==$value) {
        //                 $pdf->addPDF('uploads/files/'.$value.'_letter.pdf', 'all', 'vertical');
        //                 $exit=true;
        //             } 

        //         }
        //         if ($exit==false) {
        //             $pdf->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        //         }
        //         $exit=false;
        //     }
            
        //     $k++;

        // }//endforeach
        
       

        // $pdf->merge('file','uploads/files/merged/'.$filename."_letter.pdf" );
        // $name_for_mail=$filename."_letter.pdf";
        // }//endif
       
       
        // if ($request->typ=="letter") {
        //     $k=1;

        // foreach ($files as $value)
        // {
            
        //         $extensions=explode(".", $value);

           
                
            
        //         $phpWord = new \PhpOffice\PhpWord\PhpWord();
        //         $section = $phpWord->addSection();

        //         for ($i=0; $i <12 ; $i++) { 
        //             $section->addTextBreak();
        //         }
               

        //         $title=Names::where('names','=',$value)->first();

        //         if ($title->title != NULL) {
        //             $text = $title->title;    
        //         }else{
        //             $text = $extensions[0];
        //         }
                

                
        //         //$phpWord->addFontStyle('r2Style', array('bold'=>true, 'italic'=>false, 'size'=>12));
        //         //$phpWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));
        //         $section->addText($text, array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));


                
        //         // Adding Text element to the Section having font styled by default...
        //         //$section->addTitle("Title");
        //         $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        //         $objWriter->save('uploads/files/title_'.$k.'.docx');
        //         \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
        //             \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        //             //Load temp file
        //         $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/title_'.$k.'.docx'); 

        //             //Save it
        //         $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
        //         $xmlWriter->save('uploads/files/title'.$k.'.pdf');  

        //         $pdf->addPDF('uploads/files/title'.$k.'.pdf', 'all', 'vertical');
            

        //     if($extensions[1]=='pdf')
        //     {
        //         $pdf->addPDF('uploads/files/'.$value.'_letter.'.$extensions[1], 'all', 'vertical');
        //     }


        //     elseif ($extensions[1]=='jpg' || $extensions[1]=='png') 
        //     {

            
               
        //         $pdf->addPDF('uploads/files/'.$value.'_letter.'.$extensions[1], 'all', 'vertical');

            
        //     }

        //     elseif ($extensions[1]=='docx' || $extensions[1]=='doc') 
        //     {
                
        //         $pdf->addPDF('uploads/files/'.$value.'_letter.'.$extensions[1], 'all', 'vertical');
        

        //     }elseif ($extensions[1]=='xls' || $extensions[1]=='xlsx') {

        //         //dd("sorry xlsx in merging is not available right now");
        //         // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
        //         // $spreadsheet = $reader->load('uploads/files/'.$value); 
        //         // $ws = $spreadsheet->getActiveSheet(); 
        //         // $ws->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        //         // $ws->getPageSetup()->setFitToWidth(1);
        //         // $ws->getPageSetup()->setFitToHeight(1);
        //         // $ws->setShowGridlines(false);
                
        //         //     $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Dompdf');

                    
        //         //     $writer->save('uploads/files/result_excel'.$j.'.pdf');

               
        //             $pdf->addPDF('uploads/files/'.$value.'_letter.'.$extensions[1], 'all', 'vertical');

        //     }
        //     $k++;

        // }//endforeach

        // $pdf->merge('file','uploads/files/merged/'.$filename."_letter.pdf" );
        // }//endif

    if ($request->ff==null && $request->zz==null) { 

        
        $j=1;
         $phpWord = new \PhpOffice\PhpWord\PhpWord();
        
$section = $phpWord->addSection();
$header = array('size' => 18, 'bold' => true);
// 1. Basic table
 $section->addTextBreak();
$section->addText(htmlspecialchars('CONTENTS'), $header,array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));
 $section->addTextBreak();

 
$table = $section->addTable();

$pagebreak=true;
if ($request->format_toc=='1') {
    $o=1;
    for ($r = 0; $r < count($request->toc); $r++) {
        if ($r<=30) {
            $table->addRow();
            $table->addCell(9999, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($request->toc[$r]));
            $table->addCell(700, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($o),array( 'bold' => false),array('align'=>'center','valign'=>'center'));
        }
    


    if ($r>30) {

         if ($pagebreak==true) {
                     $section->addPageBreak();
                     
                     $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $table2 = $section->addTable();
                     $pagebreak=false;
          }        
         
         $table2->addRow();
            $table2->addCell(9999, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($request->toc[$r]));
            $table2->addCell(700, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($o),array( 'bold' => false),array('align'=>'center','valign'=>'center'));
        
    }
    // $table->addCell(1750)->addText(htmlspecialchars("Row 1, Cell 2"));
   $o++;
    }
                    $phpWord->save('uploads/files/TOC/'.$filename.'.docx');
                  $document = $phpWord->loadTemplate('uploads/files/TOC/'.$filename.'.docx');
                    $document->saveAs('uploads/files/TOC/temp.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/TOC/temp.docx'); 

                    //Save it
                    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
                    $xmlWriter->save('uploads/files/TOC/'.$filename.'.pdf');  
                 $PDF->addPDF('uploads/files/TOC/'.$filename.'.pdf');
    for ($p=0; $p <count($request->toc) ; $p++) { 
        $h=$p+1;
        // $section->addPageBreak();
         $php01 = new \PhpOffice\PhpWord\PhpWord();
        $section = $php01->addSection();

                for ($i=0; $i <13 ; $i++) { 
                   $section->addTextBreak();
                }
               

                
                
               
                
                //$phpWord->addFontStyle('r2Style', array('bold'=>true, 'italic'=>false, 'size'=>12));
                //$phpWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));
                $section->addText($h.'.', array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));
                $section->addText($request->toc[$p], array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));

                 $php01->save('uploads/files/separator'.$h.'.docx');
                  $document01 = $php01->loadTemplate('uploads/files/separator'.$h.'.docx');
                    $document01->saveAs('uploads/files/temp.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $php01 = \PhpOffice\PhpWord\IOFactory::load('uploads/files/temp.docx'); 

                    //Save it
                    $xmlWriter01 = \PhpOffice\PhpWord\IOFactory::createWriter($php01 , 'PDF');
                    $xmlWriter01->save('uploads/files/separator'.$h.'.pdf');  
                 
    }

}elseif ($request->format_toc=='a') {
     
    for ($r = 'a',$o=0; $o < count($request->toc); $r++,$o++) {
    if ($o<=30) {
                    $table->addRow();
                    $table->addCell(9999, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($request->toc[$o]));
                    $table->addCell(700, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($r),array( 'bold' => false),array('align'=>'center','valign'=>'center'));
                }
            


            if ($o>30) {

                 if ($pagebreak==true) {
                             $section->addPageBreak();
                             
                             $section->addTextBreak();
                            $section->addTextBreak();
                            $section->addTextBreak();
                            $section->addTextBreak();
                            $table2 = $section->addTable();
                             $pagebreak=false;
                  }        
                 
                 $table2->addRow();
                    $table2->addCell(9999, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($request->toc[$o]));
                    $table2->addCell(700, array('borderSize' => 6,'borderColor'=>'black'))->addText(htmlspecialchars($r),array( 'bold' => false),array('align'=>'center','valign'=>'center'));
                
            }
    }
                    $phpWord->save('uploads/files/TOC/'.$filename.'.docx');
                  $document = $phpWord->loadTemplate('uploads/files/TOC/'.$filename.'.docx');
                    $document->saveAs('uploads/files/TOC/temp.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load('uploads/files/TOC/temp.docx'); 

                    //Save it
                    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
                    $xmlWriter->save('uploads/files/TOC/'.$filename.'.pdf');  
                 $PDF->addPDF('uploads/files/TOC/'.$filename.'.pdf');

    for ($p=0,$z='a'; $p <count($request->toc) ; $p++,$z++) { 
    $h=$p+1;
        $php01 = new \PhpOffice\PhpWord\PhpWord();
        $section = $php01->addSection();

                for ($i=0; $i <13 ; $i++) { 
                   $section->addTextBreak();
                }
               

                
                
               
                
                //$phpWord->addFontStyle('r2Style', array('bold'=>true, 'italic'=>false, 'size'=>12));
                //$phpWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));
                $section->addText($z.'.', array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));
                $section->addText($request->toc[$p], array('bold'=>true, 'italic'=>false, 'size'=>25), array('align'=>'center','valign'=>'center', 'spaceAfter'=>100));
                 $php01->save('uploads/files/separator'.$h.'.docx');
                  $document01 = $php01->loadTemplate('uploads/files/separator'.$h.'.docx');
                    $document01->saveAs('uploads/files/temp.docx');

                    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('/vendor/dompdf/dompdf'));
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    //Load temp file
                    $php01 = \PhpOffice\PhpWord\IOFactory::load('uploads/files/temp.docx'); 

                    //Save it
                    $xmlWriter01 = \PhpOffice\PhpWord\IOFactory::createWriter($php01 , 'PDF');
                    $xmlWriter01->save('uploads/files/separator'.$h.'.pdf');  
    }
    // $table->addCell(1750)->addText(htmlspecialchars("Row 1, Cell 2"));
    
    
}





                
                // Adding Text element to the Section having font styled by default...
                //$section->addTitle("Title");
// 2. Advanced table

 
                 
// 

        foreach ($files as $value)
        {
            
            $extensions=explode(".", $value);

        
            if($extensions[1]=='pdf'||$extensions[1]=='PDF' )
            {
                $PDF->addPDF('uploads/files/'.$value, 'all', 'vertical');
            }


            elseif ($extensions[1]=='jpg' || $extensions[1]=='png' || $extensions[1]=='jpeg' || $extensions[1]=='JPEG' || $extensions[1]=='JPG' || $extensions[1]=='PNG') 
            {

            
               
                $PDF->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');

            
            }

            elseif ($extensions[1]=='docx' || $extensions[1]=='doc' || $extensions[1]=='DOCX' || $extensions[1]=='DOC') 
            {
                
                $PDF->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        

            }elseif ($extensions[1]=='xls' || $extensions[1]=='xlsx') {

                
               
                    $PDF->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');

            }
            $j++;

        }//endforeach

            //$fpdf->Output('F','uploads/files/image_temp.pdf');
            
            
            // call merge, output format `file`
            $PDF->merge('file',"uploads/files/merged/".$filename.'.pdf' );
            
           
            $new_merge=new Merged();
            $new_merge->user_id=auth()->user()->id;
            $new_merge->dropdown=$request->dropdown;
            $new_merge->name=$filename;
            $new_merge->title=$request->title;
            $new_merge->client_name=$request->clientname;
            $new_merge->sr_no=$sr_no;
            $new_merge->due_date=$request->duedate;
            $new_merge->workstation_id=Session::get('workstation_id');
            $new_merge->save();

          
            // $m1=$request->to;
            // $s1=$request->subject;
            //  if ($request->email_check=='on') {
            //     Mail::send('email_welcome', [], function ($m) use($m1,$s1,$filename){
                   
            //         $m->to($m1);
            //         $m->subject($s1);
                    
            //         // $m->attach("uploads/files/merged/".$filename.".pdf");
                    
            //     });
           
            // }
           
            
     }
         if ($request->zz!=null || $request->ff!=null) 
             {

                 $TOC->addPDF('uploads/files/TOC/'.$filename.'.pdf');
// 
            $k=1;
            $ex=false;
            

        
             foreach ($files as $value)
            {
            

                $extensions=explode(".", $value);

           
            if($extensions[1]=='pdf' || $extensions[1]=='PDF' )
            {
                  if ($request->ff !=null) {
                    foreach ($request->ff as $f) {
                   if ($f==$value) {
                        $W->addPDF('uploads/files/'.$value, 'all', 'vertical');
                        $ex=true;
                        
                    }


                }
               }
                if ($request->zz != null) {
                     foreach ($request->zz as $f) {
                   if ($f==$value) {
                        $L->addPDF('uploads/files/'.$value, 'all', 'vertical');
                        $ex=true;
                        
                    }


                }
                }
                
                if ($ex==false) {
                    $P->addPDF('uploads/files/'.$value, 'all', 'vertical');
                }
                
             $ex=false;  
                
            }
            

            elseif ($extensions[1]=='jpg' || $extensions[1]=='jpeg' || $extensions[1]=='png' || $extensions[1]=='JPG' || $extensions[1]=='JPEG' || $extensions[1]=='PNG') 
            {

            
               if ($request->ff !=null) {
                    foreach ($request->ff as $f) {
                   if ($f==$value) {
                        $W->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                        $ex=true;
                        
                    }


                }
               }
                if ($request->zz != null) {
                     foreach ($request->zz as $f) {
                   if ($f==$value) {
                        $L->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                        $ex=true;
                        
                    }


                }
                }
                
                if ($ex==false) {
                    $P->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                }
                
             $ex=false;  

            }
            

            elseif ($extensions[1]=='docx' || $extensions[1]=='doc' || $extensions[1]=='DOCX' || $extensions[1]=='DOC') 
            {
                
                if ($request->ff !=null) {
                    foreach ($request->ff as $f) {
                   if ($f==$value) {
                        $W->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                        $ex=true;
                        
                    }


                }
               }
                 if ($request->zz != null) {
                     foreach ($request->zz as $f) {
                   if ($f==$value) {
                        $L->addPDF('uploads/files/'.$value, 'all', 'vertical');
                        $ex=true;
                        
                    }


                }
                }
                
                if ($ex==false) {
                    $P->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                }
                
             $ex=false;  
               
            }
            
            elseif ($extensions[1]=='xls' || $extensions[1]=='xlsx') {

               
               if ($request->ff !=null) {
                    foreach ($request->ff as $f) {
                   if ($f==$value) {
                        $W->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                        $ex=true;
                        
                    }


                }
               }
                  
               if ($request->zz != null) {
                     foreach ($request->zz as $f) {
                   if ($f==$value) {
                        $L->addPDF('uploads/files/'.$value, 'all', 'vertical');
                        $ex=true;
                        
                    }


                }
                }
                
                if ($ex==false) {
                    $P->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
                }
                
             $ex=false;  
            }
            
            $k++;

        }//endforeach
        // dd(count($request->ff).",".count($request->ssf));
       $TOC->merge('file',"uploads/files/merged/".$filename."_toc.pdf" );
        array_push($sh, $filename.'_toc.pdf');
        if ($request->ff != null) {
            
                $W->merge('file',"uploads/files/merged/".$filename."_with_watermark.pdf" );
                array_push($sh, $filename.'_with_watermark.pdf');
        }
        if ($request->zz !=null && $request->ff!=null) {
           $count=count($request->zz)+count($request->ff); 
            if ( $count != count($request->ssf)) {
            $P->merge('file',"uploads/files/merged/".$filename."_simple.pdf" );
            array_push($sh, $filename.'_simple.pdf');
        }
        }
         
         if ($request->zz != null) {
            //  dd($L);
            $L->merge('file',"uploads/files/merged/".$filename."_letter.pdf" );
            array_push($sh, $filename.'_letter.pdf');
        }
        // $P->merge('file',"uploads/files/merged/".$filename."_simple.pdf" );
        // $sh=$filename."_with_formated.pdf";
        $a=json_encode($sh);
            $new_merge=new Merged();
            $new_merge->user_id=auth()->user()->id;
            $new_merge->dropdown=$request->dropdown;
            $new_merge->name=$a;
            $new_merge->email_name=$name_for_mail;
            $new_merge->title=$request->title;
            $new_merge->client_name=$request->clientname;
            $new_merge->sr_no=$sr_no;
            $new_merge->due_date=$request->duedate;
            $new_merge->workstation_id=Session::get('workstation_id');
            $new_merge->save();
            // $m1=$request->to;
            // $s1=$request->subject;

            // if ($request->email_check=='on') {
            //     Mail::send('email_welcome', [], function ($m) use($m1,$s1,$name_for_mail){
                   
            //         $m->to($m1);
            //         $m->subject($s1);
                    
            //         $m->attach("uploads/files/merged/".$name_for_mail);
                    
            //     });
           
            // }
       

        }//endif
        //  if ($request->typ=="1") 
        //      {
        //     $k=1;
        //     $ex=false;
            

        
        //      foreach ($files as $value)
        //     {
            

        //             $extensions=explode(".", $value);

        //     if($extensions[1]=='pdf')
        //     {
        //          foreach ($request->ff as $f) {
        //            if ($f==$value) {
        //                 $W->addPDF('uploads/files/'.$value, 'all', 'vertical');
        //                 $ex=true;
                        
        //             }


        //         }
        //         if ($ex==false) {
        //             $P->addPDF('uploads/files/'.$value, 'all', 'vertical');
        //         }
                
        //      $ex=false;  
                
        //     }
            

        //     elseif ($extensions[1]=='jpg' || $extensions[1]=='png') 
        //     {

            
        //        foreach ($request->ff as $f) {
        //            if ($f==$value) {
        //                 $W->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        //                 $ex=true;
                        
        //             }


        //         }
        //         if ($ex==false) {
        //             $P->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        //         }
                
        //      $ex=false;  

        //     }
            

        //     elseif ($extensions[1]=='docx' || $extensions[1]=='doc') 
        //     {
                
        //         foreach ($request->ff as $f) {
        //            if ($f==$value) {
        //                 $W->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        //                 $ex=true;
                        
        //             }


        //         }
        //         if ($ex==false) {
        //             $P->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        //         }
                
        //      $ex=false;  
               
        //     }
            
        //     elseif ($extensions[1]=='xls' || $extensions[1]=='xlsx') {

               
               
        //            foreach ($request->ff as $f) {
        //            if ($f==$value) {
        //                 $W->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        //                 $ex=true;
                        
        //             }


        //         }
        //         if ($ex==false) {
        //             $P->addPDF('uploads/files/'.$value.'.pdf', 'all', 'vertical');
        //         }
                
        //      $ex=false;  
        //     }
            
        //     $k++;

        // }//endforeach
        
       

        // $W->merge('file',"uploads/files/merged/".$filename."_with_letter.pdf" );
        // if (count($request->ff) != count($request->ssf)) {
        //     $P->merge('file',"uploads/files/merged/".$filename."_simple.pdf" );
        // }
         
        // $sh=$filename."_with_letter.pdf";
        //  $new_merge=new Merged();
        //     $new_merge->user_id=auth()->user()->id;
        //     $new_merge->dropdown=$request->dropdown;
        //     $new_merge->name=$filename;
        //     $new_merge->email_name=$name_for_mail;
        //     $new_merge->title=$request->title;
        //     $new_merge->client_name=$request->clientname;
        //     $new_merge->sr_no=$sr_no;
        //     $new_merge->due_date=$request->duedate;
        //     $new_merge->workstation_id=Session::get('workstation_id');
        //     $new_merge->save();
        //     $m1=$request->to;
        //     $s1=$request->subject;
            
        //     if ($request->email_check=='on') {
        //         Mail::send('email_welcome', [], function ($m) use($m1,$s1,$name_for_mail){
                   
        //             $m->to($m1);
        //             $m->subject($s1);
                    
        //             $m->attach("uploads/files/merged/".$name_for_mail);
                    
        //         });

        //     }
       

        // }//endif

          

     if ($request->zz ==null && $request->ff==null) {
           return  view('for_print')->with('filename',$filename);
      }else{
         return  view('for_print',array(
                'filename'=> $filename,
                'filename_with'=>$sh
         ));
      } 
            //return " successfull";
           
        

    }
    public function showTitle(){
        $files=Names::all();
        // foreach ($files as $key => $value) {
        //     dd($value->names);
        // }
        return view('for_titles')->with('files',$files);
    }

     public function updateTitle(Request $request){
        $id=$request->names;
        $title=$request->title;

         DB::table('names')
        ->where('id', $id)  
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array('title' => $title));

        return back()->with('done', 'Title is added successfully !');



    }

    public function mergedFilesShow(){
        // $files=Merged::all();
        $table = DB::table('mergeds')
                 ->join('users','mergeds.user_id','users.id')
                 ->where('mergeds.workstation_id','=',Session::get('workstation_id'))
                 ->where('mergeds.status','=',0)
                 ->orderby('created_at','desc')
                 ->get(['users.name As user_name','mergeds.*']);

        return view('merged_files')->with("files",$table);
    }
     public function mergedFilesShowArchive(){
        // $files=Merged::all();
        $table = DB::table('mergeds')
                 ->join('users','mergeds.user_id','users.id')
                 ->where('mergeds.workstation_id','=',Session::get('workstation_id'))
                 ->where('mergeds.status','=',1)
                 ->orderby('created_at','desc')
                 ->get(['users.name As user_name','mergeds.*']);

        return view('archived_merged')->with("files",$table);
    }

     public function mergedFileDelete($id){
        // $files=Merged::all();
        
        Merged::find($id)->delete();
        return back()->with("done","Profile Deleted");
    }

     public function mergedFileArchive(){

        // $files=Merged::all();
        $id=$_GET['id'];
        Merged::where('id','=',$id)->update(['status'=>1]);
        return "archived";
    }
     public function mergedFileArchiveBack(){

        // $files=Merged::all();
        $id=$_GET['id'];
        Merged::where('id','=',$id)->update(['status'=>0]);
        return "archived";
    }



    public function sendMail(){

    }
}




// <tr >
//                                     <td style="padding:15px 0;width: 70px; ">Format </td>
//                                     <td>
//                                         <div class="md-input-wrapper"><select name="typ"  class="uk-form-small" onchange="selfiles()">
//                                <option value="0">Format</option>
//                               {{--  <option value="1">Letter_Head</option> --}}
//                                <option value="none" selected>None</option>
//                                </select></div>
//                                     </td>
//                                 </tr>
//                                  <tr id="sel" style="display: none;">

//                                     <td style="padding:15px 0;width: 70px; ">For Watermark</td>
//                                     <td >
                                           
//                                         <div class="md-input-wrapper uk-form-small ff" ><select name="ff[]" id="selected" class="op" multiple style="overflow: scroll;max-width: 50%">


                                            
                    
//                        </select></div>
                       
//                                     </td>
//                                 </tr>
//                                  <tr id="sel1" style="display: none;">

//                                     <td style="padding:15px 0;width: 70px; ">For LetterHead</td>
//                                     <td >
                                           
//                                         <div class="md-input-wrapper uk-form-small fff" ><select name="zz[]" id="selected-2" class="op" multiple style="overflow: scroll;max-width: 50%">


                                            
                    
//                        </select></div>
                       
//                                     </td>
//                                 </tr>