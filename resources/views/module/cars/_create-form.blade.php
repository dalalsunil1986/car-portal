            <h3>Step 1: Fill in all the inputs.</h3>

            <div class="row">
                <div class="form-group col-lg-12 col-sm-12 submitpu-form">
                    <label class=" col-sm-2 col-xs-3">Model</label>
                    {!! Form::select('model_id', $models , null , ['class' => 'populate select2-offscreen col-sm-8 col-xs-8 input', 'id' => 'model_id', 'data-placeholder' =>'Select a Make' ]) !!}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-12 col-sm-12 submit-form ">
                    <label class="col-sm-2 col-xs-3">Year</label>
                    <select name="year" id="year" class="populate  select2-offscreen col-sm-8 col-xs-8 input">
                        <option value=''></option>
                        @for($i=1980; $i < 2015 ; $i++)
                            <option value="{{ $i }}"
                            @if( Form::getValueAttribute('year') == $i)
                                selected="selected"
                            @endif
                            >{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-12 col-sm-12 submit-form">
                    <label class="col-sm-2 col-xs-3">Mileage</label>
                    {!! Form::text('mileage',null,['class'=>' counter col-xs-8 col-sm-8', 'placeholder'=>'Mileage KM']) !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-12 col-sm-12 submit-form">
                    <label class="col-sm-2 col-xs-3">Price</label>
                    {!! Form::text('price',null,['class'=>' counter col-xs-8 col-sm-8', 'placeholder'=>'Price']) !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-12 col-sm-12 submit-form">
                    <label class="col-sm-2 col-xs-3">Mobile</label>
                    {!! Form::text('mobile',null,['class'=>' counter col-xs-8 col-sm-8', 'placeholder'=>'Phone/Mobile']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-xs-10">
                    <div class="price-hidden"> Keep Price Hidden?
                        <input type="checkbox" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-12 col-sm-12 col-md-12 submit-form ">
                    <label class="col-sm-2 col-xs-3">Car Photo</label>
                    {!! Form::file('thumbnail',['class'=>' col-xs-8 col-sm-8 ','id' => 'thumbnail']) !!}
                </div>
            </div>

            <div class="row" id="imagePreviewWrapper submit-form">
                <div class="form-group col-lg-12 col-sm-12 col-md-12">
                    <div class=" col-sm-2 col-xs-3"></div>
                    <div class="" id="imagePreview"></div>
                </div>
            </div>

