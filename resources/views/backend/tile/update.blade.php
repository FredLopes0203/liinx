@extends ('backend.layouts.app')

@section ('title', 'Tile Management' . ' | ' . 'Edit Tile')

@section('after-styles')
    {{ Html::style('css/category.css') }}
    {{ Html::style("js/Switch/css/on-off-switch.css") }}
    {{ Html::style("css/tilelist.css") }}
@endsection

@section('page-header')
    <h1>
        Tile Management
        <small>Edit Tile</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => ['admin.tile.update', $tileInfo], 'id' => 'tileupdateform', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) }}

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Tile Info</h3>

            <div class="box-tools pull-right">
                @include('backend.tile.includes.partials.tile-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('title', 'Tile Name', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('tilename', $tileInfo->name, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Tile Name']) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group" style="margin-bottom: 40px; margin-top: 40px;">
                {{ Form::label('switchpost', 'Post Option', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <div class="checkbox-container">
                        <input type="checkbox" id="optpost" name="optpost" @if($tileInfo->poston == 1) checked @endif>
                    </div>
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('photourl', 'Tile Image', ['class' => 'col-lg-2 control-label']) }}
                <div class="col-lg-10">
                    <div class="box box-warning box-solid" style="max-width: 600px;">
                        <div class="box-body tilebox">
                            <div id="tileimage" class="tileimage" style="background-image: url({{asset($tileInfo->picture)}});"></div>
                        </div>
                    </div>

                    <div class="input-group img-preview">
                        <input id="TileImg" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled">
                        <div class="input-group-btn">
                            <div class="fileUpload btn btn-danger fake-shadow">
                                <span><i class="glyphicon glyphicon-upload"></i> Upload Tile Image</span>
                                <input id="logo-id" name="logo" type="file" class="attachment_upload">
                            </div>
                        </div>
                    </div>
                    <p class="help-block">* Upload image for Tile.</p>
                </div>
            </div>


            <div class="form-group" style="margin-top:50px;">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="pull-right">
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-success btn-md', 'style' => 'width:100px !important;']) }}
                    </div><!--pull-right-->
                </div><!--col-lg-10-->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="pull-left">
                        {{ link_to_route('admin.tile.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md', 'style' => 'width:100px !important;']) }}
                    </div><!--pull-left-->
                </div><!--col-lg-10-->
            </div><!--form control-->
        </div><!-- /.box-body -->
    </div><!--box-->
    {{ Form::close() }}
@endsection

@section('after-scripts')
    {{ Html::script('js/backend/access/users/script.js') }}
    {{ Html::script("js/login.js") }}
    {{ Html::script("js/Switch/js/on-off-switch.js") }}
    {{ Html::script("js/Switch/js/on-off-switch-onload.js") }}

    <script>
        $(document).ready(function() {

            new DG.OnOffSwitch({
                el: '#optpost',
                height: 36,
                trackColorOff:'#d13838',
                textColorOff:'#fff',
                textOff: 'Post Off',
                textOn: 'Post On'
            });

            var tile = document.getElementById('logo-id');
            tile.className = 'attachment_upload';
            tile.onchange = function() {
                document.getElementById('TileImg').value = this.value.substring(12);
            };
            loadPrevImg()

            function loadPrevImg() {
                if(tile.files.length > 0)
                {
                    var bkImg = URL.createObjectURL(tile.files[0]);
                    $('#tileimage').css('background-image', 'url(' + bkImg + ')');
                }
            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var selectedImage = new Image();
                        selectedImage.src =  e.target.result;
                        console.log(e.target.result);

                        selectedImage.onload = function ()
                        {
                            var getImagePath = URL.createObjectURL(input.files[0]);
                            $('#tileimage').css('background-image', 'url(' + getImagePath + ')');
                        };
                    };
                    reader.readAsDataURL(input.files[0]);
                }
                else
                {
                    $('#tileimage').css('background-image', "url({{asset('img/tiles/sampletile.png')}})");
                }
            }

            $("#logo-id").change(function() {
                readURL(this);
            });

        });
    </script>
@endsection
