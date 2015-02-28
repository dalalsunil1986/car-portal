
        <div class="row item-row post-item">

            <div class="col-md-8 column title-color">
                {!! $car->thumbnail ? '<a href="/cars/'. $car->id .'"><img src="/uploads/thumbnail/'.$car->thumbnail->name.'" class="img-responsive post-image"/></a>' : '<a href="/cars/'.$car->id.'"><img src="assets/img/custom/car-thumb.jpg" class="post-image"/></a>' !!}

                <h3 class="post-title">
                    {{ $car->year}} - {{ $car->model->brand->name }} - {{ $car->model->name}}
                </h3>
            </div>
            <div class="col-md-2 column cost-color">
                <div class="post-option"><a href="{{ action('CarsController@show',$car->id) }}">View</a></div>
                <div class="post-option"><a href="{{ action('CarsController@edit',$car->id) }}">Edit</a></div>

                <button type="button" class="delete delete-button" aria-hidden="true">
                    <a href="{{action('CarsController@show',$car->id)}}">×</a>
                </button>

            </div>
        </div>
