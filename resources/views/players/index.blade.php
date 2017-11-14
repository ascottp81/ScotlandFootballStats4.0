@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">Players<div class="breadcrumb"><a href="/">Home</a> > <span>Players</span></div></h1>
    <div class="playerImage">
        @if (config('app.livemedia'))
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:256px;"><div style="overflow:hidden;position:relative;height:0;padding:232.031250% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/93713666?et=JknYjBYBSbZ44a0LeHaDkA&viewMoreLink=off&sig=uJgAB82Fs65tQYczjj6FH6hp58P3lMkDJH0D_WqRmo8=" width="256" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/93713666" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <div class="getty localGetty"><img src="/storage/getty/93713666.jpg" /></div>
        @endif
    </div>

    <div class="playersIndexColumn">
        <div class="introText">Many players have pulled on the dark blue of Scotland and represented their country. This section contains details of every player including appearances and goals. There are also details of every match that each player has played and scored in.</div>

        <div class="playerListSector">
            <a href="/players/a-z" class="flagTitleLink"><span class="flagTitle"></span>Players A-Z</a>
            <div class="playerListSectorSummary">An A-Z of every player who has played for Scotland.</div>
        </div>
        <div class="playerListSector">
            <a href="/players/sfa-hall-of-fame" class="flagTitleLink"><span class="flagTitle"></span>SFA Hall of Fame</a>
            <div class="playerListSectorSummary">A record of every player who has won 50+ caps for Scotland, gained a gold cap and entered into the SFA Hall Of Fame.</div>
        </div>
        <div class="playerListSector">
            <a href="/players/silver-caps" class="flagTitleLink"><span class="flagTitle"></span>Silver Caps (25-49)</a>
            <div class="playerListSectorSummary">A record of every player who has won 25-49 caps for Scotland and obtained a silver cap.</div>
        </div>
        <div class="playerListSector">
            <a href="/players/leading-goalscorers" class="flagTitleLink"><span class="flagTitle"></span>Leading Goalscorers</a>
            <div class="playerListSectorSummary">A record of every player who has scored at least 5 goals for Scotland.</div>
        </div>
        <div class="playerListSector">
            <a href="/players/current-players" class="flagTitleLink"><span class="flagTitle"></span>Current Players</a>
            <div class="playerListSectorSummary">A record of every player that still plays for Scotland.</div>
        </div>

    </div>

    <div class="playersRightColumn">
        <div class="searchContainer">
            <span class="flagTitleLink"><span class="flagTitle"></span>Player Search</span>
            <div class="searchForm">
                <div class="searchFormHeading">Name</div>
                <div class="searchFormInput"><input id="playername" /></div>
                <div class="searchFormHeading">Date From</div>
                <div class="searchFormInput"><input id="dateFrom" /></div>
                <div class="searchFormHeading">Date To</div>
                <div class="searchFormInput"><input id="dateTo" /></div>
                <div class="searchFormHeading">Manager</div>
                <div class="searchFormInput">
                    <select id="manager">
                        <option value="">Any</option>
                        @foreach ($managers as $manager)
                            <option value="{{ $manager->id }}">{{ $manager->fullname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="searchFormHeading">Club</div>
                <div class="searchFormInput">
                    <select id="club">
                        <option value="">Any</option>
                        @foreach ($clubs as $club)
                            <option value="{{ $club->id }}">{{ $club->name }}</option>
                        @endforeach
                    </select>
                </div>

                <a class="searchButton" onclick="playerSearch()">Search</a>
            </div>
        </div>

        @if (config('app.livemedia'))
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:513px;"><div style="overflow:hidden;position:relative;height:0;padding:115.789474% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/474205464?et=Lvy-2R5qTUJeT49BSYT5QQ&viewMoreLink=off&sig=GtnIzHCPUG_ftjyuS1IYpFsTX4oYlHKCctjEQ-inON4=" width="513" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/474205464" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <div class="getty localGetty"><img src="/storage/getty/474205464.jpg" /></div>
        @endif
    </div>
@endsection