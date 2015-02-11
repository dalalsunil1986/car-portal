<div class="filter-col col-lg-4 col-md-4 clearfix ">

    <div class="row">

        <h3 class="row-filter-nav">Filter</h3>

        <!--Make Filter Start-->
        <div class="form-group row">
            <label class="col-xs-3 padding-left">Make</label>

            <ui-select multiple ng-model="filters.selectedMakes" theme="select2" class="col-sm-8 col-xs-9 ">
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
            <ui-select multiple ng-model="filters.selectedBrands " ng-disabled="disabled" theme="select2" class="col-sm-8 col-xs-9">
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
            <ui-select multiple ng-model="filters.selectedTypes" ng-disabled="disabled" theme="select2" class="col-sm-8 col-xs-9">
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
            <ui-select multiple ng-model="filters.selectedModels" ng-disabled="disabled" theme="select2" class="col-sm-8 col-xs-9">
                <ui-select-match placeholder="Select a Model...">{[ $item.name ]}</ui-select-match>
                <ui-select-choices repeat="model.id as model in models  | propsFilter: {name: $select.search}">
                    <div ng-bind-html="model.name | highlight: $select.search"></div>
                </ui-select-choices>
            </ui-select>
        </div>
        <!-- Model Filter End -->

        <div class="form-group row">
            <div class="range-div form-control-inline col-sm-11 col-xs-12">
                <input x-year-slider type="text" />
            </div>
        </div>
        <div class="form-group row">
            <div class="range-div form-control-inline col-sm-11  col-xs-12">
                <input x-mileage-slider slider="slider" filters="filters" type="text"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="range-div form-control-inline col-sm-11 col-xs-12">
                <input x-price-slider type="text"/>
            </div>
        </div>

        <!--Model Filter End-->
        <div class="row">
            <button ng-click="openModal('lg',filters)" class="btn btn-large cd-popup-trigger col-lg-5 hidden-md hidden-sm hidden-xs notify-lg notify-btn">
                <i class="icon-white fa fa-phone "></i> Notify Me
            </button>

            <!--Notify Confirmation Panel End-->

            <button ng-click="refreshCars()" class="btn btn-info btn-large col-lg-6 hidden-md hidden-sm hidden-xs filter-btn" >
                <i class="icon-white fa fa-sort-by-attributes" ></i> Yalla Filter!
            </button>

            <!--Btn Sm Layout-->
            <button ng-click="refreshCars()" class="btn btn-info btn-large col-xs-12 col-sm-11 hidden-lg hidden-xl filter-btn" >
                <i class="icon-white fa fa-sort-by-attributes" ></i> Yalla Filter!
            </button>
            <button ng-click="openModal('lg',filters)" class="btn cd-popup-trigger btn-large col-xs-12 col-sm-11 hidden-lg hidden-xl notify-sm notify-btn">
                <i class="icon-white fa fa-phone  "></i> Notify Me
            </button>
        </div>



    </div>
</div>