@extends('com.layout')

@section('body')


    <div class=" " style="background: rgba(000,000,000,0)">
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
        <div class="md-card-content">
            <div class="uk-grid uk-grid-width-small-1-3 uk-grid-width-large-1-6 uk-grid-width-xlarge-1-10 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable="" data-uk-grid-margin="">
                
                @foreach($getfiles as $i)
                    <?php $file=json_decode($i->name); ?>
                    @foreach($file as $o)
                    <div>
                        <div class="md-card md-card-hover " style="background: rgba(255,255,255,0.2)"  data-uk-tooltip="{pos:'top'}" title="Click here to download">
                            <div class=" uk-flex uk-flex-center uk-flex-middle">
                                <a href="/download/{{$o}}" target="_blank"><img src="/public_assets/assets/img/doc.png"  /></a>
                            </div>
                        
                            <p style="overflow: hidden;">
                                    {{$o}}
                            </p>
                        </div> 

                        <button class="uk-button uk-button-danger" type="button" onclick="destroy({{$i->id}})">Delete
                        </button>
                     </div>   
                        @endforeach
                        

                                
                                
                   
                    
                @endforeach
                
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
    function destroy(id) {
        
             window.location="/file/delete/"+id;
        
    }
</script>

@endsection
