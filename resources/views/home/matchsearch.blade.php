@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Match Search Results<div class="breadcrumb"><a href="/">Home</a> > <span>Match Search Results</span></div></h1>
    <div class="matchListSearch">
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
        </div>
        
        <div class="matchSearchDetails">
            <div class="searchDetailsRow"><div class="searchDetailsHead">Opponent: </div><div class="searchDetailsData">{{ $searchParameters['opponent'] }}</div></div>
            <div class="searchDetailsRow"><div class="searchDetailsHead">Date From: </div><div class="searchDetailsData">{{ $searchParameters['date_from'] }}</div></div>
            <div class="searchDetailsRow"><div class="searchDetailsHead">Date To: </div><div class="searchDetailsData">{{ $searchParameters['date_to'] }}</div></div>
            <div class="searchDetailsRow"><div class="searchDetailsHead">Venue: </div><div class="searchDetailsData">{{ $searchParameters['venue'] }}</div></div>
            <div class="searchDetailsRow"><div class="searchDetailsHead">Result: </div><div class="searchDetailsData">{{ $searchParameters['result'] }}</div></div>
            <div class="searchDetailsRow"><div class="searchDetailsHead">Match Type: </div><div class="searchDetailsData">{{ $searchParameters['match_type'] }}</div></div>
        </div>
        
        @if ($matchNumbers['played'] > 25)
        @if (config('app.livemedia'))
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:445px;"><div style="overflow:hidden;position:relative;height:0;padding:72.727273% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/79037566?et=ZqLB4ifVQ6hEzRWkgb6p1g&viewMoreLink=off&sig=QlQdXSNZe3cFBer1tWVo6LCaXtimgfJiyWtagAOKQ28=" width="445" height="324" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/79037566" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
        <div class="getty localGetty"><img src="/storage/getty/79037566.jpg" /></div>
        @endif
        @endif
    </div>
    
    <div class="searchMatchDetails">
        <div class="matchDetailsData">
            <table id="dataTable">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Opponent</th>
                    <th>Competition</th>
                    <th>H/A</th>
                    <th class="right">Att.</th>
                    <th>Result</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($searchResults as $result)
                    <tr>
                        <td>{{ $result->date->format('d/m/Y') }}</td>
                        <td>{{ $result->opponent->name }}</td>
                        <td>{{ $result->competition->name }}</td>
                        <td>{{ $result->home_away }}</td>
                        <td class="right">{{ $result->attendance }}</td>
                        <td>{{ $result->result }}</td>
                        <td><a href="/match-details/{{ $result->url }}">Details</a></td>
                        <td>{{ $result->date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <span class="matchListCount">
            <span class="countHeading">Played:</span> {{ $matchNumbers['played'] }}
            <span class="countHeading">Won:</span> {{ $matchNumbers['won'] }}
            <span class="countHeading">Drew:</span> {{ $matchNumbers['drew'] }}
            <span class="countHeading">Lost:</span> {{ $matchNumbers['lost'] }}
            <span class="countHeading">For:</span> {{ $matchNumbers['for'] }}
            <span class="countHeading">Against:</span> {{ $matchNumbers['against'] }}
            <span class="countHeading">GD:</span> {{ $matchNumbers['goal_difference'] }}
        </span>
        <input type="hidden" id="matchUrl" value="match-search/{{ $parameters }}" />
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dataTable').DataTable({
                "order": [ 0, "asc" ],
                "paging": false,
                "searching": false,
                "info": false,
                "columnDefs": [
                    { "orderData": 7, "targets": 0 },
                    { "orderData": [ 1, 7 ], "targets": 1 },
                    { "orderData": [ 2, 7 ], "targets": 2 },
                    { "orderData": [ 3, 7 ], "targets": 3 },
                    { "orderData": [ 4, 7 ], "targets": 4 },
                    { "orderData": [ 5, 7 ], "targets": 5 },
                    { "orderable": false, "targets": 6 },
                    { "visible": false, "targets": 7 }
                ]
            });
        });
    </script>
@endsection