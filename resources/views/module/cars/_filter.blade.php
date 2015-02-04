<div class="filter-col col-lg-4 col-md-4 clearfix ">

    <div class="row">

        <h3 class="row-filter-nav">Filter</h3>

        <!--Make Filter Start-->
        <div class="form-group row">
            <label class="col-xs-3 padding-left">Make</label>

            <ui-select multiple ng-model="filter.selectedMakes" theme="select2" class="col-sm-8 col-xs-9 ">
                <ui-select-match placeholder="Select a Make...">{[ $item.name ]}</ui-select-match>
                <ui-select-choices repeat="make.id as make in makes | propsFilter: {name: $select.search} ">
                    <div ng-bind-html="make.name | highlight: $select.search"></div>
                </ui-select-choices>
            </ui-select>
        </div>
        <!--Make Filter End-->

        <!--Brand Filter Start-->
        <div class="form-group row fit-screen">
            <label class="col-xs-3 padding-left">Brand</label>
            <ui-select multiple ng-model="filter.selectedBrands " ng-disabled="disabled" theme="select2" class="col-sm-8 col-xs-9">
                <ui-select-match placeholder="Select a Brand...">{[ $item.name ]}</ui-select-match>
                <ui-select-choices repeat="brand.id as brand in brands | propsFilter: {name: $select.search}">
                    <div ng-bind-html="brand.name | highlight: $select.search"></div>
                </ui-select-choices>
            </ui-select>
        </div>
        <!--Brand Filter Start-->

        <!--Type Filter Start-->
        <div class="form-group row fit-screen">
            <label class="col-xs-3 padding-left">Type</label>
            <ui-select multiple ng-model="filter.selectedTypes" ng-disabled="disabled" theme="select2" class="col-sm-8 col-xs-9">
                <ui-select-match placeholder="Select a Type...">{[ $item.name ]}</ui-select-match>
                <ui-select-choices repeat="type.id as type in types  | propsFilter: {name: $select.search}">
                    <div ng-bind-html="type.name | highlight: $select.search"></div>
                </ui-select-choices>
            </ui-select>
        </div>
        <!--Type Filter End-->

        <!--Model Filter Start-->
        <div class="form-group row">
            <label class="col-xs-3 padding-left">Model</label>
            <ui-select multiple ng-model="filter.selectedModels" ng-disabled="disabled" theme="select2" class="col-sm-8 col-xs-9">
                <ui-select-match placeholder="Select a Model...">{[ $item.name ]}</ui-select-match>
                <ui-select-choices repeat="model.id as model in models  | propsFilter: {name: $select.search}">
                    <div ng-bind-html="model.name | highlight: $select.search"></div>
                </ui-select-choices>
            </ui-select>
        </div>
        <!-- Model Filter End -->

        <div class="form-group row">
            <div class="range-div form-control-inline col-sm-11 col-xs-12">
                <input x-year-slider type="text"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="range-div form-control-inline col-sm-11  col-xs-12">
                <input x-mileage-slider type="text"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="range-div form-control-inline col-sm-11 col-xs-12">
                <input x-price-slider type="text"/>
            </div>
        </div>

        <!--Model Filter End-->
        <div class="row">
            <button ng-click="toggleModal()" class="btn btn-large cd-popup-trigger col-lg-5 hidden-md hidden-sm hidden-xs notify-lg notify-btn">
                <i class="icon-white fa fa-phone "></i> Notify Me
            </button>

            <!--Notify Confirmation Panel Start-->
            <modal div class="cd-popup" role="alert" visible="showModal">
                <div class="cd-popup-container">
                    <h3>NotifyMe</h3>

                    <p> NotifyMe will automatically send you a notification when a new submission matches your criteria.</p>
                    <dl>
                        <div class="row">
                            <h4>I am looking for:</h4>

                            <div class="col-xs-6">
                                <dt>Make:</dt>
                                <dd>
                                    <span ng-repeat="make in selectedMakeNames">{[make.name]} {[ $last ? '' : ', ']} </span>
                                </dd>
                                <dt>Brand:</dt>
                                <dd>
                                    <span ng-repeat="brand in selectedBrandNames">{[brand.name]} {[ $last ? '' : ', ']} </span>
                                </dd>
                                <dt>Type:</dt>
                                <dd>
                                    <span ng-repeat="type in selectedTypeNames">{[type.name]} {[ $last ? '' : ', ']} </span>
                                </dd>
                                <dt>Model:</dt>
                                <dd>
                                    <span ng-repeat="model in selectedModelNames">{[model.name]} {[ $last ? '' : ', ']} </span>
                                </dd>
                            </div>

                            <div class="col-xs-6">
                                <dt>Price:</dt>
                                <dd>{[priceFrom]} - {[priceTo]}</dd>
                                <dt>Year:</dt>
                                <dd>{[yearFrom]} - {[yearTo]}</dd>
                                <dt>Mileage:</dt>
                                <dd>{[mileageFrom]} - {[mileageTo]}</dd>
                            </div>
                        </div>
                    </dl>
                    <div class="row">
                        <p class="checkbox-title">Notify me by:</p>

                        <div class="col-xs-5">
                            <input type="checkbox" checked> <span> E-Mail </span>
                        </div>
                        <div class="col-xs-2">OR</div>
                        <div class="col-xs-5">
                            <input class="sms-checkbox" type="checkbox"> <span> SMS Message </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 notifyMe-notification-bar">
                            <span id="sms-rate-notify">Standard text messaging rates may apply. Check with your provider.</span>
                            <span id="no-mobile-number-message">Update profile with your mobile number to use sms feature.</span>
                        </div>
                    </div>
                    <ul class="cd-buttons">
                        <li><a class="cd-close" href="#0">Cancel</a></li>
                        <li><a class="cd-save" href="#0">Save</a></li>

                    </ul>
                    <a href="#0" class="cd-popup-close img-replace"></a>
                </div>
                <!-- cd-popup-container -->
            </modal>
            <!-- cd-popup -->

            <!--Notify Confirmation Panel End-->

            <button type="submit" class="btn btn-info btn-large col-lg-6 hidden-md hidden-sm hidden-xs filter-btn">
                <i class="icon-white fa fa-sort-by-attributes" id="submit" name="submit" ng-click="initCars()"></i> Yalla Filter!
            </button>

            <!--Btn Sm Layout-->
            <button class="btn btn-info btn-large col-xs-12 col-sm-11 hidden-lg hidden-xl filter-btn">
                <i class="icon-white fa fa-sort-by-attributes"></i> Yalla Filter!
            </button>
            <button class="btn cd-popup-trigger btn-large col-xs-12 col-sm-11 hidden-lg hidden-xl notify-sm notify-btn" data-toggle="modal" data-target="#notify-modal">
                <i class="icon-white fa fa-phone"></i> Notify Me
            </button>
        </div>

    </div>
</div>