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
        
        <div class="homeArticles">
            @foreach ($articles as $article)
            <a class="articleItem" href="/articles/{{ $article->url }}">{{ $article->link_text }}</a>
            @endforeach
        </div>
    </div>
    
    <div class="homeScroller titleBar">
        <ul id="introTicker">
            <li>ScotlandFootballStats is a website that contains statistics for the Scotland International football team.</li><li>This includes in-depth match stats and player stats, competition details, managerial records, FIFA rankings, and a brief history.</li>
        </ul>
    </div>
    
    <div class="homeMiddleColumn">
        <div class="homeMiddleRow">
            <div class="homeSector">
                <a class="flagTitleLink" href="/latest-news"><span class="flag"></span>Headlines</a>
                <div class="newsHolder">
                @foreach ($news as $article)
                <div class="homeNewsItem">{{ $article->title }}</div>
                @endforeach
                </div>
            </div>
            <div class="homeSector">
            @include('partial.minivideo')
            </div>
        </div>
        <div class="homeMiddleRow">
            <div class="homeSector">
                <a class="flagTitleLink" href="/recent-results"><span class="flag"></span>Recent Results</a>
                @foreach ($recentResults as $result)
                <div class="homeResult">
                    <div class="homeResultDate">{{ $result->date->format('D jS M Y') }}</div>
                    <div class="homeResultScoreline">{{ $result->short_scoreline }}</div>
                    <div class="homeResultDetails"><a href="/match-details/{{ $result->url }}">Match Details</a></div>
                </div>
                @endforeach
            </div>
            <div class="homeSector">
                <a class="flagTitleLink" href="/fixtures"><span class="flag"></span>Fixtures</a>
                @foreach ($fixtures as $fixture)
                <div class="homeResult">
                    <div class="homeResultDate">{{ $fixture->date->format('D jS M Y') }}</div>
                    <div class="homeResultScoreline">{{ $fixture->short_fixture }}</div>
                    <div class="homeResultDetails">Kick Off: {{ $fixture->kickoff }}</div>
                </div>
                @endforeach
                @if ($fixtures->count() == 0)
                <div class="homeResult">
                    <div class="homeResultDetails">There are currently no planned fixtures.</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="homeRightColumn">
        <div class="homeTableHolder">
            <a href="/competitions/{{ $homeTable->competition->type->url }}/{{ $homeTable->competition->url }}" class="flagTitleLink"><span class="flag"></span>Group Table</a>
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
    
    <div class="pictureRow" style="width: 785px;">
        <div class="pictureHolderLeft">
            @if (config('app.livemedia'))
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:445px;"><div style="overflow:hidden;position:relative;height:0;padding:66.329966% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1268648?et=QVh5b7voScZXox4qM4W-og&viewMoreLink=off&sig=K6-1vC9ZFfufB9lgj-9EP8p4qrWpetT2qDf-vwzI0wM=" width="445" height="295" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1268648" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            @else
            <div class="getty localGetty"><img src="/storage/getty/1268648.jpg" /></div>
            @endif
        </div>
        <div class="pictureHolderRight">
            @if (config('app.livemedia'))
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:445px;"><div style="overflow:hidden;position:relative;height:0;padding:66.498316% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/79034687?et=qB4VJsdiR9NTt-KLWHEF7g&viewMoreLink=off&sig=PPhwcBjZPihoI9559kXEWAMblDT89OVpWAmEyKvVX4I=" width="445" height="296" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/79034687" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            @else
            <div class="getty localGetty"><img src="/storage/getty/79034687.jpg" /></div>
            @endif
        </div>
    </div>
@endsection