@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Current Players<div class="breadcrumb"><a href="/">Home</a> > <a href="/players/">Players</a> > <span>Current Players</span></div></h1>
    <div class="playerImage">
        @if (config('app.livemedia'))
            <!-- Leigh Griffiths -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:Roboto,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:396px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.co.uk/detail/659131072" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:150% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/659131072?et=cV29JfuRToBOwD3-Xo44Sw&tld=co.uk&sig=V1Imnxw2kNtzSEWpq4nWs2ziDgd2d0R1FFQBsarhUzE=&caption=true&ver=1" scrolling="no" frameborder="0" width="396" height="594" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div></div>
            <!-- Andrew Robertson -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:Roboto,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:406px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.co.uk/detail/694752506" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:146.30542% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/694752506?et=CuvX7rORQFp671hLwRKK9g&tld=co.uk&sig=En2wq_dLhZyGYthgMcE9vqoCpLZSsmFUAn8S_keF0HE=&caption=true&ver=1" scrolling="no" frameborder="0" width="406" height="594" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div></div>
            <!-- James Morrison -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:446px;"><div style="overflow:hidden;position:relative;height:0;padding:133.183857% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/454989336?et=KazHrP7ISeRWKNUCDp7vBQ&viewMoreLink=off&sig=n5ep4LvraephSaqKrc5qUKe0wuIBPW_dlNCghwJCxpw=" width="446" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/454989336" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <!-- Leigh Griffiths -->
            <div class="getty localGetty"><img src="/storage/getty/659131072.jpg" /></div>
            <!-- Andrew Robertson -->
            <div class="getty localGetty"><img src="/storage/getty/694752506.jpg" /></div>
            <!-- James Morrison -->
            <div class="getty localGetty"><img src="/storage/getty/454989336.jpg" /></div>
        @endif
    </div>
    
    <div class="playersIndexColumn">
        <div class="introText">This section contains a list of all of the players who are currently playing for Scotland. This also includes players who may be called up to the squad but may not have been capped recently.</div>   
                    
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
    <input type="hidden" id="playersUrl" value="current-players" />	
    
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
            <!-- Ikechi Anya -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:446px;"><div style="overflow:hidden;position:relative;height:0;padding:133.183857% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/454989620?et=vtrUbI2rQ1pSTvvyUvRwwQ&viewMoreLink=off&sig=7aDgIaBztSCQD6p2Sgx8r8VBSGN9HfyxtLHGkjvosCs=" width="446" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/454989620" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- Darren Fletcher -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:429px;"><div style="overflow:hidden;position:relative;height:0;padding:138.461538% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/83243649?et=cOdrSFMvSpNn-ddVuNCcbw&viewMoreLink=off&sig=AABsMxVQgypEcnQ_rKbFJihgIvwLhbK_PjAXBbs2Jkk=" width="429" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/83243649" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <!-- Ikechi Anya -->
            <div class="getty localGetty"><img src="/storage/getty/454989620.jpg" /></div>
            <!-- Darren Fletcher -->
            <div class="getty localGetty"><img src="/storage/getty/83243649.jpg" /></div>
        @endif
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dataTable').DataTable({
                "order": [ [4, "desc"],[6, "asc"] ],
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