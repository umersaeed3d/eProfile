@extends('com.layout')
@section('title')
Edit User 
@endsection
@section('body')


    <div class="md-card ">

        <div class="md-card-content">

            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-6-10 uk-push-2-10 uk-row-first">


                        <div class="uk-grid" data-uk-grid-margin="">
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
                            <div class="uk-width-medium-1-1 uk-row-first">
                                <div class="uk-form-row">
                                    <form method="post" action="/user/update" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                    <div class="uk-grid" data-uk-grid-margin="">
                                        <div class="uk-width-medium-1-1">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label>User ID</label>
                                                <input type="text" class="md-input " value="{{$id}}" readonly name="id">
                                                <span class="md-input-bar "></span>
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-1">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label>User Name</label>
                                                <input type="text" class="md-input " value="{{$name}}" name="name">
                                                <span class="md-input-bar "></span>
                                            </div>
                                        </div>
                                         <div class="uk-width-medium-1-1">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label>User Password</label>
                                                <input type="text" class="md-input "  name="pass" placeholder="leave blank if do not want to change">
                                                <span class="md-input-bar "></span>
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-1">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label>Email</label>
                                                <input type="text" class="md-input " value="{{$email}}" name="email">
                                                <span class="md-input-bar "></span>
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-1">
                                            <div class="md-input-wrapper md-input-filled">
                                                
                                                <input type="file" class="md-input " name="file">
                                                <span class="md-input-bar "></span>
                                            </div>
                                        </div>
                                       
                                        </div>
                                        <div class="uk-width-medium-1-1">
                                            <button type="submit" class="md-btn md-btn-primary ">SAVE</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>

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

@endsection
