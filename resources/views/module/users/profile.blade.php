@extends('layouts._three_column')

@section('style')
    @parent

    {!! HTML::style('assets/css/pop-up.css') !!}
    {!! HTML::style('assets/css/style-profile.css') !!}
    {!! HTML::style('assets/css/layout-profile-page.css') !!}

@stop
@section('script')
    @parent
    {!! HTML::script('assets/js/pop-up.js') !!}

    <script>
        $(document).ready(function () {
            $("#make").select2();
            $("#type").select2({
                placeholder: "Select a Type",
                allowClear: true,
                maximumSelectionSize: 3
            });
        });
    </script>
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

                                    <h2>Khalid Al-Something</h2>

                                    <div class="col-xs-12 account-row">

                               {{--<a href="#" id="username" data-type="text" data-pk="1" data-url="/post"--}}
                                       {{--data-title="Enter username">superuser</a>--}}

                                <div class="col-xs-12"><span>E-Mail: </span>thedude45@gmail.com</div>
                                <div class="col-xs-12"><span>Mobile: </span>959-845-9542</div>

                            </div>

                                </div>


                                <div class="row">

                                    <h2>Settings</h2>

                                    <div class="col-xs-12 account-row">
                                        <div class="col-xs-12"><a href="#"> Edit Account</a></div>
                                        <div class="col-xs-12">Deactivate</div>
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
                        <div class="row item-row post-item">
                            <div class="col-md-8 column title-color">
                                <img class="post-image" src="/assets/img/custom/car-thumb.jpg">
                                <h3 class="post-title">2010 - BMW - M3</h3>
                            </div>
                            <div class="col-md-2 column cost-color">
                                <div class="post-option">Edit</div>
                                <div class="post-option">View</div>
                                <button type="button" class="delete delete-button" aria-hidden="true">×</button>
                            </div>
                        </div>
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


                            <div class="row item-row">
                                <div class="col-xs-8 column title-color">
                                    <img class="post-image" src="/assets/img/custom/car-thumb.jpg">

                                    <h3 class="post-title">2010 - BMW - M3</h3>
                                </div>
                                <div class="col-xs-2 column cost-color">
                                    <div class="fav-view">View</div>
                                    <button type="button" class="delete  cd-popup-trigger delete-button" aria-hidden="true">×
                                    </button>
                                </div>
                            </div>
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
                        <div class="row">

                            <div class="row">
                                <div class="col-md-9 notify-pannel">
                                    <div class="row clearfix">
                                        <button type="button" class="delete delete-button" aria-hidden="true">×</button>
                                        <div class="col-xs-6 column">
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-3 column"><span class="ntf-feild">Make:</span></div>
                                                <div class="col-md-9 column">
                                                    <span class="ntf-input">Japanese, American</span></div>
                                            </div>
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-3 column"><span class="ntf-feild">Type:</span></div>
                                                <div class="col-md-9 column"><span class="ntf-input">SUV</span></div>
                                            </div>
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-3 column"><span class="ntf-feild">Brand:</span></div>
                                                <div class="col-md-9 column"><span class="ntf-input">Unspecified</span>
                                                </div>
                                            </div>
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-3 column"><span class="ntf-feild">Model:</span></div>
                                                <div class="col-md-9 column"><span class="ntf-input">Unspecified</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 column">
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-3 column"><span class="ntf-feild">Years:</span></div>
                                                <div class="col-md-9 column"><span class="ntf-input">2008 - 20013</span>
                                                </div>
                                            </div>
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-3 column"><span class="ntf-feild">Milage:</span>
                                                </div>
                                                <div class="col-md-9 column">
                                                    <span class="ntf-input">50,000 - 80,000</span>
                                                </div>
                                            </div>
                                            <div class="row clearfix ntf-row">
                                                <div class="col-md-3 column"><span class="ntf-feild">Price:</span></div>
                                                <div class="col-md-9 column">
                                                    <span class="ntf-input">4,000KD - 6,000 KD</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cd-popup" role="alert">
        <div class="cd-popup-container">
            <p>Are you sure you want to delete this?</p>
            <ul class="cd-buttons" style="padding-left: 0px;">
                <li><a href="#0">Yes</a></li>
                <li><a href="#0">No</a></li>
            </ul>
            <a href="#0" class="cd-popup-close img-replace">Close</a></div>
        <!-- cd-popup-container -->
    </div>
    <!-- cd-popup -->

@stop