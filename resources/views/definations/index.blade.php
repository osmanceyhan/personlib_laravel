@extends('layouts.master')
@section('title') Sistem Tanımları @endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') Tanımlar @endslot
        @slot('title') Tanımlar @endslot
    @endcomponent
    <div class="row-container">
        <div class="row">
            @foreach($definations as $result)
                <div class="col-md-6 col-xl-3" >
                    <div class="card card_gradient card_stats" style="height:calc(100% - 1.25rem);">
                        <div class="card-body">
                            <div>
                                <div class="card_header">
                                    <p class="text-muted mb-0">{{$result['title']}}</p>
                                    <div class="card_stats_dropdown">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 hover:opacity-80">
                                            <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                            <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                            <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card_value d-flex justify-content-between align-items-center">
                                    <h4 class="mb-1 mt-1 "><span data-plugin="counterup">{{$result["count"]}}</span></h4>
                                    <a href="{{$result['route']}}" class="btn btn-sm bg-white text-black">İncele</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col-->
            @endforeach
        </div>

    </div>

    <!-- end row -->

@endsection
@section('script')
    <!-- apexcharts -->



@endsection
