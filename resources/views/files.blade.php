@extends('com.layout')
@section('title')
Files Details
@endsection
@section('body')
 

<form action="/copy_file" method='POST' id="form">
    
     <div class="uk-modal" id="modal_copy">
                                <div class="uk-modal-dialog">
                                    <div class="uk-modal-header">
                                        <h3 class="uk-modal-title">Copy Files <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">&#xE8FD;</i></h3>
                                    </div>
                                   
                                        <table style="width: 50%">

                                <tbody>
                                    <tr>
                                    <td style="padding:15px 0;width: 70px; ">Select Directory</td>
                                    <td>
                                        <div class="md-input-wrapper"><div class="uk-width-medium-1-1">
                                            <select name="directory" onchange="getsubdirectories($(this).val())" required="">
                                                <option value="">Select MainDirectory</option>
                                            @foreach($table as $i)

                                                    <option value="{{$i->id}}">{{$i->name}}</option>
                                                @endforeach
                                                </select>
                                        </div></div>
                                    </td>
                                </tr>

                              {{--  <tr>
                                    <td style="padding:15px 0;width: 70px; ">Select Subdirectory</td>
                                    <td>
                                        <div class="md-input-wrapper"><div class="uk-width-medium-1-1">
                                           <select name="sub_directory" class="sub" required="">
                                               <option value="">Select Subdirectory</option>
                                           </select>
                                        </div></div>
                                    </td>
                                </tr>
 --}}
                               


                            </tbody></table>
                                    
                                    <div class="uk-modal-footer uk-text-right">
                                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                        <button type="submit" class="md-btn md-btn-flat" onclick="changeAttr()">Done</button>
                                    </div>
                                    
                                </div>
                            </div>
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
                <div class="uk-width-1-1 ">
                     
                                        {{csrf_field()}}
                    
                    @foreach($table as $directory)
                    <ul class="uk-nestable" data-uk-nestable>
                        
                            
                        <li class="uk-nestable-item uk-parent uk-collapsed">
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" data-nestable-action="toggle" onclick="sendid({{$directory->id}})"></div>
                                    {{$directory->name}}<span style="float: right">Files: {{App\Names::where('directory_id','=',$directory->id)->where('status','=',0)->count()}}</span>
                            </div>
                            <ul class="{{$directory->id}}">
                                
                            </ul>
                        </li>
                        
                        
                    </ul>
                    @endforeach
                                      
                    
                    {{-- <button type="submit" class="uk-button-primary">Merge!</button> --}}
                   {{-- <button class="md-btn" data-uk-modal="{target:'#modal_header_footer'}">Merge</button> --}}
                    {{-- <a href="#modal-example" uk-toggle>Open</a>  --}}

                        
                
                 
           {{--      
            </div>
        </div>
    </div>
</div> --}}
            
            <button type="button" class="md-btn" data-uk-modal="{target:'#modal_move'}">Move</button>
            <button type="button" class="md-btn" data-uk-modal="{target:'#modal_copy'}">Copy</button>
</div>
    </div>
     
                            
    </form>

    <div class="uk-modal" id="modal_move">
        
        
                                <div class="uk-modal-dialog">
                                    <div class="uk-modal-header">
                                        <h3 class="uk-modal-title">Move Files <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">&#xE8FD;</i></h3>
                                    </div>
                                  <form method="POST" action="/move_file">
                                    {{ csrf_field() }}
                                        <table style="width: 50%">

                                <tbody>
                                    <tr>
                                    <td style="padding:15px 0;width: 70px; ">Select Directory</td>
                                    <td>
                                        <div class="md-input-wrapper"><div class="uk-width-medium-1-1">
                                            <select name="directory" onchange="getsubdirectories($(this).val())" required="">
                                                <option value="">Select MainDirectory</option>
                                            @foreach($table as $i)

                                                    <option value="{{$i->id}}">{{$i->name}}</option>
                                                @endforeach
                                                </select>
                                        </div></div>
                                    </td>
                                </tr>
                                <div id="selected"></div>

                              {{--  <tr>
                                    <td style="padding:15px 0;width: 70px; ">Select Subdirectory</td>
                                    <td>
                                        <div class="md-input-wrapper"><div class="uk-width-medium-1-1">
                                           <select name="sub_directory" class="sub" required="">
                                               <option value="">Select Subdirectory</option>
                                           </select>
                                        </div></div>
                                    </td>
                                </tr> --}}

                               


                            </tbody></table>
                                    
                                    <div class="uk-modal-footer uk-text-right">
                                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                        <button type="submit" class="md-btn md-btn-flat" >Done</button>
                                    </div>
                                   </form> 
                                </div>
                            </div>
    
                           



<!-- This is an anchor toggling the modal -->
{{-- <a href="#modal-example" uk-toggle>Open</a> --}}

<!-- This is the modal -->



<script>
    function func(){
       // $('#selected').html(null);
        //$('#selected-files').html(null);

        $('.uk-nestable-panel').each(function(){
            if($(this).find('input').is(':checked')) {
                // alert($(this).find('a').eq(0).html());
                $('#selected').append('<input value="'+$(this).find('input').val()+'" type="hidden" name="checked[]">');
                
                //console.log('<option>'+$(this).find('a').eq(0).html()+'</option>');
            }

        });
    }

    function changeAttr(){
        
        $('#form').attr('action','/copy_file');
    }

     function getsubdirectories(id){
        $.ajax({
            type:'GET',
            url:'/getsubdir',
            data:{'id':id},
            success:function(response){
                console.log(response);
                $('.sub').html(response);
            }
        });
    }
    function sendsubid(id,elm){
        

        $.ajax({
               type:'GET',
               url:'/getsubfilesall',
               data:{"_token": "{{ csrf_token() }}",
                        "id": id},
               success:function(response){
                console.log(response);
                  $(".sub"+id).html(response);
               }
            });

         if($(elm).attr('id')=='collapsed'){
            $(elm).attr('id','open');
            $('#'+id).css('display','block');


        }else if($(elm).attr('id')=='open'){
             $(elm).attr('id','collapsed');
            $('#'+id).css('display','none');


        }
    }
    function sendid(id){
        $.ajax({
               type:'GET',
               url:'/allfiles',
               data:{"_token": "{{ csrf_token() }}",
                        "id": id},
               success:function(response){
                console.log(response);
                  $("."+id).html(response);
               }
            });
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
