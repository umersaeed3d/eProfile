@extends('com.layout')

@section('body')


    <div class=" " style="background: rgba(000,000,000,0)">

        <div class="md-card-content">
            <div class="uk-grid uk-grid-width-small-1-3 uk-grid-width-large-1-6 uk-grid-width-xlarge-1-10 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable="" data-uk-grid-margin="">
                @foreach($table as $i)
                <a href="/file/{{Request::segment(2)}}/{{$i->year}}">
                    <div class="md-card md-card-hover " style="background: rgba(255,255,255,0.2)"  data-uk-tooltip="{pos:'top'}" title="{{$i->name}}">
                        <div class=" uk-flex uk-flex-center uk-flex-middle">
                            <img src="/public_assets/assets/img/folder.png"  />
                        </div>
                        <div class="">
                                <p>
                                    {{$i->year}}
                                </p>
                            </div>
                    </div>
                </a>
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
    function destroy(id,name) {
        var r = confirm("Delete " + name);
        if (r == true) {
            window.location="/directory/delete/"+id;
        }
    }
</script>

@endsection
