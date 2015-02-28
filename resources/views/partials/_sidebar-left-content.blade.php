@if(!Auth::check())
    <p class="username-nav">Hello, Guest</p>
@else
    <p class="username-nav">Hi {{ Auth::user()->name }}</p>
    <a href="{{ action('UsersController@getProfile') }}">{!! HTML::image('/assets/img/custom/user_profile_picture.jpg', 'Profile Picture', array('class'=>'profiel_picture_nav img-responsive', 'width'=>'225','height'=>'225')) !!}</a>

    <div class="profile-links">

        @include('module.messages.partials.new_messages_count')
        <a href="{{ action('UsersController@getProfile') }}">
            <div class="user-icon">
                {!! HTML::image('/assets/img/icons/user-icon.png', null , array('width'=>'15', 'height'=>'16')) !!}
            </div>
        </a>
        <a href="cars/create">
            <div class="my-posts-icon">
                {!! HTML::image('/assets/img/icons/post_icon.png', null, array('width'=>'14', 'height'=>'14')) !!}
            </div>
        </a>
    </div>
@endif

<ul class="nav-links">

    <li>
        <a href="{{ action('CarsController@index') }}">
            <div class="icon-container">
                {!! HTML::image('/assets/img/icons/car_icon.png', null , array('class'=>'shift-link-icon nav-icons')) !!}
            </div>
            <span class="shift-link-text">Autos</span></a>
    </li>

    <li>
        <a href="#">
            <div class="icon-container">
                {!! HTML::image('/assets/img/icons/job_icon.png', null , array('class'=>'shift-link-icon nav-icons')) !!}
            </div>
            <span class="shift-link-text">Jobs</span>
        </a>
    </li>

    <li>
        <a href="#">
            <div class="icon-container">
                {!! HTML::image('/assets/img/icons/home_icon.png', null , array('class'=>'shift-link-icon nav-icons')) !!}
            </div>
            <span class="shift-link-text">Realestate</span>
        </a>
    </li>

    <li>
        <a href="#">
            <div class="icon-container">
                {!! HTML::image('/assets/img/icons/travel-icon.png', null , array('class'=>'shift-link-icon nav-icons')) !!}
            </div>
            <span class="shift-link-text">Travel</span>
        </a>
    </li>


    <li><a href="#">
            <div class="icon-container">
                {!! HTML::image('/assets/img/icons/events_icon.png', null , array('class'=>'shift-link-icon nav-icons')) !!}
            </div>
            <span class="shift-link-text">Events</span></a>
    </li>

    <li>
        <a href="#">
            <div class="icon-container">
                {!! HTML::image('/assets/img/icons/electronics-icon.png', null , array('class'=>'shift-link-icon nav-icons')) !!}
            </div>
            <span class="shift-link-text">Electroncis</span>
        </a>
    </li>

</ul>
