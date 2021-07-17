@extends('com.layout')
@section('title')
Add User
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

                    <h3 class="heading_a">New User</h3>
                    <form action="/user/new" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                         <table style="width: 50%">

                                <tbody>

                                <tr>
                                    <td style="padding:15px 0;width: 70px; ">Name</td>
                                    <td>
                                        <div class="md-input-wrapper"><input type="text" class="md-input " id="name" name="name" required><span class="md-input-bar " ></span></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:15px 0;width: 70px; ">Email</td>
                                    <td>
                                        <div class="md-input-wrapper"><input type="email" class="md-input "  name="email" required><span class="md-input-bar "></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 0;width: 70px; ">Password</td>
                                    <td>
                                        <div class="md-input-wrapper"><input type="password" class="md-input "  name="password" required><span class="md-input-bar "></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 0;width: 70px; ">Workstation</td>
                                    <td>
                                        <div class="md-input-wrapper">
                                            <div class="uk-width-medium-1-1">
                                            <select  data-md-selectize name="workstation[]" multiple required>
                                                <option value="">Select Workstations...</option>
                                                @foreach($table as $i)
                                                    <option value="{{$i->id}},{{$i->name}}">{{$i->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 0;width: 70px; ">Image</td>
                                    <td>
                                        <div class="md-input-wrapper"><input type="file" class="md-input "  name="file" required><span class="md-input-bar "></span></div>
                                    </td>
                                </tr>
                                <br>
                                <tr>
                                    <td style="padding:15px 0;width: 70px; "></td>
                                    <td>
                                         <button type="submit" class="md-btn md-btn-flat" >Add</button>
                                    </td>
                                </tr>



                            </tbody></table>
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
