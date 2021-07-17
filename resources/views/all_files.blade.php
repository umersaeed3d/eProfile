@extends('com.layout')
@section('title')
Select Files To Create A Technical Profile
@endsection
@section('body')

<form action="/files/merge" method='POST' enctype="multipart/form-data">
    <div class="uk-width-medium-6-10 uk-push-2-10 uk-row-first">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <div class="uk-alert uk-alert-success" data-uk-alert="">
                                <a href="#" class="uk-alert-close uk-close"></a>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
        </div>
     <div class="uk-grid " data-uk-grid-margin>
                <div class="uk-width-2-3 " style="overflow: auto;height: 600px;">
                     
                                        {{csrf_field()}}
                    
                    @foreach($table as $maindirectory)
                    <ul class="uk-nestable" data-uk-nestable>
                        
                            
                        <li class="uk-nestable-item uk-parent uk-collapsed">
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" data-nestable-action="toggle" onclick="sendid({{$maindirectory->id}})"></div>
                                    {{$maindirectory->name}}<span style="float: right">Files: {{App\Names::where('directory_id','=',$maindirectory->id)->where('status','=',0)->count()}}</span>
                            </div>
                            <ul class="{{$maindirectory->id}}">
                                
                            </ul>
                        </li>
                        
                        
                    </ul>
                    @endforeach
                    
                    
                    
                    {{-- <button type="submit" class="uk-button-primary">Merge!</button> --}}
                   
                    {{-- <a href="#modal-example" uk-toggle>Open</a>  --}}

                        
                </div>
                <div class="uk-modal" id="modal_content">
                                <div class="uk-modal-dialog">
                                    <div class="uk-modal-header">
                                        <h3 class="uk-modal-title">Content Form<i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">&#xE8FD;</i></h3>
                                    </div>
                                   
                                        <table style="width: 100%" class="uk-table uk-table-stripped">

                                <tbody>
                                   
                                    <td style="padding:15px 0;width: 70px; ">TOC Rows</td>
                                    <td>
                                        <div class="md-input-wrapper"><div class="uk-width-medium-1-1">
                                            <input type="number" name="toc-rows" id="toc-rows" class="md-input" onchange="getrows(this.value)" onkeyup="getrows(this.value)"  >
                                        </div></div>
                                    </td>
                                </tr>
                                 <tr>
                                    <td style="padding:15px 0;width: 70px; ">Format</td>
                                    <td>
                                        <div class="md-input-wrapper"><div class="uk-width-medium-1-1">
                                            <select  name="format_toc" required="">
                                                <option value="">Select Option...</option>
                                                
                                                    <option value="1">1,2,3..</option>
                                                    <option value="a">a,b,c..</option>
                                                     
                                            </select>
                                        </div></div>
                                    </td>
                                </tr>
                                <tr>
                                 <tr>
                                    <td style="padding:15px 0;width: 70px; ">Apply Watermark</td>
                                    <td>
                                        <div class="md-input-wrapper"><div class="uk-width-medium-1-1">
                                            <select  name="toc_watermark" required="">
                                                <option value="">Select Option...</option>
                                                
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                     
                                            </select>
                                        </div></div>
                                    </td>
                                </tr>
                                <div id="toc">
                                    
                                </div>
                               

                               
                                


                            </tbody></table>
                                    
                                    <div class="uk-modal-footer uk-text-right">
                                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                        {{-- <button type="submit" class="md-btn md-btn-flat" >Done</button> --}}
                                    </div>
                                    
                                </div>
                            </div>
                            {{-- modalend --}}
                 <div class="uk-modal" id="modal_header_footer">
                                <div class="uk-modal-dialog">
                                    <div class="uk-modal-header">
                                        <h3 class="uk-modal-title">Merged File Form<i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">&#xE8FD;</i></h3>
                                    </div>
                                   
                                        <table style="width: 100%" class="uk-table uk-table-stripped">

                                <tbody>
                                    <tr>
                                    <td style="padding:15px 0;width: 70px; ">Category</td>
                                    <td>
                                        <div class="md-input-wrapper"><div class="uk-width-medium-1-1">
                                            <select  name="dropdown">
                                                <option value="">Select Option...</option>
                                                
                                                    <option value="Technical Bid">Technical Bid</option>
                                                     <option value="Prequalification">Pre-Qualification</option>
                                                      <option value="Introduction">Introduction</option>
                                                                                            </select>
                                        </div></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:15px 0;width: 70px; ">Filename</td>
                                    <td>
                                        <div class="md-input-wrapper"><input type="text" class="md-input " id="name" name="filename" required><span class="md-input-bar " ></span></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:15px 0;width: 70px; ">Project Title</td>
                                    <td>
                                        <div class="md-input-wrapper"><input type="text" class="md-input " id="price" name="title" required><span class="md-input-bar "></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 0;width: 70px; ">Client Name</td>
                                    <td>
                                        <div class="md-input-wrapper"><input type="text" class="md-input " id="name" name="clientname" required><span class="md-input-bar "></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 0;width: 70px; ">Due Date</td>
                                    <td style="width: 100%; ">
                                        <div class="md-input-wrapper"><input type="text" class="md-input " id="name" name="duedate" data-uk-datepicker="{format:'YYYY-MM-DD'}" required><span class="md-input-bar "></span></div>
                                    </td>
                                </tr>
                                 

                                <tr>
                                    <td style="padding:15px 0;width: 70px; "></td>
                                    <td>
                                        <div class="md-input-wrapper" ><input type="checkbox" id="cc" class="md-input cc " name="email_check" ><span>Do you want to send email?</span></div>
                                    </td>
                                </tr>
                                <div id="email" style="display: none">
                                <tr id="to" >
                                    <td style="padding:15px 0;width: 70px; ">To:</td>
                                    <td>
                                        <div class="md-input-wrapper"><input type="text" class="md-input " id="name" name="to" placeholder="example@example.com" ><span class="md-input-bar "></span></div>
                                    </td>
                                </tr>
                               
                                <tr id="subject" > 
                                    <td style="padding:15px 0;width: 70px; ">Subject:</td>
                                    <td>
                                        <div class="md-input-wrapper"><input type="text" class="md-input " id="name" name="subject" placeholder="Hello this is subject" ><span class="md-input-bar "></span></div>
                                    </td>
                                </tr>
                                </div>

                                


                            </tbody></table>
                                    
                                    <div class="uk-modal-footer uk-text-right">
                                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                        <button type="submit" class="md-btn md-btn-flat" >Done</button>
                                    </div>
                                    
                                </div>
                            </div>
                            {{-- modalend --}}
                <div class="uk-width-1-3" style="overflow: auto;height: 600px;">
                <div class="md-card ">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <p>Upload directly From Desktop</p>
                        <input type="file" name="upload[]" multiple="" style="margin-bottom: 10%;" onchange="func()" id="upload">

                            <h4 style="margin-left: 10%;" class="heading_c uk-margin-bottom">Selected Files</h4>
                            <ul class="md-list md-list-addon uk-sortable sortable-handler" data-uk-sortable="{group:'connected-group'}" id="selected-files" style="font-size: 16px;">

                                {{-- <li>
                                    <div class="md-list-addon-element">
                                        <img class="md-user-image md-list-addon-avatar" src="/public_assets/assets/img/files.jpg" alt=""/ style="width:10px; height:5px;">
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Ida Christiansen</span>
                                        <span class="uk-text-small uk-text-muted">A quos deleniti velit sit doloribus dolorem quasi recusandae quibusdam sint in.</span>
                                    </div>
                                </li> --}}
                                
                            </ul>
                            <button style="margin-left: 10%;" class="uk-button-danger"  data-uk-modal="{target:'#modal_header_footer'}">Create Profile</button>
                            <button style="margin-left: 10%;" class="uk-button-danger"  data-uk-modal="{target:'#modal_content'}">Create Content</button>
                        </div>
                
            </div>
        </div>
    </div>
</div>
            </div>

    </div>
    </form>
    
                           



<!-- This is an anchor toggling the modal -->
{{-- <a href="#modal-example" uk-toggle>Open</a> --}}

<!-- This is the modal -->



<script>

    function getrows(no){

        $('#toc').html(null);

        // alert(no);
            for(var i=1;i<=no;i++){
                    $('#toc').append(' <tr id="toc'+i+'"><td style="padding:15px 0;width: 70px; ">Title:'+i+'</td><td><div class="md-input-wrapper"><input type="text" class="md-input " id="name" name="toc[]" required onkeyup="func()"><span class="md-input-bar " ></span></div></td></tr>');
                    
            }
    }
    function selfiles(){
            $('#sel').css('display','block');
            $('#sel1').css('display','block');
    }

    function sendid(id){

        $.ajax({
               type:'GET',
               url:'/getfiles',
               data:{"_token": "{{ csrf_token() }}",
                        "id": id},
               success:function(response){
                console.log(response);
                  $("."+id).html(response);
               }
            });
    }

    function sendsubid(id,elm){

        $.ajax({
               type:'GET',
               url:'/getsubfiles',
               data:{"_token": "{{ csrf_token() }}",
                        "id": id},
               success:function(response){
                console.log(response);
                  $(".sub"+id).html(response);
               }
            });
        // alert($(elm).attr('id'));
        if($(elm).attr('id')=='collapsed'){
            $(elm).attr('id','open');
            $('#'+id).css('display','block');


        }else if($(elm).attr('id')=='open'){
             $(elm).attr('id','collapsed');
            $('#'+id).css('display','none');


        }
    }

    function archive(id,elm){

        $.ajax({
               type:'GET',
               url:'/file_archive',
               data:{"_token": "{{ csrf_token() }}",
                        "id": id},
               success:function(response){
                  console.log(response);
                  elm.closest('li').remove();
               }
            });
    }
     function archivefromDir(id,elm){
            
        $.ajax({
               type:'GET',
               url:'/file_archive_dir',
               data:{"_token": "{{ csrf_token() }}",
                        "id": id},
               success:function(response){
                  console.log(response);
                  elm.closest('li').remove();
               }
            });
    }
 // function getfiles() {
            
 //          var input = document.getElementById('upload');
 //          var output = document.getElementById('selected-files');
          
         
 //          for (var i = 1; i <= input.files.length; i++) {
 //            $('#selected-files').append('<li><div class="md-list-addon-element"><span>'+i+'</span></div><div class="md-list-content "><span class="md-list-heading">'+$(this).find('a').eq(0).html()+'</span><input value="'+$(this).find('a').eq(0).html()+'" name="ssf[]" type="hidden"  ></div></li>');
 //          }
         
          

 //         // append the file list to an array
 //         Array.prototype.push.apply( fileBuffer, input.files );
 //    }
var count=0;
var old_no=0;
    function func(){

        var input = document.getElementById('upload');
        // alert(input.files.length);
        $('#selected').html(null);
        // $('#toc').html(null);
        $('#selected-2').html(null);
        $('#selected-files').html(null);
        var j=1;
        $('.uk-nestable-panel').each(function(){
            if($(this).find('input').is(':checked')) {
                // alert($(this).find('a').eq(0).html());
                $('#selected').append('<option value="'+$(this).find('a').eq(0).html()+'">'+$(this).find('a').eq(0).html()+'</option>');
                $('#selected-2').append('<option value="'+$(this).find('a').eq(0).html()+'">'+$(this).find('a').eq(0).html()+'</option>');
                $('#selected-files').append('<li><div class="md-list-addon-element"><span>'+j+'</span></div><div class="md-list-content " style="float:left"><span class="md-list-heading">'+$(this).find('a').eq(0).html()+'-- P:<input type="checkbox" name="ff[]" value="'+$(this).find('a').eq(0).html()+'"> L:<input type="checkbox" name="zz[]" value="'+$(this).find('a').eq(0).html()+'"></span><input value="'+$(this).find('a').eq(0).html()+'" name="ssf[]" type="hidden"  ></div style="float:right"><div></div></li>');
                
          
                //console.log('<option>'+$(this).find('a').eq(0).html()+'</option>');
          count=j;
          j++;
          
            }

        });
        // alert(count);
          for (var i = 0; i < input.files.length; i++) {
            $('#selected-files').append('<li><div class="md-list-addon-element"><span>'+j+'</span></div><div class="md-list-content "><span class="md-list-heading">W:<input type="checkbox" name="ff[]" value="'+input.files.item(i).name+'"> L:<input type="checkbox" name="zz[]" value="'+input.files.item(i).name+'"><br>'+input.files.item(i).name+'</span><input value="'+input.files.item(i).name+'" name="ssf[]" type="hidden"  ></div></li>');
            $('#selected').append('<option value="'+input.files.item(i).name+'">'+input.files.item(i).name+'</option>');
            j++;
          }

          var k=1;
           $('#toc input').each(function(){

                $('#selected-files').append('<li><div class="md-list-addon-element"><span style="font-weight:bold">sep</span></div><div class="md-list-content "><span class="md-list-heading" style="font-weight:bold;">'+$(this).val()+'</span><input value="separator'+k+'.pdf" name="ssf[]" type="hidden"  ></div></li>');

                k++;
            });
    //         $('#toc').html(null);
    // if(no!=undefined){
    //     old_no=no;
    // }
    //    if(no==undefined){
    //         no = old_no;
    //    }
        // alert(no);
            // for(var i=1;i<=no;i++){
            //         $('#toc').append(' <tr id="toc'+i+'"><td style="padding:15px 0;width: 70px; ">Title:'+i+'</td><td><div class="md-input-wrapper"><input type="text" class="md-input " id="name" name="toc[]" required ><span class="md-input-bar " ></span></div></td></tr>');
            //         $('#selected-files').append('<li id="s'+i+'"><div class="md-list-addon-element"><span>Sep'+i+'</span></div><div class="md-list-content "><span class="md-list-heading">S'+i+'</span><input value="separator'+i+'.pdf" name="ssf[]" type="hidden"  ></div></li>');
            // }



        // $('.uk-nestable-panel').each(function(){
        //     if($(this).find('input').is(':checked')) {
        //         // alert($(this).find('a').eq(0).html());
        //         $('#selected-files').append('<li><div class="md-list-addon-element"><img class="md-user-image md-list-addon-avatar" src="/public_assets/assets/img/files.jpg" alt=""/></div><div class="md-list-content "><span class="md-list-heading">'+$(this).find('a').eq(0).html()+'</span><input value="'+$(this).find('a').eq(0).html()+'" name="ssf[]" type="hidden"  ></div></li>');
        //         //console.log('<option>'+$(this).find('a').eq(0).html()+'</option>');
                
        //     }

        // });

// <li>
//                                     <div class="md-list-addon-element">
//                                         <span>'+i+'</span>
//                                     </div>
//                                     <div class="md-list-content">
//                                         <span class="md-list-heading">First File</span>
//                                         <input value="'+$(this).find('a').eq(0).html()+'"> name="sf[]" readonly>
//                                     </div>
//                                 </li>


        
        
        
    }


    {{--function storeDirectory() {--}}
        {{--$.ajax({--}}
            {{--url:"/directory/new",--}}
            {{--type:"post",--}}
            {{--data:{_token: '{{csrf_token()}}', name:$("#name").val()},--}}
            {{--complete:function (e) {console.log(e);selectDirectory();}--}}
        {{--});--}}

    {{--}--}}


    {{--function selectDirectory() {--}}
        {{--$.ajax({--}}
            {{--url:"/directory/select",--}}
            {{--type:"get",--}}
        {{--complete:function (e) {--}}
        {{--console.log(e);--}}
        {{--var json = JSON.parse(e.responseText);--}}
        {{--$.each(json,function (a,b) {--}}
            {{--$("#list").append('' +--}}
                {{--'<tr>' +--}}
                {{--'<td>'+b["id"]+'</td>' +--}}
                {{--'<td>'+b["name"]+'</td>' +--}}
                {{--'<td></td>' +--}}
                {{--'</tr>');--}}

            {{--console.log();--}}

        {{--})--}}

            {{--}--}}
        {{--});--}}

    {{--}--}}

</script>

<script type="text/javascript">
    $(document).ready(function() {
       

        $('#cc').click(function(){
            if($(this).prop("checked") == true){
                // $('#format').css('display','block');
                // $('#format2').css('display','block');
                $('#email').css('display','block');
                // $('#from').css('display','block');
                // $('#subject').css('display','block');
            }else if($(this).prop("checked") == false){
                 // $('#format').css('display','none');
                // $('#format2').css('display','none');
                $('#email').css('display','none');
                // $('#from').css('display','none');
                // $('#subject').css('display','none');
            }
        })
    });
</script>
@endsection


@section('scripts')
<script src="/public_assets/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/public_assets/bower_components/datatables-buttons/js/dataTables.buttons.js"></script>
<script src="/public_assets/assets/js/custom/datatables/buttons.uikit.js"></script>
<script src="/public_assets/bower_components/jszip/dist/jszip.min.js"></script>
<script src="/public_assets/bower_components/pdfmake/build/pdfmake.min.js"></script>
<script src="/public_assets/bower_components/pdfmake/build/vfs_fonts.js"></script>
<script src="/public_assets/bower_components/datatables-buttons/js/buttons.colVis.js"></script>
<script src="/public_assets/bower_components/datatables-buttons/js/buttons.html5.js"></script>
<script src="/public_assets/bower_components/datatables-buttons/js/buttons.print.js"></script>
<script src="/public_assets/assets/js/custom/datatables/datatables.uikit.min.js"></script>
<script src="/public_assets/assets/js/pages/plugins_datatables.min.js"></script>

<script>
    function destroy(id,name) {
        var r = confirm("Delete " + name);
        if (r == true) {
            window.location="/directory/delete/"+id;
        }
    }
</script>

@endsection
