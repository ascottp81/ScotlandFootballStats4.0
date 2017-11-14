@if (config('app.livemedia'))
<iframe title="YouTube video player" class="youtube-player" type="text/html" width="{{ $video->width }}" height="{{ $video->height }}" src="{{ $video->youtube }}" frameborder="0" allowfullscreen></iframe>
@else
<a id="player" style="display:block;width:{{ $video->width }};height:{{ $video->height }};cursor:pointer;"></a> 
<script type="text/javascript">

flowplayer("player", "/js/flowplayer/flowplayer-3.2.5.swf", {
    clip: {
        baseUrl: '{{ $video->baseurl }}/',
        autoPlay: false,
        autoBuffering: true,
        url: 'storage/videos/clips/{{ $video->filename }}'
    },
    plugins:{controls:{all: true, playlist: false, time: false, scrubber: false}}
}).onStop( function(){this.unload();});

</script> 
@endif