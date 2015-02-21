<div class="result-col col-lg-8 col-md-8 clearfix">
    <div class="row">
        <div class="col-md-12 clearfix">
            <!-- Drop Down Filter-->
            <div class="row sort-row">
                <h3 class="results-title pull-left clearfix">Results</h3>

                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        Show
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" ng-model="sortorder" role="menu" aria-labelledby="dropdownMenu1">
                        <li><option value="+created_at">Oldest</option></li>
                        <li><a href="#" value="-year">Year: Old to new</a></li>
                        <li><option value="+price">Low Price</option></li>
                        <li><a href="#">Price: High to Low </a></li>
                        <li><a href="#">Mileage: High to Low</a></li>
                        <li><a href="#">Mileage: Low to High</a></li>
                        <li><a href="#">Submition: New to Old</a></li>
                        <li><a href="#" value="+created_at">Submition: Old to New</a></li>
                    </ul>
                </div>

                {{--<div class="btn-group pull-left clearfix">--}}
                {{--<button class="btn btn-default dropdown-toggle toggle-reset" data-toggle="dropdown">All--}}
                {{--<span class="caret"></span></button>--}}
                {{--<ul class="dropdown-menu" ng-model="sortorder" class="input-small">--}}
                {{--<option value="+created_at">Oldest</option>--}}
                {{--<option value="+year">Lower Year</option>--}}
                {{--<option value="-year">Higher Year</option>--}}
                {{--<option value="+price">Low Price</option>--}}
                {{--<option value="-price">High Price</option>--}}
                {{--<option value="+mileage">Low Mileage</option>--}}
                {{--<option value="-mileage">High Mileage</option>--}}
                {{--</ul>--}}
                {{--</div>--}}

            </div>
            <div class="result-entry">
                <!--SAMPLE ROW-->
                <div infinite-scroll="getCars()" infinite-scroll-distance='0' infinite-scroll-disabled='loading'
                     infinite-scroll-parent="true"
                     infinite-scroll-immediate-check="false">
                    <div id="Hf31x6{[car.id]}" class="my-repeat-animation" ng-repeat="car in cars | orderBy:sortorder ">
                        <div class="row car-result-box">
                            <div class="row car-result-box">

                                <div class="col-sm-3 column img-box">
                                    <span ng-show="car.thumbnail">
                                        <a href="/cars/{[ car.id ]}"><img ng-src="/uploads/thumbnail/{[ car.thumbnail.name ]}" class="img-responsive result-image"/></a>
                                    </span>
                                    <span ng-hide="car.thumbnail">
                                        <a href="/cars/{[ car.id ]}"><img src="assets/img/custom/2.jpg" class="img-responsive result-image"/></a>
                                    </span>
                                </div>

                                <div class="col-sm-3 col-sm-push-6 column price-box">
                                    <div class="asking text-center">Price</div>
                                    <div class="price-cost text-center">{[ car.price ]} KD</div>

                                    <favorite-button favorite="car.favorited" favoreable-type="Car" favoreable-id="{[car.id]}"/>
                                    </favorite-button>

                                </div>

                                <div class="col-sm-6 col-sm-pull-3 column info-box">
                                    <h4>
                                        <a href="/cars/{[ car.id ]}">{[ car.year]} - {[ car.model.brand.name_en ]} - {[ car.model.name_en ]}</a>
                                    </h4>
                                    <p class="distance-box">
                                        <img src="/assets/img/icons/speed-icon.png" class="km-icon" style="width:18px;height:10px"/>
                                        {[ car.mileage ]} KM
                                    </p>
                                    <p class="posted-date-box pull-right">{[ car.created_at | myDateFormat ]}</p>
                                    <a class="more-box text-center" href="/cars/{[ car.id ]}">More Information</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div ng-switch on="loading">
                    <div id="loading" ng-switch-when="true">

                        <style>
                            .spinner {
                                margin: 30px auto 0;
                                width: 70px;
                                text-align: center;
                            }

                            .spinner > div {
                                width:  14px;
                                height: 14px;
                                background-color: rgba(0, 159, 227, 0.83);

                                border-radius: 100%;
                                display: inline-block;
                                -webkit-animation: bouncedelay 1.4s infinite ease-in-out;
                                animation: bouncedelay 1.4s infinite ease-in-out;
                                /* Prevent first frame from flickering when animation starts */
                                -webkit-animation-fill-mode: both;
                                animation-fill-mode: both;
                            }

                            .spinner .bounce1 {
                                -webkit-animation-delay: -0.32s;
                                animation-delay: -0.32s;
                            }

                            .spinner .bounce2 {
                                -webkit-animation-delay: -0.16s;
                                animation-delay: -0.16s;
                            }

                            @-webkit-keyframes bouncedelay {
                                0%, 80%, 100% { -webkit-transform: scale(0.0) }
                                40% { -webkit-transform: scale(1.0) }
                            }

                            @keyframes bouncedelay {
                                0%, 80%, 100% {
                                    transform: scale(0.0);
                                    -webkit-transform: scale(0.0);
                                } 40% {
                                      transform: scale(1.0);
                                      -webkit-transform: scale(1.0);
                                  }
                            }
                        </style>

                        <div class="spinner">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>

                        </div>

                    </div>
                    <div ng-switch-when="false">
                        <div ng-show="emptyRecords"><h1 style="text-align: center">No Records</h1></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>