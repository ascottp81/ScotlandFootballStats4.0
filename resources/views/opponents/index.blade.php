@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">Opponents<div class="breadcrumb"><a href="/">Home</a> > <span>Opponents</span></div></h1>
    <div class="introText">Scotland have faced many opponents over the years, and this section groups these matches by the opponent.</div>
    <div class="opponentsColumn">
        <div class="opponentsSector">
            <span>{{ $regions[0]->title }}</span>
            {!! $regions[0]->image !!}
            <p class="opponentsImageText">{{ $regions[0]->image_text }}</p>
        </div>
        @foreach ($britishOpponents as $opponent)
        <a href="/opponents/{{ $opponent->url }}" class="opponentLink titleBar"><span class="flag" style="background-image: url('/img/flags/{{ $opponent->flag }}.gif');"></span>{{ $opponent->name }}</a>
        @endforeach
        
        <div class="opponentsSector">
            <span>{{ $regions[1]->title }}</span>
            {!! $regions[1]->image !!}
            <p class="opponentsImageText">{{ $regions[1]->image_text }}</p>
        </div>
        @foreach ($europeOpponents1 as $opponent)
        <a href="/opponents/{{ $opponent->url }}/" class="opponentLink titleBar"><span class="flag" style="background-image: url('/img/flags/{{ $opponent->flag}}.gif');"></span>{{ $opponent->name }}</a>
        @endforeach
    </div>
    <div class="opponentsColumn">
        @foreach ($europeOpponents2 as $opponent)
        <a href="/opponents/{{ $opponent->url }}" class="opponentLink titleBar"><span class="flag" style="background-image: url('/img/flags/{{ $opponent->flag }}.gif');"></span>{{ $opponent->name }}</a>
        @endforeach
    </div>
    <div class="opponentsColumn">
        <div class="opponentsSector">
            <span>{{ $regions[2]->title }}</span>
            {!! $regions[2]->image !!}
            <p class="opponentsImageText">{{ $regions[2]->image_text }}</p>
        </div>
        @foreach ($worldOpponents as $opponent)
        <a href="/opponents/{{ $opponent->url }}" class="opponentLink titleBar"><span class="flag" style="background-image: url('/img/flags/{{ $opponent->flag }}.gif');"></span>{{ $opponent->name }}</a>
        @endforeach
    </div>
@endsection