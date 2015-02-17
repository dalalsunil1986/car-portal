@extends('layouts._three_column')

@section('style')
    @parent

    {!! HTML::style('assets/css/modules/profile.css') !!}

@stop
@section('script')
    @parent
    <script src="/assets/js/ProfileTabs.js"></script>
    <script>
        (function () {

            [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
                new CBPFWTabs(el);
            });

        })();

        //ScrollBar
        $(document).ready(function () {
            $('#left').nanoScroller({scroll: 'top'});
        });

    </script>
@stop

@section('content')
    <link rel="stylesheet" href="assets/css/modules/profile.css">

    <svg class="hidden">
        <defs>
            <path id="tabshape" d="M80,60C34,53.5,64.417,0,0,0v60H80z"/>
        </defs>
    </svg>
    <div class="container">
        <!-- Top Navigation -->
        <div class="title">

            <span id="back"><i class="fa fa-arrow-circle-left"></i> <span class="go-back">Go Back</span></span>

            <h1 class="title">Account</h1>
        </div>
        <section>
            <div class="tabs tabs-style-bar">

                <nav class="col-md-2">
                    <ul class="tab-name">
                        <li>
                            <a href="section-bar-1">
                                <span class="fa fa-user"></span>
                                <span class="hidden-sm hidden-xs">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#section-bar-2">
                                <span class="fa fa-file"></span>
                                <span class="hidden-sm hidden-xs">Posts</span>
                            </a>
                        </li>
                        <li>
                            <a href="#section-bar-3">
                                <span class="fa fa-plus-circle"></span>
                                <span class="hidden-sm hidden-xs">Favorites</span>
                            </a>
                        </li>
                        <li>
                            <a href="#section-bar-4">
                                <span class="fa fa-mobile"></span>
                                <span class="hidden-sm hidden-xs">NotifyMe</span>
                            </a>
                        </li>

                    </ul>
                </nav>

                <div class="content-wrap col-md-7">

                    <section id="section-bar-1 profile-row">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="/assets/img/custom/user_profile_picture.jpg" alt="Profile Picture" class="img-responsive profile-img" width="225" height="225">
                                <span class="pull-right change-profile-image">Change</span>
                            </div>
                            <div class="col-md-7">
                                <ul class="settings-list">
                                    <li>Basic</li>
                                    <ul>
                                        <li>Khalid Al-Somthing</li>
                                        <li>example@yahoo.com</li>
                                        <li>Change Password</li>
                                        <li>900-900-900</li>
                                    </ul>
                                    <li>Extra</li>
                                    <ul>
                                        <li>Edit Resume</li>
                                        <li>Deactivate Account</li>
                                    </ul>

                                </ul>
                            </div>
                        </div>
                    </section>

                    <section id="section-bar-2">
                        <div class="row account-page-post-entry">
                            <div class="col-md-10">

                                {!! HTML::image('/assets/img/custom/2.jpg', 'Post Picture', array('class'=>'img-responsive post-img pull-left', 'width'=>'225','height'=>'225')) !!}

                                <a class="pull-left"><h3 class="pull-left">BMW - M3 - 2012 </h3></a>

                            </div>
                            <div class="col-md-2">
                                <span>View</span>
                                <span>Edit</span>
                                <button type="button" class="close delete-button" aria-hidden="true">×</button>
                            </div>
                        </div>

                        <div class="row account-page-post-entry">
                            <div class="col-md-10">

                                {!! HTML::image('assets/img/custom/2.jpg', 'Post Picture', array('class'=>'img-responsive post-img pull-left', 'width'=>'225','height'=>'225')) !!}

                                <a class="pull-left"><h3 class="pull-left">BMW - M3 - 2012 </h3></a>

                            </div>
                            <div class="col-md-2">
                                <span>View</span>
                                <span>Edit</span>
                                <button type="button" class="close delete-button" aria-hidden="true">×</button>
                            </div>
                        </div>


                        <div class="row account-page-post-entry">
                            <div class="col-md-10">

                                {!! HTML::image('assets/img/custom/2.jpg', 'Post Picture', array('class'=>'img-responsive post-img pull-left', 'width'=>'225','height'=>'225')) !!}

                                <a class="pull-left"><h3 class="pull-left">BMW - M3 - 2012 </h3></a>

                            </div>
                            <div class="col-md-2">
                                <span>View</span>
                                <span>Edit</span>
                                <button type="button" class="close delete-button" aria-hidden="true">×</button>
                            </div>
                        </div>
                    </section>

                    <section id="section-bar-3">

                        <div class="row account-page-post-entry account-page-favorite-entry">
                            <div class="col-md-10">

                                {!! HTML::image('assets/img/custom/2.jpg', 'Post Picture', array('class'=>'img-responsive post-img pull-left', 'width'=>'225','height'=>'225')) !!}

                                <a class="pull-left"><h3 class="pull-left">BMW - M3 - 2012 </h3></a>

                            </div>
                            <div class="col-md-2">
                                <span>View</span>
                                <button type="button" class="close delete-button" aria-hidden="true">×</button>
                            </div>
                        </div>

                        <div class="row account-page-post-entry account-page-favorite-entry">
                            <div class="col-md-10">

                                {!! HTML::image('assets/img/custom/2.jpg', 'Post Picture', array('class'=>'img-responsive post-img pull-left', 'width'=>'225','height'=>'225')) !!}

                                <a class="pull-left"><h3 class="pull-left">BMW - M3 - 2012 </h3></a>

                            </div>
                            <div class="col-md-2">
                                <span>View</span>
                                <button type="button" class="close delete-button" aria-hidden="true">×</button>
                            </div>
                        </div>


                    </section>
                    <section id="section-bar-4">

                        <div class="row">
                            <div class="col-md-12 account-page-notifme-entry">
                                <div class="row clearfix notify-pannel">

                                    <button type="button" class="close delete-button" aria-hidden="true">×</button>

                                    <div class="col-xs-6 column">
                                        <div class="row clearfix ntf-row">
                                            <div class="col-md-3 column"><span class="ntf-feild">Make:</span></div>
                                            <div class="col-md-9 column pull-left">
                                                <span class="ntf-input pull-left">Japanese, American</span></div>
                                        </div>
                                        <div class="row clearfix ntf-row">
                                            <div class="col-md-3 column"><span class="ntf-feild">Type:</span></div>
                                            <div class="col-md-9 column"><span class="ntf-input pull-left">SUV</span>
                                            </div>
                                        </div>
                                        <div class="row clearfix ntf-row">
                                            <div class="col-md-3 column"><span class="ntf-feild">Brand:</span></div>
                                            <div class="col-md-9 column">
                                                <span class="ntf-input pull-left">Unspecified</span></div>
                                        </div>
                                        <div class="row clearfix ntf-row">
                                            <div class="col-md-3 column"><span class="ntf-feild">Model:</span></div>
                                            <div class="col-md-9 column">
                                                <span class="ntf-input pull-left">Unspecified</span></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 column">
                                        <div class="row clearfix ntf-row">
                                            <div class="col-md-3 column"><span class="ntf-feild">Years:</span></div>
                                            <div class="col-md-9 column">
                                                <span class="ntf-input pull-left">2008 - 20013</span></div>
                                        </div>
                                        <div class="row clearfix ntf-row">
                                            <div class="col-md-3 column"><span class="ntf-feild">Milage:</span></div>
                                            <div class="col-md-9 column">
                                                <span class="ntf-input pull-left">50,000 - 80,000</span></div>
                                        </div>
                                        <div class="row clearfix ntf-row">
                                            <div class="col-md-3 column"><span class="ntf-feild">Price:</span></div>
                                            <div class="col-md-9 column">
                                                <span class="ntf-input pull-left">4,000KD - 6,000 KD</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>

                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>

    </div><!-- /container -->


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