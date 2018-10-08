@extends ('backend.layouts.app')

@section ('title', 'Tile Management | My Tiles')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("css/tilelist.css") }}
    {{ Html::style("js/slick/slick.css") }}
    {{ Html::style("js/slick/slick-theme.css") }}
@endsection

@section('page-header')

@endsection

@section('content')

    <div class="box-body">
        <div class="box-title sectionmanage-div">
            <h3>
                My Tiles
            </h3>
            <div class="gallery-separator">
            </div>
        </div>

        <div class="content sectiontile-div">
            <div class="tilegallery">
                @foreach($tileInfos as $tileInfo)
                    <div class="box box-widget box-solid gallerytilediv" style="width: 0px">
                        <div class="box-header with-border">
                            <h2 class="gallery-title" style="display: none">{{$tileInfo->name}}</h2>
                        </div>

                        <div class="box-body tilebox">
                            <div class="tileimage" style="background-image: url({{asset($tileInfo->picture)}});"></div>
                        </div>

                        <div class="box-body gallerybtnbox" style="display: none">
                            <div style="float: right;">
                                <a href="{{route('admin.tile.edit', $tileInfo)}}" style="margin-right: 7px" class="btn btn-box-tool gallery-btn" ><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit Tile"></i></a>
                                <a href="{{route('admin.tile.edit', $tileInfo)}}" style="margin-right: 7px" class="btn btn-box-tool gallery-btn" ><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="Deactivate Tile"></i></a>
                                <a href="{{route('admin.tile.destroy', $tileInfo)}}" class="btn btn-box-tool gallery-btn" data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure?"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Remove Tile"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="box-title sectionmanage-div">
            <h3>
                Request Tile
            </h3>
            <div class="gallery-separator">
            </div>
        </div>

        <div class="content sectiontile-div">
            <div class="tilegallery">
                @foreach($tileInfos as $tileInfo)
                    <div class="box box-widget box-solid gallerytilediv" style="width: 0px">
                        <div class="box-header with-border">
                            <h2 class="gallery-title" style="display: none">{{$tileInfo->name}}</h2>
                        </div>

                        <div class="box-body tilebox">
                            <div class="tileimage" style="background-image: url({{asset($tileInfo->picture)}});"></div>
                        </div>

                        <div class="box-body gallerybtnbox" style="display: none">
                            <div style="float: right;">
                                <a href="#" class="btn gallery-btn request-btn">Reqeust to Join</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="box-title sectionmanage-div">
            <h3>
                Accept Invite
            </h3>
            <div class="gallery-separator">
            </div>
        </div>

        <div class="content sectiontile-div">
            <div class="tilegallery">
                @foreach($tileInfos as $tileInfo)
                    <div class="box box-widget box-solid gallerytilediv" style="width: 0px">
                        <div class="box-header with-border">
                            <h2 class="gallery-title" style="display: none">{{$tileInfo->name}}</h2>
                        </div>

                        <div class="box-body tilebox">
                            <div class="tileimage" style="background-image: url({{asset($tileInfo->picture)}});"></div>
                        </div>

                        <div class="box-body gallerybtnbox" style="display: none">
                            <div style="float: right;">
                                <a href="#" class="btn gallery-btn request-btn">Accept</a>
                                <a href="#" class="btn gallery-btn reject-btn">Reject</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('after-scripts')
    {{ Html::script("js/Switch/js/on-off-switch.js") }}
    {{ Html::script("js/Switch/js/on-off-switch-onload.js") }}
    {{ Html::script("js/slick/slick.min.js") }}

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

            $('.tilegallery').slick({
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                        breakpoint: 1280,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.gallery-title').css('display', '');
            $('.gallerybtnbox').css('display', '');
        });
    </script>
@endsection