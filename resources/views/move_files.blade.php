@extends('com.layout')
@section('title')
Add File
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
                            @if(session()->has('error'))
                                
                                    <div class="uk-alert uk-alert-danger" data-uk-alert="">
                                        <a href="#" class="uk-alert-close uk-close"></a>
                                        {{session()->get('error')}}
                                    </div>
                                
                            @endif
                        </div>
                        <div class="uk-width-medium-1-1 uk-row-first">
                            <div class="uk-form-row">
                                <form  action="/file/new" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="uk-grid" data-uk-grid-margin="">
                                        <div class="uk-width-medium-1-1">
                                            <div class="uk-form-file md-btn md-btn-primary">
                                                Select
                                                <input  class="ff file" id="file" type="file" name="file[]"  onchange="getfiles()" multiple >
                                            </div>
                                            You can also upload multiple files
                                        </div>
                                         <div class="uk-width-medium-1-1 inp">
                                           
                                        </div>
                                        <div class="uk-width-medium-1-1">
                                            <select  data-md-selectize name="directory" onchange="getsubdirectories($(this).val())" required="">
                                                <option value="">Select Directory...</option>
                                                @foreach($table as $i)
                                                    <option value="{{$i->id}}">{{$i->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="uk-form-controls">
                                            <select name="sub_directory" class="sub" required="">
                                               <option value="">Select Sub-Directory</option> 
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
                                        <div id="cc"></div>
                                        <div class="uk-width-medium-1-1" >
                                            {{-- <input type="hidden" name="check[]" value="" id="cc"> --}}
                                            <button type="submit" class="md-btn md-btn-primary " onclick='put()'>SAVE</button>
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

            
                <div class="md-card ">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-6-10 uk-push-2-10 uk-row-first" >
                        
                        <div class="uk-width-1-1" >
                            <table class="uk-table uk-table-border">
                                <thead>
                                    <th>Selected Files</th>
                                    <th>Action</th>
                                </thead>
                                <tbody >

                                </tbody>
                            </table>
                            
                        </div>
                
            </div>
        </div>
    </div>
</div>

       

@endsection
<script type="text/javascript">
    var fileBuffer=[];
    
    function getsubdirectories(id){
        $.ajax({
            type:'GET',
            url:'/getsubdir',
            data:{'id':id},
            success:function(response){
                console.log(response);
                $('.sub').append(response);
            }
        });
    }
    function getfiles() {
            
          var input = document.getElementById('file');
          var output = document.getElementById('fileList');
          
          output.innerHTML='';
          for (var i = 0; i < input.files.length; i++) {
            output.innerHTML += '<tr><td>' + input.files.item(i).name + '</td><td><button  class="uk-button uk-button-danger" onclick="removeElement($(this),'+i+')">Delete</button></td></tr>';
          }
         
          

         // append the file list to an array
         Array.prototype.push.apply( fileBuffer, input.files );
    }

    function removeElement(elm,index){
        
        fileBuffer.splice(index,1);
        elm.closest('tr').remove();
        $('#cc').val();



         console.log(fileBuffer);
  
    }

    function put(){

        // alert(fileBuffer.length);
        var k=0;
        while(k<fileBuffer.length){
           
            $('#cc').append('<li> <input type="hidden" name="check[]" value="'+fileBuffer[k].name+'" ></li>');
            k++;
        }

    }

    
</script>
<script type="text/javascript">
    
</script>
<script type="text/javascript">
    
    
</script>

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
    
@endsection