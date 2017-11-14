@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="/js/jquery/jquery.qtip.min.css" type="text/css" media="all" />
    <style type="text/css">
        .matchTooltip {
            border: solid 3px #000066;
            background-color: #000066;
            width: 175px;
        }
        .playerTooltip {
            border: solid 2px #ffffff;
            background-color: #000066;
        }
    </style>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="/js/jquery/jquery.qtip.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ $player->fullname }}<span class="playerYear"> ({{ $player->years }})</span><div class="breadcrumb"><a href="/">Home</a> > <a href="/players/">Players</a> > <a href="/players/{{ Session::get('PlayerListUrl') }}/">{{ Session::get('PlayerList') }}</a> > <span>{{ $player->fullname }}</span></div></h1>
    
    <div class="playerLeftContainer">
        <div class="playerImage">{!! $player->image !!}</div>
        
        <div class="playerDetailsLeft">
            <div class="playerDetailsHolder">
                <div class="playerStatsRow">
                    <div class="playerStatsHeading">Caps:</div>
                    <div class="playerStatsData">{{ $player->caps }}</div>
                    <div class="playerStatsInfo"><img src="/img/info2.png" data-type="appearances" data-id="{{ $player->id }}" class="icon" /></div>
                </div>
                <div class="playerStatsRow">
                    <div class="playerStatsHeading">Goals:</div>
                    <div class="playerStatsData">{{ $player->goals }}</div>
                    <div class="playerStatsInfo">@if ($player->pens > 0)<img src="/img/info2.png" data-type="goals" data-id="{{ $player->id }}" class="icon" />@endif</div>
                </div>
                @if ($player->keeper)
                <div class="playerStatsRow">
                    <div class="playerStatsHeading">Clean&nbsp;Sheets:</div>
                    <div class="playerStatsData">{{ $player->clean_sheets }}</div>
                    <div class="playerStatsInfo"><img src="/img/info2.png" data-type="clean-sheets" data-id="{{ $player->id }}" class="icon" /></div>
                </div>                        
                @endif
                <div class="playerStatsRow"></div>
                <div class="playerStatsRow">
                    <div class="playerStatsSubHeading">Red Cards:</div>
                    <div class="playerStatsSubData">{{ $player->red_cards }}</div>
                </div>
                <div class="playerStatsRow">
                    <div class="playerStatsSubHeading">Yellow Cards:</div>
                    <div class="playerStatsSubData">{{ $player->yellow_cards }}</div>
                </div>
            </div>
            
            <div class="playerDetailsHolder">
                <div class="playerExtraDetailsRow">
                    <div class="playerExtraDetailsHeading">Clubs:</div>
                    <div class="playerExtraDetailsData">{{ $player->clubs }}</div>
                </div>
                @if ($player->position != "")
                <div class="playerExtraDetailsRow">
                    <div class="playerExtraDetailsHeading">Position:</div>
                    <div class="playerExtraDetailsData">{{ $player->position }}</div>
                </div>
                @endif
                @if ($player->date_of_birth != "-0001-11-30 00:00:00")
                <div class="playerExtraDetailsRow">
                    <div class="playerExtraDetailsHeading">Born:</div>
                    <div class="playerExtraDetailsData">{{ $player->date_of_birth->format('j F Y') }}, {{ $player->birthplace }}</div>
                </div>
                @endif
            </div>
        </div>

        @if (file_exists("storage/animations/players/" . $player->id . ".gif"))
        <div style="width:100%; margin-top:10px;display:table-cell;text-align:center;clear:left;float:left;background-image: linear-gradient(#000066, #000066, #0066FF);">
        <img src="/storage/animations/players/{{ $player->id }}.gif" style="height: 250px;" />
        </div>
        @endif
    </div>
    
    <div class="playerMatchDetails">
        <span class="flagTitleLink"><span class="flagTitle"></span>Appearances</span>
        <div class="matchDetailsData">
            <table id="dataTable">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Opponent</th>
                    <th>Competition</th>
                    <th>H/A</th>
                    <th>Result</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($player->appearances()->get() as $appearance)
                    <tr>
                        <td>{{ $appearance->match->date->format('d/m/Y') }}</td>
                        <td>{{ $appearance->match->opponent->name }}</td>
                        <td>{{ $appearance->match->competition->name }}</td>
                        <td>{{ $appearance->match->home_away }}</td>
                        <td>{{ $appearance->match->result }}</td>
                        <td class="matchDetailsInfo">@if ($appearance->player_info)<img id="{{ $appearance->id }}" class="matchIcon" src="/img/info.png">@endif</td>
                        <td><a href="/match-details/{{ $appearance->match->url }}">Details</a></td>
                        <td>{{ $appearance->match->date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <input type="hidden" id="matchUrl" value="player-matches/{{ $player->id }}" />
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
                    { "orderable": false, "targets": 5 },
                    { "orderable": false, "targets": 6 },
                    { "visible": false, "targets": 7 }
                ]
            });
        });
    </script>
@endsection