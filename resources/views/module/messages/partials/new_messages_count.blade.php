<a href="{{ action('MessagesController@index') }}">
    <div class="mail-icon">
        {!! HTML::image('/assets/img/icons/mail_icon.png') !!}
        @if($newMessagesCount)
            <div class="mail-count">{{ $newMessagesCount }} </div>
        @endif
    </div>
</a>