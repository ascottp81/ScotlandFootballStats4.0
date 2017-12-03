@if (config('app.livemedia'))
<iframe title="YouTube video player" class="youtube-player" type="text/html" width="{{ $videoDimensions["width"] }}" height="{{ $videoDimensions["height"] }}" src="{{ $video->youtube }}" frameborder="0" allowfullscreen></iframe>
@else
<a id="player" style="display:block;width:{{ $videoDimensions["width"] }};height:{{ $videoDimensions["height"] }};cursor:pointer;"></a>
<script type="text/javascript">

flowplayer("player", "/js/flowplayer/flowplayer-3.2.5.swf", {
    clip: {
        baseUrl: '{{ config('app.url') }}/',
        autoPlay: false,
        autoBuffering: true,
        url: 'storage/videos/clips/{{ $video->filename }}'
    },
    plugins:{controls:{all: true, playlist: false, time: false, scrubber: false}}
}).onStop( function(){this.unload();});

</script> 
@endif