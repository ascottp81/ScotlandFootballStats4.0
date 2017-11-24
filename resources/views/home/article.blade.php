@extends('app')

@section('head')
@endsection

@section('content')
    <div class="searchColumn">
        <div class="searchContainer">
            <span class="flagTitleLink"><span class="flagTitle"></span>Match Search</span>
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
        
        <div class="homeArticles">
            @foreach ($articles as $articleLink)
            <a class="articleItem" href="/articles/{{ $articleLink->url }}">{{ $articleLink->link_text }}</a>
            @endforeach
        </div>
    </div>
    
    <div class="homeMiddleColumn">
        <h1 class="fullTitleBar"><span class="flagTitle"></span>{{ $article->title }}</h1>            
        <div class="articleHolder">{!! $article->content !!}</div>
    </div>

    <div class="homeRightColumn">
        <div class="homeTableHolder">
            <a href="/competitions/{{ $homeTable->competition->type->url }}/{{ $homeTable->competition->url }}" class="flagTitleLink"><span class="flagTitle"></span>Group Table</a>
            <div class="homeGroupTitle">{{ $homeTable->competition->name }}</div>
            <div class="homeGroupData">
                <div class="homeTableRow">
                    <div class="homeTableCountry">&nbsp;</div>
                    <div class="homeTableValue">P</div>
                    <div class="homeTableValue">Pts</div>
                </div>
                @foreach ($homeTable->teams()->get() as $row)
                    <div class="homeTableRow">
                        <div class="homeTableCountry">{{ $row->short_team }}</div>
                        <div class="homeTableValue">{{ $row->played }}</div>
                        <div class="homeTableValue">{{ $row->points }}</div>
                    </div>
                @endforeach
            </div>
            <div class="homeGroupFixtures">
                @foreach ($homeTable->table_fixtures_results as $fixture)
                    @if ($fixture["date"] != "")
                        <div class="tableFixturesDate">{{ $fixture["date"] }}</div>
                    @endif
                    <div class="tableFixture">{{ $fixture["fixture"] }}</div>
                @endforeach
            </div>
        </div>

        <div class="pastEvents">
            <p class="title">On this day <span class="eventDate">({{ Carbon\Carbon::now()->format('jS F') }})</span></p>
            @foreach ($events as $event)
                <p><span class="year">{{ $event["year"] }}:</span><br />{{ $event["summary"] }}</p>
            @endforeach
        </div>
    </div>
@endsection