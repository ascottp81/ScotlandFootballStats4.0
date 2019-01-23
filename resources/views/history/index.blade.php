@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">History<div class="breadcrumb"><a href="/">Home</a> > <span>History</span></div></h1>
    <div class="introText">Along with England, Scotland are the oldest international football team dating back to 1872. Before WWII, most of Scotland's matches came in the British Championships against the home nations, with games against other nations being a rarity. After WWII Scotland decided to take part in the World Cup for which they have qualified 9 times. They took part in their first European Championships in 1968, and have qualified for the finals on 2 occasions. This section gives a more detailed account of Scotland's history, including success, controversy, and failures.</div>
    @foreach ($chapters as $chapter)
    <div class="history">
        <div class="historyLeft">
            {!! $chapter->image !!}
        </div>
        <div class="historyRight">
            <a href="/history/{{ $chapter->url }}" class="flagTitleLink"><span class="flag"></span>{{ $chapter->title }} {{ $chapter->period }}</a>
            <div class="historyRightSummary"><p>{{ $chapter->summary }}</p></div>
            <div class="historyRightMatches">
                <p class="historyMatchesTitle">Famous Matches:</p>
                @foreach ($chapter->famous_matches as $match)
                <p><span class="historyMatchDate">{{ $match->date->format('d/m/Y') }}</span> <a href="/match-details/{{ $match->url }}">{{ $match->short_scoreline }}</a></p>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
@endsection