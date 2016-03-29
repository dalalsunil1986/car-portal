@extends('layouts._three_column')

@section('style')
    {!! HTML::style('packages/select2/select2.css') !!}
    {!! Html::style('assets/css/car-submit.css') !!}
    @parent
@stop

@section('content')
    @parent

    <div class="col-md-10 col-sm-12">
        <div class="row create-panel">

            <div class="col-lg-3">
                <ol class="steps-submit">
                    <li class="active"> <span class="number">1</span> <a href="#">Details</a></li>
                    <li class=""> <span class="number">2</span> <a href="#">Optional</a></li>
                </ol>
            </div>

            <div class="col-lg-9">
                {!! Form::open(['action' => 'CarsController@store', 'method' => 'post', 'files'=> true]) !!}

                <fieldset>
                    @include('module.cars._create-form')
                </fieldset>

                <div class="row">
                    <div class="form-group save-step">

                        {!! Form::submit('Save', ['class' => 'btn form-control submit-save-button']) !!}

                    </div>
                </div>

                {!! Form::close() !!}
            </div>

        </div>
    </div>
@stop
@section('script')
    @parent
    {!! Html::script('packages/select2/select2.min.js') !!}
    <script>
        //Slide Info Function
        $(document).ready(function () {
            $("#model_id").select2({placeholder: "Select a Model"});
            $("#year").select2({placeholder: "Select a Year"});
        });
    </script>
@stop