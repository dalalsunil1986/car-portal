@extends('layouts._three_column')

@section('style')
    {!! HTML::style('packages/select2/select2.css') !!}
    @parent
@stop

@section('content')
    @parent

    <div class="col-md-10 col-sm-12">
        <div class="row">

            <div class="col-lg-3">
                <ol class="text-center">
                    <li class="active"><a href="#">Details</a></li>
                    <li class=""><a href="#">Optional</a></li>
                </ol>
            </div>

            <div class="col-lg-9">
                {!! Form::open(['action' => 'CarsController@store', 'method' => 'post', 'files'=> true]) !!}

                <fieldset>
                    @include('module.cars._create-form')
                </fieldset>

                <div class="row">
                    <div class="form-group">
                        {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
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
            $("#model_id").select2({placeholder: "Select a Make"});
            $("#year").select2({placeholder: "Select a Year"});
        });
    </script>
@stop