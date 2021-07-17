@extends('com.layout')
@section('title')
Archive Files
@endsection
@section('body')

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
     <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">
                    
                    @foreach($table as $directory)
                    <ul class="uk-nestable" data-uk-nestable>
                        
                            {{csrf_field()}}
                        <li class="uk-nestable-item uk-parent uk-collapsed">
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" data-nestable-action="toggle" onclick="sendid({{$directory->id}})"></div>
                                    {{$directory->name}}<span style="float: right">Files: {{App\Names::where('directory_id','=',$directory->id)->where('status','=',1)->count()}}</span>
                            </div>
                            <ul class="{{$directory->id}}">
                                
                            </ul>
                        </li>
                        
                        
                    </ul>
                    @endforeach
                    
                </div>
            </div>
    </div>




<script>

  function sendsubid(id,elm){

        $.ajax({
               type:'GET',
               url:'/getsubfilesarchive',
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
               url:'/getarchivefiles',
               data:{"_token": "{{ csrf_token() }}",
                        "id": id},
               success:function(response){
                  $("."+id).html(response);
               }
            });
    }


    // 

     function moveback(id,elm){

        $.ajax({
               type:'GET',
               url:'/file_back',
               data:{"id": id},
               success:function(response){
                  console.log(response);
                  elm.closest('li').remove();
               }
            });
    }

function per(id,elm){
   
        $.ajax({
               type:'GET',
               url:'/file_delete',
               data:{"id": id},
               success:function(response){
                  console.log(response);
                  elm.closest('li').remove();
               }
            });
    }

    function movebackdir(id,elm){

        $.ajax({
               type:'GET',
               url:'/file_back_dir',
               data:{"id": id},
               success:function(response){
                  console.log(response);
                  elm.closest('li').remove();
               }
            });
    }

function perdir(id,elm){
   
        $.ajax({
               type:'GET',
               url:'/file_delete_dir',
               data:{"id": id},
               success:function(response){
                  console.log(response);
                  elm.closest('li').remove();
               }
            });
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
