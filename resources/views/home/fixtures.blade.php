@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">Fixtures<div class="breadcrumb"><a href="/">Home</a> > <span>Fixtures</span></div></h1>
    @foreach ($fixtures as $fixture)
    <div class="fixtureItem">
        <div class="leftFixtureColumn">
            <div class="fixtureDate">{{ $fixture->date->format('D jS F Y') }}</div>
            <div class="fixture">
                <div class="fixtureFlag"><img src="/img/flags/{{ $fixture->home_flag }}.gif" /></div>
                <div class="fixtureString">{{ $fixture->fixture }}</div>
                <div class="fixtureFlag"><img src="/img/flags/{{ $fixture->away_flag }}.gif" /></div>
            </div>
        </div>
        <div class="rightFixtureColumn">
            <div class="fixtureDate">{{ $fixture->competition()->first()->name }}</div>
            <div class="fixtureVenue">{{ $fixture->venue_location }}</div>
            <div class="fixtureKickoff">Kick Off: <span>{{ $fixture->kickoff }}</span></div>
        </div>
    </div>
    @endforeach
@endsection