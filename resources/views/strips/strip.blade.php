@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="/js/jquery/jquery.qtip.min.css" type="text/css" media="all" />
    <style type="text/css">
        .matchTooltip {
            border: solid 3px #000066;
            background-color: #000066;
            width: 180px;
        }
    </style>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="/js/jquery/jquery.qtip.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ $strip->title }}<div class="breadcrumb"><a href="/">Home</a> > <a href="/strips">Strips</a> > <span>{{ $strip->title }}</span></div></h1>
    
    <div class="stripLeftContainer">
        <div class="managerImage">{!! $strip->image !!}</div>
        
        <div class="stripDetailsLeft">
            <div class="stripDetailsHolder">
                <div class="stripImageHolder">
                    <img src="/storage/strips/{{ $strip->url }}.gif" />
                </div>
                <div class="stripCopyright">
                    <p>Copyright <a href="http://www.historicalkits.co.uk" target="_blank">Historical Football Kits</a> and reproduced by kind permission.</p> 
                </div>
                <div class="stripItemHeading">Games:</div>
                <div class="stripItemValue">{{ $strip->matches()->count() }}@if ($strip->complete == 0)+@endif</div>
                <div class="stripItemHeading">Designer:</div>
                <div class="stripItemValue">{{ $strip->designer }}</div> 
                <div class="stripItemHeading">Famous Match:</div>
                <div class="stripItemValue2">{{ $strip->match }}</div> 
                <div class="stripSummaryStatement">{{ $strip->note }}</div>                    
            </div>
            
        </div>
    </div>
    
    <div class="playerMatchDetails">
        <span class="flagTitleLink"><span class="flag"></span>Matches</span>
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
                @foreach ($strip->matches()->get() as $stripMatch)
                    <tr>
                        <td>{{ $stripMatch->match->date->format('d/m/Y') }}</td>
                        <td>{{ $stripMatch->match->opponent->name }}</td>
                        <td>{{ $stripMatch->match->competition->name }}</td>
                        <td>{{ $stripMatch->match->home_away }}</td>
                        <td>{{ $stripMatch->match->result }}</td>
                        <td class="matchDetailsInfo">@if ($stripMatch->strip_info)<img id="{{ $stripMatch->match->id }}" class="stripIcon" src="/img/info.png">@endif</td>
                        <td><a href="/match-details/{{ $stripMatch->match->url }}">Details</a></td>
                        <td>{{ $stripMatch->match->date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <input type="hidden" id="matchUrl" value="strips/{{ $strip->id }}" />
    </div>
    
    <div class="stripVideoContainer">
        <div class="stripVideo">
        @include('partial.minivideo')
        </div>
        <div class="stripVideoData">
            <h2>{{ $video->title }}</h2>
            <p>{{ $video->date->format('jS F Y') }}</p>
            <p>{{ $video->competition->name }}</p>
        </div>
        
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