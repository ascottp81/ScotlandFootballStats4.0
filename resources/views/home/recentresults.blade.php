@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Recent Results<div class="breadcrumb"><a href="/">Home</a> > <span>Recent Results</span></div></h1>
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
            <div class="searchDetailsRow">
                <div class="searchDetailsHead1">Top Goalscorers:<br /></div>
                @foreach ($topScorers as $player)
                <div class="searchDetailsData1">{{ $player->firstname }} {{ $player->surname }}</div><div class="searchDetailsData2">{{ $player->goalCount }}</div>
                @endforeach
            </div>
            <div class="searchDetailsRow"><div class="searchDetailsData">&nbsp;</div></div>
            <div class="searchDetailsRow">
                <div class="searchDetailsHead1">Top Appearances:<br /></div>
                @foreach ($topAppearances as $player)
                <div class="searchDetailsData1">{{ $player->firstname }} {{ $player->surname }}</div><div class="searchDetailsData2">{{ $player->capCount }}</div>
                @endforeach
            </div>
        </div>
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
                @foreach ($recentResults as $result)
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

        <input type="hidden" id="matchUrl" value="recent-results" />
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dataTable').DataTable({
                "order": [ 0, "desc" ],
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