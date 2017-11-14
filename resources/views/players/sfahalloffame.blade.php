@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">SFA Hall Of Fame<div class="breadcrumb"><a href="/">Home</a> > <a href="/players/">Players</a> > <span>SFA Hall Of Fame</span></div></h1>
    <div class="playerImage">
        @if (config('app.livemedia'))
            <!-- Kenny Dalglish -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:390px;"><div style="overflow:hidden;position:relative;height:0;padding:152.307692% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1628649?et=zZdZC0V9QzddYo2I3N4nTw&viewMoreLink=off&sig=nf4IS1suhqDWsfh6etkZqJD66Cfgg0cYT5Je9_BmwOk=" width="390" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1628649" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- Jim Leighton -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:420px;"><div style="overflow:hidden;position:relative;height:0;padding:141.428571% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/79649374?et=yoiCTnhCT4ZO3AlEsSRG-Q&viewMoreLink=off&sig=JJC5FmUhpFiRqsoi4GHGB6vLuuyp8hez9aF4iAkgWWw=" width="420" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/79649374" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <!-- Kenny Dalglish -->
            <div class="getty localGetty"><img src="/storage/getty/1628649.jpg" /></div>
            <!-- Jim Leighton -->
            <div class="getty localGetty"><img src="/storage/getty/79649374.jpg" /></div>
        @endif
    </div>
    
    <div class="playersIndexColumn">
        <div class="introText">The SFA Hall Of Fame is a list of every player who has gained at least 50 caps for Scotland. What is also called the International Roll of Honour, was set up in February 1988, and at that stage it only comprised of 11 players. There are now {{ $players->count() }} players in the SFA Hall Of Fame. When a player is entered into the SFA Hall Of Fame, they are awarded with a gold cap and their portrait is hung in the Scottish Football Museum at Hampden Park. It is often a tradition for the player to wear the captain's armband on their 50th cap, but it is not always the case.</div>   
                    
        <div class="playerList">
            <table id="dataTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th class="right">Caps</th>
                    <th class="right">Goals</th>
                    <th class="right">From</th>
                    <th class="right">To</th>
                    <th class="right">Entry</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($players as $player)
                    <tr>
                        <td>{{ $player->fullname }}</td>
                        <td class="right">{{ $player->caps }}</td>
                        <td class="right">{{ $player->goals }}</td>
                        <td class="right">{{ $player->debut_year }}</td>
                        <td class="right">{{ $player->last_year }}</td>
                        <td class="right">{{ $player->hof_entry }}</td>
                        <td><a href="/players/{{ $player->id }}/{{ $player->url }}">Details</a></td>
                        <td>{{ $player->fullname_sort }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" id="playersUrl" value="sfa-hall-of-fame" />	
    
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
            <!-- Alex McLeish -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:404px;"><div style="overflow:hidden;position:relative;height:0;padding:147.029703% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/89113476?et=IGVXHccjT2NJKpId1ZX-2w&viewMoreLink=off&sig=lw4wEdVSLsAWwzR87S80UCvcHiDT8ssWyObXz34IWsU=" width="404" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/89113476" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>        
        @else
            <!-- Alex McLeish -->
            <div class="getty localGetty"><img src="/storage/getty/89113476.jpg" /></div>
        @endif
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dataTable').DataTable({
                "order": [ [1, "desc"], [7, "asc"] ],
                "paging": false,
                "searching": false,
                "info": false,
                "columnDefs": [
                    { "orderData": 7, "targets": 0 },
                    { "orderData": 1, "orderSequence": [ "desc", "asc" ], "targets": 1 },
                    { "orderData": 2, "orderSequence": [ "desc", "asc" ], "targets": 2 },
                    { "orderData": 3, "targets": 3 },
                    { "orderData": 4, "targets": 4 },
                    { "orderData": 5, "targets": 5 },
                    { "orderable": false, "targets": 6 },
                    { "visible": false, "targets": 7 }
                ]
            });
        });
    </script>
@endsection