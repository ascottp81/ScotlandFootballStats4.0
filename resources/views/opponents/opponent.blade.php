@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Scotland v {{ $opponent->name }}<div class="breadcrumb"><a href="/">Home</a> > <a href="/opponents">Opponents</a> > <span>{{ $opponent->name }}</span></div></h1>
    <div class="opponentLeft">
        <div class="opponentSummary">
            <div class="opponentTitle"><span class="opponentFlag" style="background-image: url('/img/flags/{{ $opponent->flag }}.gif');"></span>{{ $opponent->name }} <span class="opponentYears">{{ $opponent->years }}</span></div>
            <p>{{ $opponent->summary }}</p>
        
            <table cellspacing="0px">
                <tr class="countHeading">
                    <td colspan="2"></td>
                    <td colspan="5" class="countSeparator">Home</td>
                    <td colspan="5" class="countSeparator">Away</td>
                    <td colspan="2" class="countSeparator">&nbsp;</td>
                </tr>
                <tr class="countHeading"><td></td>
                    <td>P</td>
                    <td class="countSeparator">W</td>
                    <td>D</td>
                    <td>L</td>
                    <td>F</td>
                    <td>A</td>
                    <td class="countSeparator">W</td>
                    <td>D</td>
                    <td>L</td>
                    <td>F</td>
                    <td>A</td>
                    <td class="countSeparator">GD</td>
                    <td>Win&nbsp;%</td>
                </tr>
                <tr>
                    <th>All&nbsp;Matches</th>
                    <td>{{ $matchNumbers['played'] }}</td>
                    <td class="countSeparator">{{ $homeMatchNumbers['won'] }}</td>
                    <td>{{ $homeMatchNumbers['drew'] }}</td>
                    <td>{{ $homeMatchNumbers['lost'] }}</td>
                    <td>{{ $homeMatchNumbers['for'] }}</td>
                    <td>{{ $homeMatchNumbers['against'] }}</td>
                    <td class="countSeparator">{{ $awayMatchNumbers['won'] }}</td>
                    <td>{{ $awayMatchNumbers['drew'] }}</td>
                    <td>{{ $awayMatchNumbers['lost'] }}</td>
                    <td>{{ $awayMatchNumbers['for'] }}</td>
                    <td>{{ $awayMatchNumbers['against'] }}</td>
                    <td class="countSeparator">{{ $matchNumbers['goal_difference'] }}</td>
                    <td>{{ $matchNumbers['win_percent'] }}</td>
                </tr>
                <tr>
                    <th>Competitive</th>
                    <td>{{ $matchNumbersComp['played'] }}</td>
                    <td class="countSeparator">{{ $homeMatchNumbersComp['won'] }}</td>
                    <td>{{ $homeMatchNumbersComp['drew'] }}</td>
                    <td>{{ $homeMatchNumbersComp['lost'] }}</td>
                    <td>{{ $homeMatchNumbersComp['for'] }}</td>
                    <td>{{ $homeMatchNumbersComp['against'] }}</td>
                    <td class="countSeparator">{{ $awayMatchNumbersComp['won'] }}</td>
                    <td>{{ $awayMatchNumbersComp['drew'] }}</td>
                    <td>{{ $awayMatchNumbersComp['lost'] }}</td>
                    <td>{{ $awayMatchNumbersComp['for'] }}</td>
                    <td>{{ $awayMatchNumbersComp['against'] }}</td>
                    <td class="countSeparator">{{ $matchNumbersComp['goal_difference'] }}</td>
                    <td>{{ $matchNumbersComp['win_percent'] }}</td>
                </tr>
            </table>
            
            @if ($opponent->memorable_match != '')
            <p class="opponentMatch"><span class="opponentHeading">Memorable Match: </span><br />{{ $opponent->memorable_match }}</p>   
            @endif
        </div>
        <div class="opponentImage">{!! $opponent->image !!}</div>
    </div>
    
    <div class="playerMatchDetails opponentMatchDetails">
        <div class="matchDetailsData">
            <table id="dataTable">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Competition</th>
                    <th>H/A</th>
                    <th class="right">Att.</th>
                    <th>Result</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($matchList as $match)
                    <tr>
                        <td>{{ $match->date->format('d/m/Y') }}</td>
                        <td>{{ $match->competition->name }}</td>
                        <td>{{ $match->home_away }}</td>
                        <td class="right">{{ $match->attendance }}</td>
                        <td>{{ $match->result }}</td>
                        <td><a href="/match-details/{{ $match->url }}">Details</a></td>
                        <td>{{ $match->date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
                    { "orderData": 6, "targets": 0 },
                    { "orderData": [ 1, 6 ], "targets": 1 },
                    { "orderData": [ 2, 6 ], "targets": 2 },
                    { "orderData": [ 3, 6 ], "targets": 3 },
                    { "orderData": [ 4, 6 ], "targets": 4 },
                    { "orderable": false, "targets": 5 },
                    { "visible": false, "targets": 6 }
                ]
            });
        });
    </script>
@endsection