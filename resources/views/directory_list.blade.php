@extends('com.layout')
@section('title')
All Sub-Directories
@endsection
@section('body')


    <div class="md-card ">

        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-6-10 uk-push-2-10 uk-row-first">
                    <div class="uk-width-medium-1-1 uk-row-first">
                        @if(session()->has('done'))
                            <div class="alert alert-success">
                                <div class="uk-alert uk-alert-success" data-uk-alert="">
                                    <a href="#" class="uk-alert-close uk-close"></a>
                                    {{ session()->get('done') }}
                                </div>
                            </div>
                        @endif

                        @if(count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="uk-alert uk-alert-danger" data-uk-alert="">
                                    <a href="#" class="uk-alert-close uk-close"></a>
                                    {{$error}}
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-large-1-1 uk-width-medium-1-2">
                             <form method="POST" action="/main_dir_sequence">

                                    <?php $j=1; ?>
                                
                                    <ul class="md-list md-list-addon uk-sortable sortable-handler" data-uk-sortable="{group:'connected-group'}" id="selected-files">
                                        @foreach($table as $i)
                                        <li>
                                            <div class="md-list-addon-element">
                                                <span>{{$j}}</span>
                                                {{-- <img class="md-user-image md-list-addon-avatar" src="/public_assets/assets/img/files.jpg" style="width:20px; height:20px;" alt=""/> --}}
                                            </div>
                                            <div class="md-list-content ">
                                                <input type="hidden" name="id[]" value="{{$i->id}}">
                                                {{-- <input type="hidden" name="index[]" value="{{$j}}"> --}}
                                               {{$i->name}} 
                                               <div style="float: right">    
                                                    <a href="/directory/edit/{{$i->id}}"  class=" md-btn-icon"><i class="material-icons no_margin">edit</i></a>
                                                    <a href="javascript:;" onclick="destroy('{{$i->id}}',$(this))" style="" class=" md-btn-icon"><i class="material-icons no_margin">close</i></a>
                                                 </div>                                           
                                            </div>
                                        </li>
                                        {{-- <td>{{$j}}</td>
                                        <td>{{$i->name}}</td>
                                        <td>
                                           
                                        </td>
                                    </tr> --}}
                                    <?php $j++; ?>
                                @endforeach
                            </ul>
                            {{csrf_field()}}
                            <button type="submit" class="uk-button uk-button-success">Change Sequence</button>
                            </form>   
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<script>


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
    function destroy(id,elm) {
        $.ajax({
               type:'GET',
               url:'/directory_delete',
               data:{"_token": "{{ csrf_token() }}",
                        "id": id},
               success:function(response){
                  console.log(response);
                  elm.closest('li').remove();
               }
            });
    }
</script>

@endsection
 