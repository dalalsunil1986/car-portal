<div class="nano" id="left" ng-controller="FavoritesController">
    {!! HTML::image('assets/img/icons/plus_icon.png', 'Interested icon', array('class'=>'plus-icon','width'=>'15','height'=>'14')) !!}

    <h3 class="int-title">Favorites</h3>
    <div ng-repeat="favorite in favorites" class="int-container">
        <favorite-panel favorite="favorite"></favorite-panel>
    </div>
</div>