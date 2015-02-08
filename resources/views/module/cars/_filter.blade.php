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
        <notification-tpl type="Car"/>
        </notification-tpl>


    </div>
</div>