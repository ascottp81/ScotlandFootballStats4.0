@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ $competition->name }}<div class="breadcrumb"><a href="/">Home</a> > <a href="/competitions/">Competitions</a> > <span>{{ $competition->name }}</span></div></h1>
    <div class="introText">{{ $competitionType->summary }}</div>
    @foreach ($matches as $match)
    <div class="fixtureItem">
        <div class="leftFixtureColumn">
            <div class="fixtureDate">{{ $match->date->format('D jS F Y') }}</div>
            <div class="fixture">
                <div class="fixtureFlag"><img src="/img/flags/{{ $match->home_flag }}.gif" /></div>
                <div class="fixtureString">{{ $match->scoreline }}</div>
                <div class="fixtureFlag"><img src="/img/flags/{{ $match->away_flag }}.gif" /></div>
            </div>
        </div>
        <div class="rightFixtureColumn">
            <div class="fixtureSpacer"></div>
            <div class="fixtureKickoff">Attendance: <span>{{ $match->attendance }}</span></div>
            <div class="fixtureMatchDetails"><a href="/match-details/{{ $match->url }}">Match Details</a></div>
        </div>
    </div>
    @endforeach
@endsection