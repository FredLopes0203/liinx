@extends('backend.layouts.app')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("css/tilelist.css") }}
    {{ Html::style("js/slick/slick.css") }}
    {{ Html::style("js/slick/slick-theme.css") }}
@endsection

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Dashboard</small>
    </h1>
@endsection

@section('content')
        <div class="box-body">
            @foreach($tileInfos as $tileInfo)
                <div class="tilediv">
                    <div class="box box-widget box-solid">
                        <div class="box-header with-border">
                            <h2 class="box-title"><b>{{$tileInfo->name}}</b></h2>

                            <span class="badge" style="margin-left: 5px; margin-top: -4px; background-color: #00a65a">3</span>
                            <div class="box-tools pull-right">
                                @if($tileInfo->id > 8)
                                    <a href="#" style="margin-right: 7px; margin-top: 4px" class="btn btn-box-tool gallery-btn" ><i class="fa fa-arrow-up" data-toggle="tooltip" data-placement="top" title="Order Up"></i></a>
                                @endif

                                @if($tileInfo->id < 18)
                                    <a href="#" style="margin-right: 7px; margin-top: 6px" class="btn btn-box-tool gallery-btn" ><i class="fa fa-arrow-down" data-toggle="tooltip" data-placement="top" title="Order Down"></i></a>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body tilebox">
                            <a href="{{route('admin.dashboard.posts', $tileInfo->id)}}"><div class="tileimage" style="background-image: url({{asset($tileInfo->picture)}});"></div></a>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <b>{{$tileInfo->creatorName}}</b>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <b>Posts 0</b>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <b>Last Post: March 16, 2018 - 11:06 AM(5 hours ago)</b>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            @endforeach
        </div><!-- /.box-body -->
@endsection

@section('after-scripts')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            var d = new Date();
            var n = d.getTimezoneOffset();

            $(function() {

            });
        });
    </script>
@endsection