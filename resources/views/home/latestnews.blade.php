@extends('app')

@section('head')
@endsection

@section('content')
    <div class="searchColumn">
        <div class="searchContainer">
            <span class="flagTitleLink"><span class="flag"></span>Match Search</span>
            <div class="searchForm">
                <div class="searchFormHeading">Opponent</div>
                <div class="searchFormInput">
                    <select id="opponent">
                        <option value="">Any</option>
                        @foreach ($opponents as $opponent)
                        <option value="{{ $opponent->id }}">{{ $opponent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="searchFormHeading">Date From</div>
                <div class="searchFormInput"><input id="dateFrom" /></div>
                <div class="searchFormHeading">Date To</div>
                <div class="searchFormInput"><input id="dateTo" /></div>
                <div class="searchFormHeading">Venue</div>
                <div class="searchFormInput">
                    <select id="venue">
                        <option value="">Any</option>
                        <option value="H">Home</option>
                        <option value="A">Away</option>
                        <option value="N">Neutral</option>
                    </select>
                </div>
                <div class="searchFormHeading">Result</div>
                <div class="searchFormInput">
                    <select id="result">
                        <option value="">Any</option>
                        <option value="W">Win</option>
                        <option value="L">Lose</option>
                        <option value="D">Draw</option>
                    </select>
                </div>
                <div class="searchFormHeading">Match Type</div>
                <div class="searchFormInput">
                    <select id="matchtype">
                        <option value="">Any</option>
                        <option value="C">Competitive</option>
                        <option value="F">Friendly</option>
                    </select>
                </div>
                
                <a onclick="matchSearch()" class="searchButton">Search</a>
            </div>
        </div>

        <div class="pastEvents">
            <p class="title">On this day <span class="eventDate">({{ Carbon\Carbon::now()->format('jS F') }})</span></p>
            @foreach ($events as $event)
                <p><span class="year">{{ $event["year"] }}:</span><br />{{ $event["summary"] }}</p>
            @endforeach
        </div>
    </div>
    
    <div class="latestNewsContent">
        <h1 class="fullTitleBar">Latest News<div class="breadcrumb"><a href="/">Home</a> > <span>Latest News</span></div></h1>
        
        <div class="newsColumn">
            @foreach ($news as $article)
            <div class="newsArticle">
                <h2><u>{{ $article->title }}</u> <span class="newsDate">({{ $article->date->format('j M Y') }})</span></h2>
                {!! $article->content !!}
            </div>  
            @endforeach 
        </div>
        
        <div class="squadColumn">
            <span class="flagTitleLink"><span class="flag"></span>Squad Details</span>
            <div class="squadContent">
                <h2>{{ $squad->title }}</h2>
                {!! $squad->content !!}
            </div>
        </div>
    </div>  
@endsection