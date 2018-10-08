@extends ('backend.layouts.app')

@section ('title', 'LIINX | Post Management')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("css/tilelist.css") }}
@endsection

@section('page-header')

@endsection

@section('content')

    <div class="box-body">
        <div class="box-header with-border">
            <h3 class="box-title">{{$tileInfo->name}}</h3>
        </div>

        <div class="row categorydiv" id="categorydiv">
            <div class="col-md-4 col-sm-4">
                <div class="box box-widget box-solid">
                    <div class="box-body tilebox">
                        <div class="tileimage" style="background-image: url({{asset($tileInfo->picture)}});"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-sm-8">
                <div class="box box-widget box-solid postdiv">

                    <div class="divposterinfo">
                        <div class="profileimgdiv">
                            <img src="{{asset('img/profile/kudonobo1007@gmail.com.png')}}" class="profileimgdiv img-circle" />
                        </div>
                        <div class="profileinfodiv">
                            <h4><b>Kurt Nguyen</b></h4>
                            <h5>Qnexis CEO. RUOK emergency notification and LIINX B2B social media apps, cloud, mobility, and communication services.</h5>
                        </div>
                    </div>

                    <div class="posttextdiv">
                        <h5><b>Bulldogs working to reclaim volley ball title.</b></h5>
                        <h5>This fall, the Bulldogs will face programs such as USC, Penn State, Arkansas, Wake Forest, Ohio and Clemson in one of its toughest non-conference schedules.
                            The 2017 season starts on Sept. 1 with the Yale invitational in New Haven, and features mathes against Delaware, Rhode Island and Clemson.
                            After that, the Bulldogs travel to California to play USC, host UC Santa Barbara and Arkansas.
                            The next weekend, the Bulldogs travel to Penn State to face the Nittny Lions, Ohio and Wake Forest before starting the always challenging lvy League schedule.
                        Read more at: <a href="http://www.yalebulldogs.com/sports/w-volley/index" target="_blank">http://www.yalebulldogs.com/sports/w-volley/index</a></h5>
                    </div>

                    <div class="postimgdiv">
                        <img class="postimg" src="{{asset('img/tiles/article/1.jpg')}}"/>
                    </div>

                    <div class="replyactiondiv">
                        <button type="button" class="btn btn-info replybutton">
                            <span class="fa fa-thumbs-up"></span> Like
                        </button>

                        <button type="button" class="btn btn-info replycenterbutton">
                            <span class="fa fa-commenting"></span> Comment
                        </button>

                        <button type="button" class="btn btn-info replybutton">
                            <span class="fa fa-share-alt"></span> Share
                        </button>
                    </div>

                    <div class="spacediv">
                        <div class="separatordiv1"></div>
                        <div style="padding-left: 60px">4 Comments  &nbsp&nbsp&nbsp   8 Likes</div>
                        <div class="separatordiv2"></div>
                    </div>

                    <div class="commentordiv">
                        <div style="max-width: 60px; ">
                            <img src="{{asset('img/profile/kudonobo1007@gmail.com.png')}}" class="img-circle" style="max-width: 40px;" />
                        </div>
                        <div style="margin-left: 10px;">
                            <h5><b>Tom Gamertsfelder</b></h5>
                        </div>

                    </div>
                    <div class="settingwretchdiv">
                        <li class="dropdown" style="display: flex">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: black">
                                <span class="fa fa-wrench"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu" style="margin-left: -140px">
                                <li><a href="#"><span class="fa fa-pencil"></span>Edit</a></li>
                                <li><a href="#"><span class="fa fa-trash"></span>Delete</a></li>
                            </ul>
                        </li>
                    </div>

                    <div class="commenttextdiv">
                        <h5>Great Match! I enjoyed this match. They were all stars.</h5>
                    </div>

                    <div class="commenttextdiv">
                        <h5><b>Like &nbsp&nbsp/&nbsp&nbsp Comment</b></h5>
                    </div>

                    {{--<div class="spacediv">--}}
                        {{--<div class="separatordiv1"></div>--}}
                    {{--</div>--}}


                    <div class="spacediv">

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('after-scripts')
    {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}

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