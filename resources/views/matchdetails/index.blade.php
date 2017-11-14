@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/fancybox/dist/jquery.fancybox.css">
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ $match->scoreline }}<span class="scorelineComment">{!! $match->result_comment !!}</span><div class="breadcrumb"><a href="{{ $match->breadcrumb['url'] }}">{{ $match->breadcrumb['text'] }}</a> > <a href="{{ Session::get('MatchListUrl') }}">{{ Session::get('MatchList') }}</a> > <span>{{ $match->scoreline }}, {{ $match->date->format('Y') }}</span></div></h1>
    <div id="matchDetails">
        <ul>
            <li><a href="#basic" class="tabLink">Match Details</a></li>
            <li><a href="#lineup" class="tabLink">Lineup &amp; Formation</a></li>
            @if ($mainVideo->count())
            <li><a href="#highlights" class="tabLink">Highlights</a></li>
            @endif
            @if ($match->incidents->count() && !config('app.livemedia'))
            <li><a href="#summary" class="tabLink">Summary &amp; Timeline</a></li>
            @elseif ($match->summary)
            <li><a href="#summary" class="tabLink">Match Summary</a></li>
            @endif
            @if ($match->picture_count > 0)
            <li><a class="tabLink" id="pictures">Images</a></li>
            @endif
            <div class="tabLink tabLinkSize{{ $match->empty_tabs }}"></div>
        </ul>
        @include('matchdetails.matchdetails')
        @include('matchdetails.lineup')
        @if ($mainVideo->count())
        @include('matchdetails.highlights')
        @endif
        @if ($match->incidents->count() || $match->summary)
        @include('matchdetails.summary')
        @endif
    </div>
@endsection

@section('footer')
    <!-- Fancybox 3 -->
    <!-- http://fancyapps.com/fancybox/3/docs/ -->
    <script src="/js/fancybox/dist/jquery.fancybox.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#pictures").click(function() {
                $.fancybox.open([
                    @foreach($match->pictures as $image)
                    { src : '/storage/matches/{{ $match->id }}/{{ $image }}' },
                    @endforeach
                ], {
                    loop : true,
                    buttons : [
                        'slideShow',
                        'thumbs',
                        'close'
                    ],
                    slideShow : {
                        autoStart : false,
                        speed     : 2000
                    },
                });
            });
        });
    </script>
@endsection