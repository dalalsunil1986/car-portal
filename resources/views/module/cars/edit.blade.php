@extends('layouts._three_column')

@section('style')
    {!! HTML::style('packages/select2/select2.css') !!}
    {!! Html::style('packages/jquery-ui/themes/base/all.css') !!}
    @parent
    <style>

        /* Mimic table appearance */
        div.table {
            display: table;
        }

        div.table .file-row {
            display: table-row;
        }

        div.table .file-row > div {
            display: table-cell;
            vertical-align: top;
            border-top: 1px solid #ddd;
            padding: 8px;
        }

        div.table .file-row:nth-child(odd) {
            background: #f9f9f9;
        }

        /* The total progress gets shown by event listeners */
        #total-progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the progress bar when finished */
        #previews .file-row.dz-success .progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the delete button initially */
        #previews .file-row .delete {
            display: none;
        }

        /* Hide the start and cancel buttons and show the delete button */

        #previews .file-row.dz-success .start,
        #previews .file-row.dz-success .cancel {
            display: none;
        }

        #previews .file-row.dz-success .delete {
            display: block;
        }

    </style>
@stop

@section('content')
    @parent

    <div class="col-md-10 col-sm-12">
        <div class="row bs-wizard">

            <div class="col-lg-3">
                <ol class="bs-wizard-sidebar text-center">
                    <li class="active"><a href="#">Details</a></li>
                    <li class=""><a href="#">Optional</a></li>
                </ol>
            </div>

            <div class="col-lg-9">

                {!! Form::model($car,['action' => ['CarsController@update',$car->id], 'method' => 'PATCH', 'files'=> true]) !!}

                <fieldset>

                    @include('module.cars._create-form')

                    <div class="shadow" id="optionals">
                        <div class="panel panel-default">
                            <div class="panel-body bs-step-inner">

                                <h3>Step 2: Optional Fields .</h3>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-xs-2">Description</label>
                                        {!! Form::textarea('description',null,['class'=>'col-xs-8 form-control']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="tags">
                                            <label class="col-xs-2">Tags</label>
                                            {!! Form::select('tags[]', $tags , null , ['class' => 'col-sm-8 col-xs-9 ', 'id' => 'tags', 'multiple' => 'multiple' ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="map-wrapper">
                                            <div id="map" style="height: 400px;"></div>
                                            <div class="small">You can drag and drop the marker to the correct location</div>
                                            <input id="addresspicker_map" name="addresspicker_map" class="form-control" placeholder="Type the Street Address or drag and drop the map marker to the correct location">
                                            {!! Form::hidden('latitude',null, array('id' => 'latitude')) !!}
                                            {!! Form::hidden('longitude',null, array('id' => 'longitude')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-xs-2">Photo +</label>

                                        <div class="col-xs-10">
                                            <input type="file" name="photos[]" id="photos" class="multi max-5 accept-jpg|png maxsize-2048 with-preview" maxlength="5"/>
                                        </div>
                                    </div>

                                </div>

                                <div class="clearfix pull-right">
                                    <input type="checkbox" name="terms" id="terms" class="required terms_checkbox" checked>
                                    <span>I agree to <a href="">Terms of Service</a></span>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </fieldset>

                {!! Form::close() !!}

            </div>

        </div>
    </div>
    <?php
    $latitude = $car->latitude ? $car->latitude : '29.357';
    $longitude = $car->longitude ? $car->longitude : '47.951';
    ?>
@stop
@section('script')
    @parent
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    {!! Html::script('packages/jquery-ui/jquery-ui.min.js') !!}
    {!! Html::script('assets/js/jquery.ui.addresspicker.js') !!}
    {!! Html::script('assets/js/jquery.multifile.js') !!}
    {!! Html::script('packages/select2/select2.min.js') !!}
    <script>

        //Slide Info Function
        $(document).ready(function () {
            $("#model_id").select2({placeholder: "Select a Make"});
            $("#year").select2({placeholder: "Select a Year"});
            $("#tags").select2({placeholder: "Select Tags"});
        });

        $(function () {
            var latitude = '{{ $latitude }}';
            var longitude = '{{ $longitude }}';

            get_map(latitude, longitude);

            var addresspickerMap = $("#addresspicker_map").addresspicker({
                updateCallback: showCallback,
                elements: {
                    map: "#map",
                    lat: "#latitude",
                    lng: "#longitude"
                }
            });

            var gmarker = addresspickerMap.addresspicker("marker");
            gmarker.setVisible(true);
            addresspickerMap.addresspicker("updatePosition");

            $('#reverseGeocode').change(function () {
                $("#addresspicker_map").addresspicker("option", "reverseGeocode", ($(this).val() === 'true'));
            });

            function showCallback(geocodeResult, parsedGeocodeResult) {
                $('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
            }

            $('#photos').MultiFile();
        });

    </script>
@stop