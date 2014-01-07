@foreach ($channels as $channel)
    <a href="{{ route('channel.get',
        array(
            'channel'=>($channel->id)
            )) }}"><img title="" src="{{ UI::APP_CDN}}images/channels/{{$channel->img}}"></a>
@endforeach