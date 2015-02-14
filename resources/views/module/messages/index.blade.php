@extends('layouts._three_column')

@section('style')
    {!! HTML::style('packages/select2/select2.css') !!}
    @parent
    {!! HTML::style('assets/css/modules/inbox.css') !!}
@stop

@section('content')

    <div class="one-column">

        <div class="title">

            <span id="back"><i class="fa fa-arrow-circle-left"></i> <span class="go-back">Go Back</span></span>

            <h1 class="title">Inbox</h1>
        </div>

        <div class="row clearfix">

            @foreach($threads as $thread)

                <div class="col-md-12 column message-title seen-message">
                    <h2><a href="{{action('MessagesController@show',$thread->id)}}">{{ $thread->subject }} </a>
                    </h2>
                    <span class="delete-message-btn cd-popup-trigger"><a href="#">Delete</a></span>
                </div>

                <div class="col-md-12 column message-preview">
                    <img src="//www.gravatar.com/avatar/{{ $thread->latestMessage->user->email }}?s=50" class="profile-picture-inbox pull-left" width="50" height="50">

                    <div class="message-text">
                        <p>{{ $thread->latestMessage->body }}</p>

                        <small>-{{ $thread->latestMessage->user->name }}  {{ $thread->created_at->diffForHumans() }} </small>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@stop