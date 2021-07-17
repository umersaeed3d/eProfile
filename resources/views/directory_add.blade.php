@extends('com.layout')
@section('title')
Add Sub-Directory
@endsection
@section('body')


    <div class="md-card ">

        <div class="md-card-content">

            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-6-10 uk-push-2-10 uk-row-first">
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

                    <h3 class="heading_a">Directories</h3>
                    <form action="/directory/new" method="post">
                        {{csrf_field()}}
                        <div class="uk-grid">
                            <div class="uk-width-large-1-1 uk-width-medium-1-2">
                                <div class="uk-input-group">
                                    <div class="md-input-wrapper">
                                        <input type="text" class="md-input" id="name"  name="name" placeholder="Directory Name"><span class="md-input-bar "></span>
                                    </div>

                                   
                                   
                                    <span class="uk-input-group-addon"><button class="md-btn md-btn-primary" type="submit" >ADD</button></span>
                                </div>
                            </div>
                        </div>
                    </form>
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

@endsection
