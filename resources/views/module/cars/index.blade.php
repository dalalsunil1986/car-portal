@extends('layouts._three_column')

@section('style')
    <!-- Styles -->
    {!! HTML::style('packages/select2/select2.css') !!}
    @parent
    {!! HTML::style('site/css/layout-filter-page.css') !!}
@stop

@section('content')
    <div ng-controller="CarsController">

        @include('module.cars._filter')
        @include('module.cars._result')

        <div class="goUp">
            <i class="fa fa-angle-double-up"></i>
        </div>

    </div>
@stop

@section('script')
    @parent

    {!! Html::script('app/controllers/CarsController.js') !!}
    {!! Html::script('app/services/CarService.js') !!}

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

            //open popup
            $('.cd-popup-trigger').on('click', function (event) {
                event.preventDefault();
                $('.cd-popup').addClass('is-visible');
            });

            //close popup
            $('.cd-popup').on('click', function (event) {
                if ($(event.target).is('.cd-popup-close , .cd-close') || $(event.target).is('.cd-popup')) {
                    event.preventDefault();
                    $(this).removeClass('is-visible');
                }
            });
            //close popup when clicking the esc keyboard button
            $(document).keyup(function (event) {
                if (event.which == '27') {
                    $('.cd-popup').removeClass('is-visible');
                }
            });

            //NotifyMe Notification Bottom
            var smsRate = $("#sms-rate-notify"),
                    smsCheckbox = $('.sms-checkbox'),
                    noNumber = $("#no-mobile-number-message");

            smsRate.hide();

            if (smsCheckbox.is(':disabled')) {
                noNumber.show();
            } else {
                smsCheckbox.change(function () {
                    smsRate.fadeToggle();
                })
                noNumber.hide();
            }

        });
    </script>
@stop
