@extends('com.layout')
@section('title')
{{Session::get('workstation_name')}}

@endsection
@section('body')


    {{-- expr --}}

    <div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-5 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable="" data-uk-grid-margin="">
        @if ($name=='archives')
                <div >
                    <div class="md-card md-card-hover md-card-overlay" style="background-color:orange!important;">
                        <div class="md-card-content">
                           <a href="/archived_merged_files"><h3 style="    padding: 35px;font-size: 32px;line-height: 42px;">Archives Profiles</h3></a>
                        </div>
                        
                    </div>
                </div>
                 <div >
                    <div class="md-card md-card-hover md-card-overlay" style="background-color:orange!important;">
                        <div class="md-card-content">
                           <a href="/archive"><h3 style="    padding: 35px;font-size: 32px;line-height: 42px;">Archives Files</h3></a>
                        </div>
                        
                    </div>
                </div>
               

        @endif 
        @if ( $name=='directories')
                 <div >
                    <div class="md-card md-card-hover md-card-overlay" style="background-color:orange!important;">
                        <div class="md-card-content">
                           <a href="/directory/all"><h3 style="    padding: 35px;font-size: 32px;line-height: 42px;">Main Directories</h3></a>
                        </div>
                        
                    </div>
                </div>
                 <div >
                    <div class="md-card md-card-hover md-card-overlay" style="background-color:orange!important;">
                        <div class="md-card-content">
                           <a href="/subdirectory/all"><h3 style="    padding: 35px;font-size: 32px;line-height: 42px;">Sub Directories</h3></a>
                        </div>
                        
                    </div>
                </div>
               
               @endif       
            </div>

                  
                    


                          {{--   <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                                <button style="   width: 120%;
    height: 120px;
    background-color: orange;
    color: white;
    font-size: 25px;">Directories<i class="material-icons">&#xE313;</i></button>
                                <div class="uk-dropdown">
                                    <ul class="uk-nav uk-nav-dropdown">
                                        <li><a href="#">Main Directories</a></li>
                                        <li><a href="#">Sub Directories</a></li>
                                       
                                    </ul>
                                </div>
                            </div> --}}
                        

            {{-- <div class="uk-grid uk-grid-width-small-1-3 uk-grid-width-large-1-6 uk-grid-width-xlarge-1-10 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable="" data-uk-grid-margin=""> --}}
                   {{--  <div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-4 uk-text-center " id="dashboard_sortable_cards" data-uk-grid-margin>
                
                 <a href="directory/all">
            <img src="/public_assets/assets/img/directories.jpg" style="width: 600px;height:150px;" />
            <div style="font-size: 19px;text-align: center;background-color:#673ab7;color: white;font-weight: bold;">Directories</div>
        </a>
         <a href="/workstation/all" >
                    <img src="/public_assets/assets/img/company.jpg"  style="width: 600px;height:150px;"/>
            <div style="font-size: 19px;text-align: center;background-color:#673ab7;color: white;font-weight: bold;">All Companies</div>
                </a>
                <a href="/file/directories" >
                    <img src="/public_assets/assets/img/files.jpg"  style="width: 600px;height:150px;"/>
            <div style="font-size: 19px;text-align: center;background-color:#673ab7;color: white;font-weight: bold;">Files</div>
                </a>
                <a href="/archive" >
                    <img src="/public_assets/assets/img/files.jpg"  style="width: 600px;height:150px;"/>
            <div style="font-size: 19px;text-align: center;background-color:#673ab7;color: white;font-weight: bold;">Archive Files</div>
                </a>
                <a href="/merged_files" >
                    <img src="/public_assets/assets/img/files.jpg"  style="width: 600px;height:150px;"/>
            <div style="font-size: 19px;text-align: center;background-color:#673ab7;color: white;font-weight: bold;">Merged Files</div>
                </a>
                <a href="/directory/new" >
                    <img src="/public_assets/assets/img/plus.jpg"  style="width: 600px;height:150px;"/>
            <div style="font-size: 19px;text-align: center;background-color:#673ab7;color: white;font-weight: bold;">Add Directory</div>
                </a>
                <a href="/file/new" >
                    <img src="/public_assets/assets/img/plus.jpg"  style="width: 600px;height:150px;"/>
            <div style="font-size: 19px;text-align: center;background-color:#673ab7;color: white;font-weight: bold;">Add New File</div>
                </a>
                 <a href="/workstation/new" >
                    <img src="/public_assets/assets/img/plus.jpg"  style="width: 600px;height:150px;"/>
            <div style="font-size: 19px;text-align: center;background-color:#673ab7;color: white;font-weight: bold;">Add New Company</div>
                </a>
            </div>

            </div> --}}

          

@endsection