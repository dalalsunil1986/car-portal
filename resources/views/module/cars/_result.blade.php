<div class="result-col col-lg-8 col-md-8 clearfix" id="filter">
    <div class="row">
        <div class="col-md-12 clearfix">
            <!-- Drop Down Filter-->
            <div class="row sort-row">
                <h3 class="results-title clearfix">Results</h3>



                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <select ng-model="sortorder">
                            <option selected="selected" value="-created_at">Upload Date : New to Old</option>
                            <option value="+created_at">Upload Date : Old to New</option>
                            <option value="-year">Year: New to Old</option>
                            <option value="+year">Year: Old to New</option>
                            <option value="-price">Price: High to Low</option>
                            <option value="+price">Price: Low to High</option>
                            <option value="-mileage">Mileage : High to Low</option>
                            <option value="+mileage">Mileage: Low to High</option>
                        </select>
                        <span class="caret"></span>
                    </button>
                </div>
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
                                    <p class="posted-date-box">{[ car.created_at | myDateFormat ]}</p>
                                    <a class="more-box text-center" href="/cars/{[ car.id ]}">More Information</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <loader loading="loading" empty-records="emptyRecords"></loader>

            </div>
        </div>
    </div>
</div>