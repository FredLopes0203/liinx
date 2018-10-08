@extends ('backend.layouts.app')

@section ('title', 'Tile Management | Accept Users')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("css/tilelist.css") }}
    {{ Html::style("css/invite.css") }}
@endsection

@section('page-header')

@endsection

@section('content')

    <div class="box-body">
        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-5" style="padding: 0px !important;">
        </div>
        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-7" style="padding: 0px !important; height: 35px">
            <div class="inner-addon left-addon" id="searchbox">
                <div class="col-lg-6 col-md-6 col-sm-9 col-xs-7" style="padding: 0px !important;">
                    <i class="glyphicon glyphicon-search" style="color: #E17933"></i>
                    <input id="searchText" type="text" class="form-control" placeholder="Search Users ..." />
                </div>

                <button id="searchuserbtn" class="btn btn-warning" style="margin-left: 10px; background-color: #E17933;">Search</button>
            </div>
        </div>
    </div>

    <div class="box-body">
        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-5" style="padding: 0px !important;">
            @foreach($tileInfos as $tileInfo)

                @if($tileInfo->id == $firsttile)
                    <div class="tilediv" id="tile{{$tileInfo->id}}">
                        <h4 id="title{{$tileInfo->id}}" class="tileorgtitle" style="color: black">
                            {{$tileInfo->name}}
                            <span class="badge" style="margin-left: 5px; margin-top: -2px; background-color: #00a65a">{{$tileInfo->requests}}</span>
                        </h4>

                        <div class="box-body tilebox">
                            <div class="tileimage" id="img{{$tileInfo->id}}" style="background-image: url({{asset($tileInfo->picture)}}); border: solid; border-width: 3px; border-color: #E17933">

                            </div>
                        </div>
                    </div>
                @else
                    <div class="tilediv" id="tile{{$tileInfo->id}}">
                        <h4 id="title{{$tileInfo->id}}" class="tileorgtitle" style="color: darkgray">
                            {{$tileInfo->name}}
                            <span class="badge" style="margin-left: 5px; margin-top: -2px; background-color: #00a65a">{{$tileInfo->requests}}</span>
                        </h4>

                        <div class="box-body tilebox">
                            <div class="tileimage" id="img{{$tileInfo->id}}" style="background-image: url({{asset($tileInfo->picture)}});">
                                <div class="tileimage"  style="margin-top: -40%; background-color: rgba(255,255,255,0.3); width: 100%; "></div>
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-7" style="padding: 0px !important;">
            <div id="usersection">
                <div class="box box-widget box-solid userlistdiv">

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->

@endsection

@section('after-scripts')
    {{ Html::script("js/backend/accept/accept.js") }}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            var d = new Date();
            var n = d.getTimezoneOffset();
            var firsttile = '<?php echo $firsttile;?>';

            getUserList(firsttile, "");
        });
    </script>
@endsection