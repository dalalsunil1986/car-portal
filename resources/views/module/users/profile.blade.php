@extends('layouts._three_column')

@section('style')
    @parent
    {!! HTML::style('assets/css/style-profile.css') !!}
    {!! HTML::style('assets/css/layout-profile-page.css') !!}
    <style>
        .submitLink {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="title">Profile</h2>

            <!-- Nav tabs -->

            <div class="tabs-left wow fadeInDown">
                <ul class="nav nav-tabs tabbable tabs-left ">
                    <li class="active"><a href="#account" data-toggle="tab">Account</a></li>
                    <li><a href="#posts" data-toggle="tab">Posts</a></li>
                    <li><a href="#favorites" data-toggle="tab">Favorites</a></li>
                    <li><a href="#notifyme" data-toggle="tab">NotifyMe</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content wow fadeInDown">
                    <div class="tab-pane active" id="account">
                        <div class="row account-row">
                            <div class="col-xs-4 photo-row">
                                <img src="/assets/img/custom/user_profile_picture.jpg" alt="Profile Picture" class="img-responsive img-profile" width="225" height="225">

                            </div>
                            <div class="col-xs-7 basic-info">
                                <div class="row">
                                    <h2>About Me</h2>

                                    <div class="col-xs-12 account-row">
                                        <div class="col-xs-12"><span>Name: </span>{{$user->name}}</div>
                                        <div class="col-xs-12"><span>E-Mail: </span>{{$user->email}}</div>
                                        {{ $user->phone? '<div class="col-xs-12"><span>Mobile: </span>'. $user->phone .'</div>' :''  }}
                                    </div>
                                </div>

                                <div class="row">
                                    <h2>Settings</h2>
                                    <div class="col-xs-12 account-row">
                                        <div class="col-xs-12">
                                            <a href="{{ action('UsersController@edit',$user->id) }}"> Edit Account</a>
                                        </div>
                                        {!! Form::open(['action'=>['UsersController@destroy',$user->id],'method'=>'DELETE']) !!}
                                        {!! Form::submit('Deactivate',['class'=>'col-md-4 col-xs-12 btn btn-md submitLink']) !!}
                                        {!! Form::close()!!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="posts">
                        <div class="btn-group pull-left clearfix">
                            <button class="btn btn-default dropdown-toggle toggle-reset" data-toggle="dropdown">All <span
                                        class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Cars</a></li>
                                <li><a href="#">Jobs</a></li>
                                <li><a href="#">Property</a></li>
                                <li><a href="#">Places</a></li>
                                <li><a href="#">Events</a></li>
                            </ul>
                        </div>
                        @foreach($user->cars as $car)
                            @include('module.cars._result_single',['car'=>$car])
                        @endforeach
                    </div>
                    <div class="tab-pane" id="favorites">
                        <div class="tab-pane" id="posts">
                            <div class="btn-group pull-left clearfix">
                                <button class="btn btn-default dropdown-toggle toggle-reset" data-toggle="dropdown">All <span
                                            class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Cars</a></li>
                                    <li><a href="#">Jobs</a></li>
                                    <li><a href="#">Property</a></li>
                                    <li><a href="#">Places</a></li>
                                    <li><a href="#">Events</a></li>
                                </ul>
                            </div>

                            @foreach($user->favorites as $favorite)
                                @if($favorite->favoriteable)
                                    @include('module.cars._result_single',['car'=>$favorite->favoriteable])
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="tab-pane" id="notifyme">
                        <div class="btn-group pull-left clearfix">
                            <button class="btn btn-default dropdown-toggle toggle-reset" data-toggle="dropdown">All <span
                                        class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Cars</a></li>
                                <li><a href="#">Jobs</a></li>
                                <li><a href="#">Property</a></li>
                                <li><a href="#">Places</a></li>
                                <li><a href="#">Events</a></li>
                            </ul>
                        </div>

                        @foreach($user->notifications as $notification)
                            <div class="row">
                                <div class="col-md-9 notify-pannel">
                                    <div class="row clearfix">
                                        <button type="button" class="delete delete-button" aria-hidden="true">×</button>
                                        <div class="col-md-6 column">

                                            @if(count($notification->filters()->OfType('CarMake')))
                                                <div class="row clearfix ntf-row">
                                                    <div class="col-md-3 column"><span class="ntf-feild">Make:</span>
                                                    </div>
                                                    <div class="col-md-9 column">
                                                        @foreach($notification->filters()->OfType('CarMake') as $filter)
                                                            <span class="ntf-input">{{ $filter->filterable->name }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if(count($notification->filters()->OfType('CarBrand')))
                                                <div class="row clearfix ntf-row">
                                                    <div class="col-md-3 column"><span class="ntf-feild">Brand:</span>
                                                    </div>
                                                    <div class="col-md-9 column">
                                                        @foreach($notification->filters()->OfType('CarBrand') as $filter)
                                                            <span class="ntf-input">{{ $filter->filterable->name }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if(count($notification->filters()->OfType('CarType')))
                                                <div class="row clearfix ntf-row">
                                                    <div class="col-md-3 column">
                                                        <span class="ntf-feild">Type:</span>
                                                    </div>
                                                    <div class="col-md-9 column">
                                                        @foreach($notification->filters()->OfType('CarType') as $filter)
                                                            <span class="ntf-input">{{ $filter->filterable->name }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if(count($notification->filters()->OfType('CarModel')))
                                                <div class="row clearfix ntf-row">
                                                    <div class="col-md-3 column">
                                                        <span class="ntf-feild">Model:</span>
                                                    </div>
                                                    <div class="col-md-9 column">
                                                        @foreach($notification->filters()->OfType('CarModel') as $filter)
                                                            <span class="ntf-input">{{ $filter->filterable->name }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="col-md-6 column">
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-4 column"><span class="ntf-feild">Year:</span>
                                                </div>
                                                <div class="col-md-8 column">
                                                    <span class="ntf-input">{{ $notification->year_from .' - '.$notification->year_to }}</span>
                                                </div>
                                            </div>
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-4 column"><span class="ntf-feild">Mileage:</span>
                                                </div>
                                                <div class="col-md-8 column">
                                                    <span class="ntf-input">{{ $notification->mileage_from .' - '.$notification->mileage_to }} KM</span>
                                                </div>
                                            </div>
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-4 column"><span class="ntf-feild">Price:</span>
                                                </div>
                                                <div class="col-md-8 column">
                                                    <span class="ntf-input">{{ round($notification->price_from,0) .' - '. round($notification->price_to,0) }} KD</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

        <div class="cd-popup" role="alert">
            <div class="cd-popup-container">
                <p>Are you sure you want to delete this?</p>
                <ul class="cd-buttons" style="padding-left: 0px;">
                <ul class="cd-buttons" style="padding-left: 0px;">
                    <li><a href="#0">Yes</a></li>
                    <li><a href="#0">No</a></li>
                </ul>
                <a href="#0" class="cd-popup-close img-replace">Close</a></div>
            <!-- cd-popup-container -->
        </div>
        <!-- cd-popup -->
    </div>
@stop