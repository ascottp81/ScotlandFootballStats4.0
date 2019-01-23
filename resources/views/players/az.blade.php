@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Players A-Z<div class="breadcrumb"><a href="/">Home</a> > <a href="/players/">Players</a> > <span>Players A-Z</span></div></h1>
    <div class="playerImage">
        @include('partial.azleftimages')
    </div>
    
    <div class="playersIndexColumn">
        <div class="introText">This page contains a record of every player who has played for Scotland in order from A-Z.</div>   
                    
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
                        <td class="right">{{ $player->caps }}</td>
                        <td class="right">{{ $player->goals }}</td>
                        <td class="right">{{ $player->debut_year }}</td>
                        <td class="right">{{ $player->last_year }}</td>
                        <td><a href="/players/{{ $player->id }}/{{ $player->url }}">Details</a></td>
                        <td>{{ $player->fullname_sort }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" id="playersUrl" value="a-z" />
    
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
        @include('partial.azrightimages')
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