@extends('com.layout')
@section('title')
Companies
@endsection
@section('body')

 
 <div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-5 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable data-uk-grid-margin>
@if(isset($table))     
@foreach($table as $i)
        <a href="/dashboard/{{$i->id}}/{{$i->name}}">
            <div class="md-card md-card-hover md-card-overlay">
                <div class="md-card-content">
                    <div class="epc_chart" data-percent="100" data-bar-color="#03a9f4">
                        <img src="{{ url('/uploads/files/workstation') }}/{{$i->image}}">{{-- <span class="epc_chart_icon"><i class="material-icons">business</i></span> --}}
                    </div>
                </div>
                <div class="md-card-overlay-content">
                    <div class="uk-clearfix md-card-overlay-header">
                        <h3 style="padding: 0 !important;text-align: center">
                            {{$i->name}}
                        </h3>
                    </div>
                </div>
            </div>
        </a>
@endforeach
@endif
@if(isset($tables))
@foreach($tables as $i)
        <a href="/dashboard/{{$i->workstation_id}}/{{$i->name}}">
            <div class="md-card md-card-hover md-card-overlay">
                <div class="md-card-content">
                    <div class="epc_chart" data-percent="100" data-bar-color="#03a9f4">
                        <img src="{{ url('/uploads/files/workstation') }}/{{$i->image}}">{{-- <span class="epc_chart_icon"><i class="material-icons">business</i></span> --}}
                    </div>
                </div>
                <div class="md-card-overlay-content">
                    <div class="uk-clearfix md-card-overlay-header">
                        <h3 style="padding: 0 !important;text-align: center">
                            {{$i->name}}
                        </h3>
                    </div>
                </div>
            </div>
        </a>
@endforeach
@endif
    </div>

     {{-- <div class=" " style="background: rgba(000,000,000,0)">

        <div class="md-card-content">
            <div class="uk-grid uk-grid-width-small-1-3 uk-grid-width-large-1-6 uk-grid-width-xlarge-1-10 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable="" data-uk-grid-margin="">
                @foreach($table as $i)
                <a href="/dashboard/{{$i->id}}" >
                    <div class="md-card md-card-hover " style="background: rgba(255,255,255,0.2)"  data-uk-tooltip="{pos:'top'}" title="{{$i->name}}">
                        <div class=" uk-flex uk-flex-center uk-flex-middle">
                            <img src="/public_assets/assets/img/folder.png"  />
                        </div>
                        <div class="">
                                <p>
                                    {{$i->name}}
                                </p>
                            </div>
                    </div>
                </a>
                @endforeach
            </div>

            </div>

          </div> --}}
    </div>
     
@endsection