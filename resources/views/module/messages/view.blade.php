@extends('layouts._three_column')

<!-- Styles -->
@section('style')
    @parent
    {!! HTML::style('assets/css/modules/inbox.css') !!}
@stop

@section('content')

    <div class="one-column">
        <div class="title">

            <span id="back"><i class="fa fa-arrow-circle-left"></i> <span class="go-back">Go Back to Inbox</span></span>

            <h1 class="title">Message</h1>

        </div>

        <div class="row clearfix">

            <div class="col-md-12 column message-unit">

                <div class="row clearfix">
                    <div class="col-md-12 column message-title new-message">
                        <h2>{{ $thread->subject }}</h2>
                        <span class="delete-message-btn cd-popup-trigger"><a href="#">Delete</a></span>
                    </div>
                </div>

                <div class="row clearfix message-preview">
                    <div class="col-md-12 column">

                        @foreach($thread->messages as $message)
                            <div class="row">
                                <div class=" col-md-1 {{ ($message->user->id == Auth::user()->id) ? 'message-text pull-left ' : 'reply-text pull-right' }}">
                                    <img src="//www.gravatar.com/avatar/{{$message->user->email}}?s=50"
                                         class="profile-picture-inbox-view" width="50" height="50">
                                </div>

                                <div class=" col-md-10 {{ ($message->user->id == Auth::user()->id) ? 'message-text pull-left' : 'reply-text pull-right' }}">
                                    <p>{{ $message->body }}</p>

                                    <small>{{ $message->user->name }}
                                        - {{ $message->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach

                        <div class="row">

                            <div class="col-md-12 reply-area">
                        {!! Form::open(['action' => ['MessagesController@update',$thread->id], 'method' => 'PATCH']) !!}

                        {!! Form::textarea('body',null,['class'=>'col-xs-12 send-message-input']) !!}

                        {!! Form::submit('Send', ['class' => 'btn col-xs-12 pull-right send-button']) !!}

                        {!! Form::close() !!}



                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


@stop
