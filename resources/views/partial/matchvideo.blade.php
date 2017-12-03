@if (config('app.livemedia'))
<iframe title="YouTube video player" class="youtube-player" type="text/html" width="710px" height="423px" src="{{ $match->videos->first()->youtube }}" frameborder="0" allowfullscreen></iframe>
@else
<a id="mainPlayer" style="display:block;width:710px;height:423px;cursor:pointer;"></a>
<script type="text/javascript">

flowplayer("mainPlayer", "/js/flowplayer/flowplayer-3.2.5.swf", {
    clip: {
        baseUrl: '{{ config('app.url') }}/',
        autoPlay: false,
        autoBuffering: true,
        url: 'storage/videos/clips/{{ $match->videos->first()->filename }}'
    },
    plugins:{controls:{all: true, playlist: false, time: true, scrubber: true}}
}).onStop( function(){this.unload();});

</script> 
@endif