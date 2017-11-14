@if (config('app.livemedia'))
<iframe title="YouTube video player" class="youtube-player" type="text/html" width="{{ $mainVideo->width }}" height="{{ $mainVideo->height }}" src="{{ $mainVideo->youtube }}" frameborder="0" allowfullscreen></iframe>
@else
<a id="mainPlayer" style="display:block;width:{{ $mainVideo->width }};height:{{ $mainVideo->height }};cursor:pointer;"></a> 
<script type="text/javascript">

flowplayer("mainPlayer", "/js/flowplayer/flowplayer-3.2.5.swf", {
    clip: {
        baseUrl: '{{ $mainVideo->baseurl }}/',
        autoPlay: false,
        autoBuffering: true,
        url: 'storage/videos/clips/{{ $mainVideo->filename }}'
    },
    plugins:{controls:{all: true, playlist: false, time: true, scrubber: true}}
}).onStop( function(){this.unload();});

</script> 
@endif