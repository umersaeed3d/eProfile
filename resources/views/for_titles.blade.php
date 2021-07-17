@extends('com.layout')
@section('title')
Give Titles
@endsection
@section('body')


    <div class="md-card">
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
                                <form method="post" action="/title"  class="uk-form-stacked">
                                    {{csrf_field()}}
                                    <div class="uk-grid" data-uk-grid-margin="">
                                        
                                         <div class="uk-margin">
                                            <label class="uk-form-label" for="form-stacked-text">Title:</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input" for="form-stacked-text" type="text" name="title" placeholder="Write Title" required>
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-1">
                                            <select  data-md-selectize name="names">
                                                <option value="">Select File...</option>
                                                @foreach($files as $i)
                                                    <option value="{{$i->id}}">{{$i->names}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        {{-- <div class="uk-width-medium-1-1">
                                            <select data-md-selectize name="year">
                                                <option value="">Select Year...</option>
                                                @for($i=intval(now()->year)-100;$i < intval(now()->year);$i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div> --}}
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

    </div>

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
    <script type="text/javascript">

//         $('#my_id').change(function(){
//             alert();
//     var files = $(this).files;

//     if(files.length > 10){
//         alert("you can select max 10 files.");
//     }else{
//         alert("correct, you have selected less than 10 files");
//     }
// });
    
    </script>
@endsection