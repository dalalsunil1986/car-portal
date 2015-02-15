@extends('layouts._three_column')

@section('style')
    @parent

    {!! HTML::style('assets/css/pop-up.css') !!}
    {!! HTML::style('assets/css/bootstrap-editable.css') !!}
    {!! HTML::style('assets/css/style-profile.css') !!}
    {!! HTML::style('assets/css/layout-profile-page.css') !!}

@stop
@section('script')
    @parent
    {!! HTML::script('assets/js/pop-up.js') !!}
    {!! HTML::script('assets/js/bootstrap-editable.min.js') !!}
    {!! HTML::script('assets/js/wow.min.js') !!}

    <script>
        $(document).ready(function () {
            function runSlidebars() {
                var mySlidebars = new $.slidebars(); // Start Slidebars
                var width = $(window).width(); // Get width of the screen

                if (width > 480 && mySlidebars.init) { // Check width and if Slidebars has been initialised
                    $('.sb-close').trigger("click"); // Triggering a click event will close a Slidebar if open.
                }
            }

            runSlidebars(); // Initially call the function.
            $(window).resize(runSlidebars); // Call the function again when teh screen is resized.
            $("#make").select2();
            $("#type").select2({
                placeholder: "Select a Type",
                allowClear: true,
                maximumSelectionSize: 3
            });

        });

        // Hide Function Sidebar
        $(".close").click(function () {
            $(this).parent().hide(500);
        });


        // Fade page to white when a link is clicked
        $(document).on("click", "a", function () {
            var newUrl = $(this).attr("href");
            if (!newUrl || newUrl[0] === "#") {
                // set that hash
                location.hash = newUrl;
                return;
            }
            $("html").fadeOut(function () {
                // when the animation is complete, set the new location
                location = newUrl;
            });
            return false;
        });


        //ordering filter
        $(function () {
            $('#Container').mixItUp();
        });

        // DropDown
        $('.dropdown-menu input, .dropdown-menu label').click(function (e) {
            e.stopPropagation();
        });
        //ScrolBar
        $(document).ready(function () {
            $('#left').nanoScroller({scroll: 'top'});
        });

    </script>
    <script>
        //animations
        new WOW().init();
    </script>
    <script>

        //
        //$(".delete-button").click(function() {
        // 	$(this).parents(".post-item").hide(500);
        //});


        $('.flip').click(function () {
            $(this).find('.card').toggleClass('flipped')

            $('.back-profile').click(function () {
                $(this).closest('.card').hasClass('flipped');
                console.log($(this));
            });
        });


    </script>
    <script>
        $(document).ready(function () {
            if (Modernizr.touch) {
                // show the close overlay button
                $(".close-overlay").removeClass("hidden");
                // handle the adding of hover class when clicked
                $(".img").click(function (e) {
                    if (!$(this).hasClass("hover")) {
                        $(this).addClass("hover");
                    }
                });
                // handle the closing of the overlay
                $(".close-overlay").click(function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if ($(this).closest(".img").hasClass("hover")) {
                        $(this).closest(".img").removeClass("hover");
                    }
                });
            } else {
                // handle the mouseenter functionality
                $(".img").mouseenter(function () {
                    $(this).addClass("hover");
                })
                    // handle the mouseleave functionality
                        .mouseleave(function () {
                            $(this).removeClass("hover");
                        });
            }
        });


        // x Eddit

        //turn to inline mode
        $.fn.editable.defaults.mode = 'inline';


        $(document).ready(function () {
            $('#username').editable();
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
                            <div class="flip">
                                <div class="card">
                                    <div class="face front effects clearfix" id="effect-5">
                                        <div class="img img-rounded img-responsive img-profile"><img
                                                    src="../img/custom/user_profile_picture.jpg">

                                            <div class="overlay"><a href="#" class="expand"><span
                                                            class="glyphicon glyphicon-user"></span> </a></div>
                                        </div>
                                    </div>
                                    <div class="face back">
                                        <div class="profile-image-add profile-image-setting"><span
                                                    class="back-text">New Photo</span> <span
                                                    class="glyphicon glyphicon-upload"></span></div>
                                        <div class="profile-image-remove profile-image-setting"><span
                                                    class="back-text">Remove</span> <span
                                                    class="glyphicon  glyphicon-remove"></span></div>
                                        <div class="back-profile profile-image-setting">
                                            <span class="back-text">Back</span>
                                            <span class="glyphicon glyphicon-share-alt"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-7 basic-info">
                            <div class="row">
                                <h2>Basic</h2>

                                <div class="col-xs-12">

                                    <a href="#" id="username" data-type="text" data-pk="1" data-url="/post"
                                       data-title="Enter username">superuser</a>

                                    <span class="glyphicon glyphicon-pencil"> </span></div>
                                <div class="col-xs-12">example@gmail.com<span class="glyphicon glyphicon-pencil"></span>
                                </div>
                                <div class="col-xs-12">Password<span class="glyphicon glyphicon-pencil"></span></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Optional</h2>

                                        <div class="col-xs-12">Manage CV<span class="glyphicon glyphicon-pencil"></span>
                                        </div>
                                        <div class="col-xs-12">Account<span class="glyphicon glyphicon-pencil"></span>
                                        </div>
                                    </div>
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
                            <img class="post-image" src="../img/custom/car-thumb.jpg">

                            <h3 class="post-title">2010 - BMW - M3</h3>
                        </div>
                        <div class="col-md-2 column cost-color">
                            <div class="post-option">Edit</div>
                            <div class="post-option"> View</div>
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
                                <img class="post-image" src="../img/custom/car-thumb.jpg">

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
                    <div class="row">
                        <div class="col-md-10 column">
                            <div class="row clearfix ntf-row">
                                <div class="col-md-6 column">
                                    <div class="input-group"><span class="input-group-addon">+965</span>
                                        <input type="text" class="form-control" placeholder="Mobile Number">
                                    </div>
                                </div>
                                <div class="row clearfix ntf-row ">
                                    <div class="col-md-6 column">
                                        <div class="input-group"><span class="input-group-addon">Email</span>
                                            <input type="text" class="form-control" placeholder="name@gmail.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row clearfix notify-pannel">
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
                                            <div class="col-md-3 column"><span class="ntf-feild">Milage:</span></div>
                                            <div class="col-md-9 column"><span class="ntf-input">50,000 - 80,000</span>
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
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row clearfix notify-pannel">
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
                                            <div class="col-md-3 column"><span class="ntf-feild">Milage:</span></div>
                                            <div class="col-md-9 column"><span class="ntf-input">50,000 - 80,000</span>
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