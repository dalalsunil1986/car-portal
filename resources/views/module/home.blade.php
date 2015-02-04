<!doctype html>
<html>
<head>
    <title>Kuwaitii - Jobs, Cars, Property, Rent, Events</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
          name="viewport">
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' type='text/css'>
    <!--Vendor CSS -->
    {{ HTML::style('site/css/bootstrap.min.css') }}
    <!-- Page Style -->
    {{ HTML::style('site/css/index.css') }}
    {{ HTML::style('site/css/animate.css') }}
    <!--Other-->
    <link rel="shortcut icon" href="img/icons/favicon.ico">
</head>
<body>
<div class="container">

    <div class="row clearfix">
        <div class="col-md-12 column pull-right top-bar">
            <div class="btn-group pull-right">

                <button class="btn btn-default btn-sm" type="button" data-toggle="dropdown"> Sign in <span
                        class="caret"></span></button>
                <ul class="dropdown-menu" style="padding: 15px; min-width: 250px;">
                    <li>
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form" role="form" method="post" action="login" accept-charset="UTF-8"
                                      id="login-nav">
                                    <div class="form-group">
                                        <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail2"
                                               placeholder="Email address" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="exampleInputPassword2">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword2"
                                               placeholder="Password" required>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox">
                                            Remember me </label>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <input class="btn btn-primary btn-block" type="button" id="sign-in-google"
                               value="Sign In with Facebook">
                        <input class="btn btn-primary btn-block" type="button" id="sign-in-twitter"
                               value="Sign In with Twitter">
                        <input class="btn btn-primary btn-block" type="button" id="sign-in-google"
                               value="Sign In with Google+">
                        <input class="btn btn-primary btn-block" type="button" id="sign-in-twitter"
                               value="Sign In with Instagram">
                    </li>
                </ul>
            </div>
            <div class="btn-group pull-right">
                <button class="btn btn-default btn-sm dropdown-toggle" type="button"> Sign up</button>
            </div>

            <div class="btn-group pull-right lang-btn">
                <a href="#">العربية</a>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 column logo-container">
            {{ HTML::image('site/img/icons/logo.png',trans('site.general.sitename'),array('class'=>'img-responsive logo')) }}
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-12 text-center icon-holder text-center ">
            <a href="{{ action('CarsController@index') }}" class="icon1">
                {{ HTML::image('site/img/icons/car-round-icon.png','Car Market',array('class'=>'icon1','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=> trans('site.general.car-market'))) }}
            </a>
            <a href="#" class="icon2">
                {{ HTML::image('site/img/icons/round-icon-work.png','Job Market',array('class'=>'icon2','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=> trans('site.general.job-market'))) }}
            </a>
            <a href="#" class="icon3">
                {{ HTML::image('site/img/icons/round-icon-dir.png','Business Directory',array('class'=>'icon3','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=> trans('site.general.business-directory'))) }}
            </a>
            <a href="#" class="icon4">
                {{ HTML::image('site/img/icons/round-icon-events.png','Local Events',array('class'=>'icon4','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=> trans('site.general.events'))) }}
            </a>
        </div>
    </div>
</div>

{{ HTML::script('site/js/jquery.min.js') }}
{{ HTML::script('site/js/bootstrap.min.js') }}
{{ HTML::script('site/vendors/jquery.backstretch.min.js') }}

<script>
    //Animations
    $('.logo').addClass('animated flipInX');
    $('.icon1').addClass('animated fadeInLeft');
    $('.icon2').addClass('animated fadeInLeft');
    $('.icon3').addClass('animated fadeInLeft');
    $('.icon4').addClass('animated fadeInLeft');


    //ToolTip
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });

    // DropDown
    $('.dropdown-menu input, .dropdown-menu label').click(function (e) {
        e.stopPropagation();
    });

</script>
<script>

    // makes page fade to white when a link is clicked

    // delegate all clicks on "a" tag (links)
    $(document).on("click", "a", function () {

        // get the href attribute
        var newUrl = $(this).attr("href");

        // veryfy if the new url exists or is a hash
        if (!newUrl || newUrl[0] === "#") {
            // set that hash
            location.hash = newUrl;
            return;
        }

        // now, fadeout the html (whole page)
        $("html").fadeOut(function () {
            // when the animation is complete, set the new location
            location = newUrl;
        });

        // prevent the default browser behavior.
        return false;
    });

</script>
</body>
</html>