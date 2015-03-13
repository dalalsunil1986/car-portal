        <div class="row item-row post-item">
            <div class="col-xs-10 col-sm-8 column title-color">
                <a href="{{action('CarsController@show',$car->id) }}">
                    @if($car->thumbnail)
                        <img src="/uploads/thumbnail/{{ $car->thumbnail->name  }}" class="post-image"/>
                    @else
                        <img src="assets/img/custom/car-thumb.jpg" class="post-image"/>
                    @endif
                </a>

                <h3 class="post-title">
                    <a href="{{ action('CarsController@show',$car->id) }}" >  {{ $car->year}} - {{ $car->model->brand->name }} - {{ $car->model->name}}  </a>
                </h3>
            </div>
            <div class="col-xs-2 col-sm-2 column cost-color">

                <div class="post-option"><a href="{{ action('CarsController@edit',$car->id) }}">Edit</a></div>

                <button type="button" class="delete delete-button" aria-hidden="true">
                    <a href="{{action('CarsController@show',$car->id)}}">×</a>
                </button>

            </div>
        </div>
