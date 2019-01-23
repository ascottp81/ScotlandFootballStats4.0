@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Player Search Results<div class="breadcrumb"><a href="/">Home</a> > <a href="/players/">Players</a> > <span>Search Results</span></div></h1>
    <div class="playerImage">
        <div class="searchDetails">
            <div class="searchDetailsRow"><div class="searchDetailsHead">Name: </div><div class="searchDetailsData">{{ $searchParameters['name'] }}</div></div>
            <div class="searchDetailsRow"><div class="searchDetailsHead">Date From: </div><div class="searchDetailsData">{{ $searchParameters['date_from'] }}</div></div>
            <div class="searchDetailsRow"><div class="searchDetailsHead">Date To: </div><div class="searchDetailsData">{{ $searchParameters['date_to'] }}</div></div>
            <div class="searchDetailsRow"><div class="searchDetailsHead">Manager: </div><div class="searchDetailsData">{{ $searchParameters['manager'] }}</div></div>
            <div class="searchDetailsRow"><div class="searchDetailsHead">Club: </div><div class="searchDetailsData">{{ $searchParameters['club'] }}</div></div>
        </div>
        @if ($url != 'all')
        @if ($filtered)
        <a class="searchFilterLink" href="/players/search/{{ $parameters }}">View Complete Stats</a>
        @else
        <a class="searchFilterLink" href="/players/search/stats=filtered&{{ $parameters }}">View Filtered Stats</a>
        @endif
        @endif
        @if (config('app.livemedia'))
            <!-- John Collins -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:394px;"><div style="overflow:hidden;position:relative;height:0;padding:150.761421% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1632051?et=kXNArBzAQy9ja21PTdWhQw&viewMoreLink=off&sig=P_TVyyoahDS_mhGjF-wVpbutXPZYkb_M0JBuf9YKUmY=" width="394" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1632051" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <!-- John Collins -->
            <div class="getty localGetty"><img src="/storage/getty/1632051.jpg" /></div>
        @endif
    </div>
    
    <div class="playersIndexColumn">
        <div class="introText">
        @if ($filtered)
        The results below show the filtered player stats that only apply to the games that match the specified criteria.  To show the complete stats for all the players that match the specified criteria, click on the link below the search details.
        @else
        The results below show the complete stats for all the players that match the specified criteria.  To show the filtered player stats that only apply to the games that match the specified criteria, click on the link below the search details.
        @endif
        </div>   
                    
        <div class="playerList">
            <table id="dataTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th class="right">Caps</th>
                    <th class="right">Goals</th>
                    <th class="right">From</th>
                    <th class="right">To</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($players as $player)
                    <tr>
                        <td>{{ $player->fullname }}</td>
                        <td class="right">{{ ($filtered)? $player->filtered_caps : $player->caps }}</td>
                        <td class="right">{{ ($filtered)? $player->filtered_goals : $player->goals }}</td>
                        <td class="right">{{ ($filtered)? $player->filtered_first_year : $player->debut_year }}</td>
                        <td class="right">{{ ($filtered)? $player->filtered_last_year : $player->last_year }}</td>
                        <td><a href="/players/{{ $player->id }}/{{ $player->url }}">Details</a></td>
                        <td>{{ $player->fullname_sort }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" id="playersUrl" value="{{ $url }}" />	
    
    <div class="playersRightColumn">
        <div class="searchContainer">
            <span class="flagTitleLink"><span class="flag"></span>Player Search</span>
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
            <!-- Roy Aitken -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:390px;"><div style="overflow:hidden;position:relative;height:0;padding:152.307692% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1219756?et=amO2l11uQyZPGuae08WtPw&viewMoreLink=off&sig=85YXgdiTD6ouX9jcLU_p2CvFiZ2yqhA2aoNk17m9ICY=" width="390" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1219756" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <!-- Roy Aitken -->
            <div class="getty localGetty"><img src="/storage/getty/1219756.jpg" /></div>
        @endif
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dataTable').DataTable({
                "order": [0, "asc"],
                "paging": false,
                "searching": false,
                "info": false,
                "columnDefs": [
                    { "orderData": 6, "targets": 0 },
                    { "orderData": 1, "orderSequence": [ "desc", "asc" ], "targets": 1 },
                    { "orderData": 2, "orderSequence": [ "desc", "asc" ], "targets": 2 },
                    { "orderData": 3, "targets": 3 },
                    { "orderData": 4, "targets": 4 },
                    { "orderable": false, "targets": 5 },
                    { "visible": false, "targets": 6 }
                ]
            });
        });
    </script>
@endsection