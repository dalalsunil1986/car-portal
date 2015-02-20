@extends('layouts._three_column')

<!-- Styles -->
@section('style')
    @parent
    {!! HTML::style('assets/css/cars/view.css') !!}
@stop

<!-- Middle Section #content -->
@section('content')
    <div class="row clearfix one-column">

        <!-- Top Navigation -->
        <div class="title">

            <span id="back"><i class="fa fa-arrow-circle-left"></i> <span class="go-back">Go Back</span></span>

            <h1 class="title">Showroom</h1>
        </div>

        <!--Car Details-->
        <div class="car-details">
            <!--Title -->

            <div class="row clearfix result-entry">
                <div class="col-md-9 col-sm-9 column title-color">
                    @if($car->thumbnail)
                        <img class="img-responsive result-image" src="/uploads/thumbnail/{{ $car->thumbnail->name }}">
                    @else
                        <img class="img-responsive result-image" src="/assets/img/custom/car-thumb.jpg">
                    @endif
                    <h3 id="car-title">{{ $car->title }}</h3>
                </div>
                <div class="col-md-3 col-sm-3 column interested-box">
                    <div class="price-cost text-center">{{ $car->price }}</div>
                </div>
            </div>

            <section class="cd-single-item">
                <div class="cd-slider-wrapper">
                    <ul class="cd-slider">
                        @if(count($car->photos))
                            <?php $i=0; ?>
                            @foreach($car->photos as $photo)
                                <li <?php echo $i == 0 ? 'class="selected"' : '' ?>>
                                    <img src="/uploads/large/{{ $photo->name }}" alt="Product Image 1">
                                </li>
                                <?php $i++; ?>
                            @endforeach
                        @else
                            <li class="selected"><img src="/assets/img/custom/sample1.jpg" alt="Product Image 1"></li>
                        @endif
                    </ul> <!-- cd-slider -->

                    <ul class="cd-slider-navigation">
                        <li><a href="#0" class="cd-prev inactive">Next</a></li>
                        <li><a href="#0" class="cd-next">Prev</a></li>
                    </ul> <!-- cd-slider-navigation -->

                    <a href="#0" class="cd-close">Close</a>
                </div> <!-- cd-slider-wrapper -->

                <div class="cd-item-info">


               <dl>
                   <dt>Asking Price</dt>
                   <dd>25,000 KWD</dd>
                   <dt>Mileage</dt>
                   <dd>25,000 km</dd>
                   <dt>Seller</dt>
                   <dd>{{ $car->user->name }}</dd>
                   <dt>Mobile</dt>
                   <dd>+965 652 5445</dd>
               </dl>

                </div> <!-- cd-item-info -->
            </section> <!-- cd-single-item -->

            <section class="cd-content">
                <!--  other content here -->
            </section>



            <!--General Pannel-->
            <div class="row clearfix">
            <div class="col-md-12 column  gen-info">
            <div class="row clearfix">
            <div class="col-md-12 column details-tab">
            <h3>General</h3>
            </div>
            </div>
            <div class="row clearfix bottom-pannel">
            <div class="col-md-6 column description">
            <h4><span class="glyphicon glyphicon-file"></span>Description</h4>

            <p>{{ $car->description }}</p>
             <span>-Posted 12 Days Ago</span>
            </div>
            <div class="col-md-6 column overview">
            <h4><span class="glyphicon glyphicon-list-alt"></span>Overview</h4>
            <ul class="features">
            @foreach($car->tags as $tag)
            <li><a href="">{{ $tag->name }}</a></li>
            @endforeach
            </ul>
            </div>
            </div>
            </div>
            </div>

            <!--Contant Pannel-->
            <div class="row clearfix">
                <div class="col-md-12 column  gen-info">
                    <div class="row clearfix">
                        <div class="col-md-12 column details-tab">
                            <h3>Contact</h3>
                        </div>
                    </div>
                    <div class="row clearfix bottom-pannel">
                        <div class="col-md-6 column">

                            <div class="row clearfix">
                                <div class="col-md-12 column message" id="messageDiv">
                                    <h4><span class="glyphicon glyphicon-comment"></span><i class="fa fa-mail"></i>Message Seller</h4>
                                    <div class="messageAlert"></div>
                                    {!! Form::open(['action' => 'MessagesController@store', 'method' => 'post']) !!}
                                    {!! Form::hidden('messageable_id', $car->id )!!}
                                    {!! Form::hidden('messageable_type', 'Car' )!!}
                                    {!! Form::hidden('recepient_id', $car->user_id )!!}
                                    {!! Form::hidden('subject', $car->title )!!}
                                    {!! Form::textarea('body',null )!!}
                                    {!! Form::submit('Send', ['class' => 'btn btn-primary btn-sm hidden-xs pull-right']) !!}
                                    {!! Form::submit('Send', ['class' => 'btn btn-primary btn-lg btn-block visible-xs']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
    @parent



    <script>
        /*! jQuery Mobile v1.4.5 | Copyright 2010, 2014 jQuery Foundation, Inc. | jquery.org/license */

        (function(e,t,n){typeof define=="function"&&define.amd?define(["jquery"],function(r){return n(r,e,t),r.mobile}):n(e.jQuery,e,t)})(this,document,function(e,t,n,r){(function(e,t,n,r){function T(e){while(e&&typeof e.originalEvent!="undefined")e=e.originalEvent;return e}function N(t,n){var i=t.type,s,o,a,l,c,h,p,d,v;t=e.Event(t),t.type=n,s=t.originalEvent,o=e.event.props,i.search(/^(mouse|click)/)>-1&&(o=f);if(s)for(p=o.length,l;p;)l=o[--p],t[l]=s[l];i.search(/mouse(down|up)|click/)>-1&&!t.which&&(t.which=1);if(i.search(/^touch/)!==-1){a=T(s),i=a.touches,c=a.changedTouches,h=i&&i.length?i[0]:c&&c.length?c[0]:r;if(h)for(d=0,v=u.length;d<v;d++)l=u[d],t[l]=h[l]}return t}function C(t){var n={},r,s;while(t){r=e.data(t,i);for(s in r)r[s]&&(n[s]=n.hasVirtualBinding=!0);t=t.parentNode}return n}function k(t,n){var r;while(t){r=e.data(t,i);if(r&&(!n||r[n]))return t;t=t.parentNode}return null}function L(){g=!1}function A(){g=!0}function O(){E=0,v.length=0,m=!1,A()}function M(){L()}function _(){D(),c=setTimeout(function(){c=0,O()},e.vmouse.resetTimerDuration)}function D(){c&&(clearTimeout(c),c=0)}function P(t,n,r){var i;if(r&&r[t]||!r&&k(n.target,t))i=N(n,t),e(n.target).trigger(i);return i}function H(t){var n=e.data(t.target,s),r;!m&&(!E||E!==n)&&(r=P("v"+t.type,t),r&&(r.isDefaultPrevented()&&t.preventDefault(),r.isPropagationStopped()&&t.stopPropagation(),r.isImmediatePropagationStopped()&&t.stopImmediatePropagation()))}function B(t){var n=T(t).touches,r,i,o;n&&n.length===1&&(r=t.target,i=C(r),i.hasVirtualBinding&&(E=w++,e.data(r,s,E),D(),M(),d=!1,o=T(t).touches[0],h=o.pageX,p=o.pageY,P("vmouseover",t,i),P("vmousedown",t,i)))}function j(e){if(g)return;d||P("vmousecancel",e,C(e.target)),d=!0,_()}function F(t){if(g)return;var n=T(t).touches[0],r=d,i=e.vmouse.moveDistanceThreshold,s=C(t.target);d=d||Math.abs(n.pageX-h)>i||Math.abs(n.pageY-p)>i,d&&!r&&P("vmousecancel",t,s),P("vmousemove",t,s),_()}function I(e){if(g)return;A();var t=C(e.target),n,r;P("vmouseup",e,t),d||(n=P("vclick",e,t),n&&n.isDefaultPrevented()&&(r=T(e).changedTouches[0],v.push({touchID:E,x:r.clientX,y:r.clientY}),m=!0)),P("vmouseout",e,t),d=!1,_()}function q(t){var n=e.data(t,i),r;if(n)for(r in n)if(n[r])return!0;return!1}function R(){}function U(t){var n=t.substr(1);return{setup:function(){q(this)||e.data(this,i,{});var r=e.data(this,i);r[t]=!0,l[t]=(l[t]||0)+1,l[t]===1&&b.bind(n,H),e(this).bind(n,R),y&&(l.touchstart=(l.touchstart||0)+1,l.touchstart===1&&b.bind("touchstart",B).bind("touchend",I).bind("touchmove",F).bind("scroll",j))},teardown:function(){--l[t],l[t]||b.unbind(n,H),y&&(--l.touchstart,l.touchstart||b.unbind("touchstart",B).unbind("touchmove",F).unbind("touchend",I).unbind("scroll",j));var r=e(this),s=e.data(this,i);s&&(s[t]=!1),r.unbind(n,R),q(this)||r.removeData(i)}}}var i="virtualMouseBindings",s="virtualTouchID",o="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),u="clientX clientY pageX pageY screenX screenY".split(" "),a=e.event.mouseHooks?e.event.mouseHooks.props:[],f=e.event.props.concat(a),l={},c=0,h=0,p=0,d=!1,v=[],m=!1,g=!1,y="addEventListener"in n,b=e(n),w=1,E=0,S,x;e.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500};for(x=0;x<o.length;x++)e.event.special[o[x]]=U(o[x]);y&&n.addEventListener("click",function(t){var n=v.length,r=t.target,i,o,u,a,f,l;if(n){i=t.clientX,o=t.clientY,S=e.vmouse.clickDistanceThreshold,u=r;while(u){for(a=0;a<n;a++){f=v[a],l=0;if(u===r&&Math.abs(f.x-i)<S&&Math.abs(f.y-o)<S||e.data(u,s)===f.touchID){t.preventDefault(),t.stopPropagation();return}}u=u.parentNode}}},!0)})(e,t,n),function(e){e.mobile={}}(e),function(e,t){var r={touch:"ontouchend"in n};e.mobile.support=e.mobile.support||{},e.extend(e.support,r),e.extend(e.mobile.support,r)}(e),function(e,t,r){function l(t,n,i,s){var o=i.type;i.type=n,s?e.event.trigger(i,r,t):e.event.dispatch.call(t,i),i.type=o}var i=e(n),s=e.mobile.support.touch,o="touchmove scroll",u=s?"touchstart":"mousedown",a=s?"touchend":"mouseup",f=s?"touchmove":"mousemove";e.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight scrollstart scrollstop".split(" "),function(t,n){e.fn[n]=function(e){return e?this.bind(n,e):this.trigger(n)},e.attrFn&&(e.attrFn[n]=!0)}),e.event.special.scrollstart={enabled:!0,setup:function(){function s(e,n){r=n,l(t,r?"scrollstart":"scrollstop",e)}var t=this,n=e(t),r,i;n.bind(o,function(t){if(!e.event.special.scrollstart.enabled)return;r||s(t,!0),clearTimeout(i),i=setTimeout(function(){s(t,!1)},50)})},teardown:function(){e(this).unbind(o)}},e.event.special.tap={tapholdThreshold:750,emitTapOnTaphold:!0,setup:function(){var t=this,n=e(t),r=!1;n.bind("vmousedown",function(s){function a(){clearTimeout(u)}function f(){a(),n.unbind("vclick",c).unbind("vmouseup",a),i.unbind("vmousecancel",f)}function c(e){f(),!r&&o===e.target?l(t,"tap",e):r&&e.preventDefault()}r=!1;if(s.which&&s.which!==1)return!1;var o=s.target,u;n.bind("vmouseup",a).bind("vclick",c),i.bind("vmousecancel",f),u=setTimeout(function(){e.event.special.tap.emitTapOnTaphold||(r=!0),l(t,"taphold",e.Event("taphold",{target:o}))},e.event.special.tap.tapholdThreshold)})},teardown:function(){e(this).unbind("vmousedown").unbind("vclick").unbind("vmouseup"),i.unbind("vmousecancel")}},e.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:30,verticalDistanceThreshold:30,getLocation:function(e){var n=t.pageXOffset,r=t.pageYOffset,i=e.clientX,s=e.clientY;if(e.pageY===0&&Math.floor(s)>Math.floor(e.pageY)||e.pageX===0&&Math.floor(i)>Math.floor(e.pageX))i-=n,s-=r;else if(s<e.pageY-r||i<e.pageX-n)i=e.pageX-n,s=e.pageY-r;return{x:i,y:s}},start:function(t){var n=t.originalEvent.touches?t.originalEvent.touches[0]:t,r=e.event.special.swipe.getLocation(n);return{time:(new Date).getTime(),coords:[r.x,r.y],origin:e(t.target)}},stop:function(t){var n=t.originalEvent.touches?t.originalEvent.touches[0]:t,r=e.event.special.swipe.getLocation(n);return{time:(new Date).getTime(),coords:[r.x,r.y]}},handleSwipe:function(t,n,r,i){if(n.time-t.time<e.event.special.swipe.durationThreshold&&Math.abs(t.coords[0]-n.coords[0])>e.event.special.swipe.horizontalDistanceThreshold&&Math.abs(t.coords[1]-n.coords[1])<e.event.special.swipe.verticalDistanceThreshold){var s=t.coords[0]>n.coords[0]?"swipeleft":"swiperight";return l(r,"swipe",e.Event("swipe",{target:i,swipestart:t,swipestop:n}),!0),l(r,s,e.Event(s,{target:i,swipestart:t,swipestop:n}),!0),!0}return!1},eventInProgress:!1,setup:function(){var t,n=this,r=e(n),s={};t=e.data(this,"mobile-events"),t||(t={length:0},e.data(this,"mobile-events",t)),t.length++,t.swipe=s,s.start=function(t){if(e.event.special.swipe.eventInProgress)return;e.event.special.swipe.eventInProgress=!0;var r,o=e.event.special.swipe.start(t),u=t.target,l=!1;s.move=function(t){if(!o||t.isDefaultPrevented())return;r=e.event.special.swipe.stop(t),l||(l=e.event.special.swipe.handleSwipe(o,r,n,u),l&&(e.event.special.swipe.eventInProgress=!1)),Math.abs(o.coords[0]-r.coords[0])>e.event.special.swipe.scrollSupressionThreshold&&t.preventDefault()},s.stop=function(){l=!0,e.event.special.swipe.eventInProgress=!1,i.off(f,s.move),s.move=null},i.on(f,s.move).one(a,s.stop)},r.on(u,s.start)},teardown:function(){var t,n;t=e.data(this,"mobile-events"),t&&(n=t.swipe,delete t.swipe,t.length--,t.length===0&&e.removeData(this,"mobile-events")),n&&(n.start&&e(this).off(u,n.start),n.move&&i.off(f,n.move),n.stop&&i.off(a,n.stop))}},e.each({scrollstop:"scrollstart",taphold:"tap",swipeleft:"swipe.left",swiperight:"swipe.right"},function(t,n){e.event.special[t]={setup:function(){e(this).bind(n,e.noop)},teardown:function(){e(this).unbind(n)}}})}(e,this)});
        jQuery(document).ready(function($){
            var itemInfoWrapper = $('.cd-single-item');

            itemInfoWrapper.each(function(){
                var container = $(this),
                // create slider pagination
                        sliderPagination = createSliderPagination(container);

                container.find('.cd-slider').on('click', function(event){
                    //enlarge slider images
                    if( !container.hasClass('cd-slider-active') && $(event.target).is('.cd-slider')) {
                        itemInfoWrapper.removeClass('cd-slider-active');
                        container.addClass('cd-slider-active').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
                            $('body,html').animate({'scrollTop':container.offset().top}, 200);
                        });
                    }
                });

                container.find('.cd-close').on('click', function(){
                    //shrink slider images
                    container.removeClass('cd-slider-active');
                });

                //update visible slide
                container.find('.cd-next').on('click', function(){
                    nextSlide(container, sliderPagination);
                });

                container.find('.cd-prev').on('click', function(){
                    prevSlide(container, sliderPagination);
                });

                container.find('.cd-slider').on('swipeleft', function(){
                    var wrapper = $(this),
                            bool = enableSwipe(container);
                    if(!wrapper.find('.selected').is(':last-child') && bool) {nextSlide(container, sliderPagination);}
                });

                container.find('.cd-slider').on('swiperight', function(){
                    var wrapper = $(this),
                            bool = enableSwipe(container);
                    if(!wrapper.find('.selected').is(':first-child') && bool) {prevSlide(container, sliderPagination);}
                });

                sliderPagination.on('click', function(){
                    var selectedDot = $(this);
                    if(!selectedDot.hasClass('selected')) {
                        var selectedPosition = selectedDot.index(),
                                activePosition = container.find('.cd-slider .selected').index();
                        if( activePosition < selectedPosition) {
                            nextSlide(container, sliderPagination, selectedPosition);
                        } else {
                            prevSlide(container, sliderPagination, selectedPosition);
                        }
                    }
                });
            });

            //keyboard slider navigation
            $(document).keyup(function(event){
                if(event.which=='37' && $('.cd-slider-active').length > 0 && !$('.cd-slider-active .cd-slider .selected').is(':first-child')) {
                    prevSlide($('.cd-slider-active'), $('.cd-slider-active').find('.cd-slider-pagination li'));
                } else if( event.which=='39' && $('.cd-slider-active').length && !$('.cd-slider-active .cd-slider .selected').is(':last-child')) {
                    nextSlide($('.cd-slider-active'), $('.cd-slider-active').find('.cd-slider-pagination li'));
                } else if(event.which=='27') {
                    itemInfoWrapper.removeClass('cd-slider-active');
                }
            });

            function createSliderPagination($container){
                var wrapper = $('<ul class="cd-slider-pagination"></ul>').insertAfter($container.find('.cd-slider-navigation'));
                $container.find('.cd-slider li').each(function(index){
                    var dotWrapper = (index == 0) ? $('<li class="selected"></li>') : $('<li></li>'),
                            dot = $('<a href="#0"></a>').appendTo(dotWrapper);
                    dotWrapper.appendTo(wrapper);
                    dot.text(index+1);
                });
                return wrapper.children('li');
            }

            function nextSlide($container, $pagination, $n){
                var visibleSlide = $container.find('.cd-slider .selected'),
                        navigationDot = $container.find('.cd-slider-pagination .selected');
                if(typeof $n === 'undefined') $n = visibleSlide.index() + 1;
                visibleSlide.removeClass('selected');
                $container.find('.cd-slider li').eq($n).addClass('selected').prevAll().addClass('move-left');
                navigationDot.removeClass('selected')
                $pagination.eq($n).addClass('selected');
                updateNavigation($container, $container.find('.cd-slider li').eq($n));
            }

            function prevSlide($container, $pagination, $n){
                var visibleSlide = $container.find('.cd-slider .selected'),
                        navigationDot = $container.find('.cd-slider-pagination .selected');
                if(typeof $n === 'undefined') $n = visibleSlide.index() - 1;
                visibleSlide.removeClass('selected')
                $container.find('.cd-slider li').eq($n).addClass('selected').removeClass('move-left').nextAll().removeClass('move-left');
                navigationDot.removeClass('selected');
                $pagination.eq($n).addClass('selected');
                updateNavigation($container, $container.find('.cd-slider li').eq($n));
            }

            function updateNavigation($container, $active) {
                $container.find('.cd-prev').toggleClass('inactive', $active.is(':first-child'));
                $container.find('.cd-next').toggleClass('inactive', $active.is(':last-child'));
            }

            function enableSwipe($container) {
                var mq = window.getComputedStyle(document.querySelector('.cd-slider'), '::before').getPropertyValue('content');
                return ( mq=='mobile' || $container.hasClass('cd-slider-active'));
            }
        });
    </script>
@stop