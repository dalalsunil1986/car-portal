<!DOCTYPE html >
<html lang="en" ng-app='app' ng-cloak>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kuwaitii.com</title>

    @section('style')
        <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' type='text/css'>
        {!! HTML::style('packages/bootstrap/dist/css/bootstrap.css') !!}
        {!! HTML::style('packages/fontawesome/css/font-awesome.css') !!}
        {!! HTML::style('packages/Slidebars/distribution/0.10.2/slidebars.min.css') !!}
        {!! HTML::style('packages/ionrangeslider/css/ion.rangeSlider.css') !!}
        {!! HTML::style('packages/ionrangeslider/css/ion.rangeSlider.skinFlat.css') !!}
        {!! HTML::style('packages/nanoscroller/bin/css/nanoscroller.css') !!}
        {!! HTML::style('assets/css/modules/form.css') !!}
        {!! HTML::style('assets/css/modules/filter.css') !!}
        {!! HTML::style('assets/css/modules/result.css') !!}

        {!! HTML::style('assets/css/global.css') !!}

        <link rel="shortcut icon" href="../img/icons/favicon.ico">
    @show
</head>

<body>

@include('partials.navigation-mobile')

@include('partials.top-menu')

<section class="left-sidebar">
    @section('left-sidebar')
    @show
</section>

<div class="container">
    @include('partials.notification')
    @section('content')
    @show
</div>

<section class="right-sidebar">
    @section('right-sidebar')
    @show
</section>

@section('script')
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    {!! HTML::script('site/js/html5shiv.js') !!}
    <![endif]-->
    {!! HTML::script('packages/jquery/dist/jquery.js') !!}
    {!! HTML::script('packages/bootstrap/dist/js/bootstrap.js') !!}

    {!! Html::script('packages/angular/angular.js') !!}
    {!! Html::script('packages/angular-bootstrap/ui-bootstrap.js') !!}
    {!! Html::script('packages/angular-bootstrap/ui-bootstrap-tpls.js') !!}
    {!! Html::script('packages/angular-animate/angular-animate.js') !!}
    {!! Html::script('packages/angular-sanitize/angular-sanitize.js') !!}
    {!! Html::script('packages/angular-resource/angular-resource.js') !!}
    {!! Html::script('packages/angular-ui-select/dist/select.js') !!}
    {!! Html::script('packages/underscore/underscore.js') !!}
    {!! Html::script('packages/ngInfiniteScroll/build/ng-infinite-scroll.min.js') !!}

    {!! Html::script('app/app.js') !!}
    {!! Html::script('app/filters.js') !!}
    {!! Html::script('app/directives.js') !!}
    {!! Html::script('app/animations.js') !!}

    {!! Html::script('app/controllers/FavoritesController.js') !!}
    {!! Html::script('app/services/FavoriteService.js') !!}
    <!-- end angular -->

    <!-- custom scripts -->
    {!! Html::script('/assets/js/scripts.js') !!}
    {!! Html::script('/packages/Slidebars/distribution/0.9/slidebars.min.js') !!}
    {!! Html::script('/packages/ionrangeslider/js/ion.rangeSlider.js') !!}
    {!! Html::script('/packages/nanoscroller/bin/javascripts/jquery.nanoscroller.js') !!}

    <script>
        angular.module("app").constant("CSRF_TOKEN", '{!! csrf_token() !!}');

        $(document).ready(function () {
            runSlidebars();
            $(window).resize(runSlidebars);

        });

        //init-nanoscroller
        $(".int-col").hover( function(){
            $(".nano").nanoScroller();
        });

    </script>

@show

</body>
</html>