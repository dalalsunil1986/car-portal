<div class="result-col col-lg-8 col-md-8 clearfix">
    <div class="row">
        <div class="col-md-12 clearfix">
            <!-- Drop Down Filter-->

            <div class="row sort-row">

                <h3 class="results-title pull-left clearfix">Results</h3>
                <select ng-model="sortorder" class="input-small">
                    <option selected value="-created_at">Newest</option>
                    <option value="+created_at">Oldest</option>
                    <option value="+year">Lower Year</option>
                    <option value="-year">Higher Year</option>
                    <option value="+price">Low Price</option>
                    <option value="-price">High Price</option>
                    <option value="+mileage">Low Mileage</option>
                    <option value="-mileage">High Mileage</option>
                </select>

            </div>
            <div class="result-entry">
                <!--SAMPLE ROW-->
                <div infinite-scroll="getIndex()" infinite-scroll-distance='0' infinite-scroll-disabled='loading'
                     infinite-scroll-parent="true"
                     infinite-scroll-immediate-check="false">
                    <div id="Hf31x6{[car.id]}" class="my-repeat-animation" ng-repeat="car in cars | orderBy:sortorder ">

                        <div class="row car-result-box">
                            <div class="row car-result-box">

                                <div class="col-sm-3 column img-box">
                                    <span ng-show="car.thumbnail">
                                        <a href="#"><img ng-src="/uploads/thumbnail/{[ car.thumbnail.name ]}" class="img-responsive result-image"/></a>
                                    </span>
                                    <span ng-hide="car.thumbnail">
                                        <a href="#"><img src="assets/img/custom/2.jpg" class="img-responsive result-image"/></a>
                                    </span>
                                </div>

                                <div class="col-sm-3 col-sm-push-6 column price-box">
                                    <div class="asking text-center">Asking Price</div>
                                    <div class="price-cost text-center">{[ car.price ]}</div>

                                    <favorite-tpl favoreable-type="Car" favoreable-id="{[car.id]}"/>
                                    </favorite-tpl>
                                </div>

                                <div class="col-sm-6 col-sm-pull-3 column info-box">
                                    <h4>
                                        <a href="/cars/{[ car.id ]}">{[ car.year]} - {[ car.model.brand.name_en ]} - {[ car.model.name_en ]}</a>
                                    </h4>

                                    <p class="distance-box">
                                        <img src="/assets/img/icons/speed-icon.png" class="km-icon" style="width:18px;height:10px"/>
                                        {[ car.mileage ]}
                                    </p>

                                    <p class="posted-date-box pull-right">{[ car.created_at ]}</p>
                                    <a class="more-box text-center" href="/#/cars/{[ car.id ]}">More Information</a>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div ng-switch on="loading">
                    <div ng-if="!hasRecord"><h1>no more records</h1></div>
                    <div ng-switch-when="true">loading...</div>
                </div>
            </div>
        </div>
    </div>
</div>