<p class="username-nav">Hi Muahmmad!</p>
{!! HTML::image('/assets/img/custom/user_profile_picture.jpg', 'Profile Picture', array('class'=>'profiel_picture_nav img-responsive', 'width'=>'225','height'=>'225')) !!}

<!--Start Profile Links-->

<div class="profile-links">
    <div class="mail-icon">
        <a href="{{ action('MessagesController@index') }}">{!! HTML::image('/assets/img/icons/mail_icon.png') !!}</a>
        <div class="mail-count"> 5 </div>
    </div>
    <div class="user-icon">
        <a href="{{ action('UsersController@getProfile') }}">{!! HTML::image('/assets/img/icons/user-icon.png', null , array('width'=>'15', 'height'=>'16')) !!}</a>
    </div>
    <div class="my-posts-icon">
        {!! HTML::image('/assets/img/icons/post_icon.png', null, array('width'=>'14', 'height'=>'14')) !!}
    </div>
</div>
<!--End Profile Links-->
<!--Start Navigation Links-->

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
                {!! HTML::image('/assets/img/icons/directory_icon.png', null , array('class'=>'shift-link-icon nav-icons')) !!}
            </div>
            <span class="shift-link-text">Direcotry</span>
        </a>
    </li>
    <li><a href="#">
            <div class="icon-container">
                {!! HTML::image('/assets/img/icons/events_icon.png', null , array('class'=>'shift-link-icon nav-icons')) !!}
            </div>
            <span class="shift-link-text">Events</span></a>
    </li>
</ul>
