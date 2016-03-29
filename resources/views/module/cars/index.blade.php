@extends('layouts._three_column')

@section('style')
    <!-- Styles -->
    {!! HTML::style('packages/select2/select2.css') !!}
    @parent
    <style>
        .modal-backdrop {
            z-index: -5000;
        }
    </style>
@stop

@section('content')
    <div ng-controller="CarsController" ng-init="initCars()">

        @include('module.cars._filter')
        @include('module.cars._result')

        <div class="goUp">
            <i class="fa fa-angle-double-up"></i>
        </div>

    </div>
@stop

@section('script')
    @parent

    {!! Html::script('app/cars/CarsController.js') !!}
    {!! Html::script('app/cars/CarService.js') !!}
    {!! Html::script('app/cars/filters.js') !!}
    {!! Html::script('app/cars/directives.js') !!}

    {!! Html::script('app/notifications/NotificationService.js') !!}

    <script>
        $(document).ready(function () {

            //Check to see if the window is top if not then display button
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.goUp').fadeIn();
                } else {
                    $('.goUp').fadeOut();
                }
            });

            //Click event to scroll to top
            $('.goUp').click(function () {
                $('html, body').animate({scrollTop: 0}, 800);
                return false;
            });

        });
    </script>
@stop
