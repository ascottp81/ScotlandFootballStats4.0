@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Silver Caps (25-49)<div class="breadcrumb"><a href="/">Home</a> > <a href="/players/">Players</a> > <span>Silver Caps (25-49)</span></div></h1>
    <div class="playerImage">
        @if (config('app.livemedia'))
            <!-- Mo Johnston -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:392px;"><div style="overflow:hidden;position:relative;height:0;padding:151.530612% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/78952740?et=-m11veNkQR9TUZUOVk-lQw&viewMoreLink=off&sig=3DP3EGpzNAar5yJm0gS6DiQed6fJcBFpWTuQFKi4aR0=" width="392" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/78952740" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- James McFadden -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:401px;"><div style="overflow:hidden;position:relative;height:0;padding:148.129676% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/2730800?et=XW68mivqQidsefumfUEWtw&viewMoreLink=off&sig=Zos3C6DewT6hx-VMmHxYYHEr7eF6lJjy3GIBt3dwyuc=" width="401" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/2730800" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- Alan Hansen -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:420px;"><div style="overflow:hidden;position:relative;height:0;padding:141.428571% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/174049644?et=ADFGFCg5T2JY1I5jQxF9eg&viewMoreLink=off&sig=tHoLjBHNCDuoYQyHuo8qViJ35duDQsEZOqvC0hk3Ls8=" width="420" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/174049644" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- John Wark -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:446px;"><div style="overflow:hidden;position:relative;height:0;padding:133.183857% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/78983511?et=A8nqc9QgSONzxfbwXtFjvQ&viewMoreLink=off&sig=8Cuf-35YdPgLPuZmh0rgi6FzfZ1NaRImKN8qpNbWOlY=" width="446" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/78983511" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <!-- Mo Johnston -->
            <div class="getty localGetty"><img src="/storage/getty/78952740.jpg" /></div>
            <!-- James McFadden -->
            <div class="getty localGetty"><img src="/storage/getty/2730800.jpg" /></div>
            <!-- Alan Hansen -->
            <div class="getty localGetty"><img src="/storage/getty/174049644.jpg" /></div>
            <!-- John Wark -->
            <div class="getty localGetty"><img src="/storage/getty/78983511.jpg" /></div>
        @endif
    </div>
    
    <div class="playersIndexColumn">
        <div class="introText">Similar to the SFA Hall Of Fame, where a player receives a gold cap for winning 50 caps, if a player wins 25 caps they are awarded a silver cap.  There are many great Scotland players who have not made the SFA Hall Of Fame. Jim Baxter, Jimmy Johnstone and Archie Gemmill have all missed out as have many other great players.</div>   
                    
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
    <input type="hidden" id="playersUrl" value="silver-caps" />	
    
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
            <!-- Archie Gemmill -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:385px;"><div style="overflow:hidden;position:relative;height:0;padding:154.285714% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/78981765?et=5r2qfsURRfhIOQKkkwhGpQ&viewMoreLink=off&sig=mNvbyYHRixyUsF8zWYqWR4sQuHXmJmv3xVwShR3lnOo=" width="385" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/78981765" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- John Robertson -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:395px;"><div style="overflow:hidden;position:relative;height:0;padding:150.379747% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/79046400?et=5S9c9X5JT6RCf15vFwWing&viewMoreLink=off&sig=_v4_e0mazUpkcl5RSu8dAXbo65gj0te2VSbUGC5BFTs=" width="395" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/79046400" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- Andy Goram -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:399px;"><div style="overflow:hidden;position:relative;height:0;padding:148.872180% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1632227?et=1o-eRiSSQp9IIL_ghZ_v2Q&viewMoreLink=off&sig=1Xo97sN0P1jhKO-6pYWxkpSENwi3z4GVakO4HE2WyIw=" width="399" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1632227" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>        
        @else
            <!-- Archie Gemmill -->
            <div class="getty localGetty"><img src="/storage/getty/78981765.jpg" /></div>
            <!-- John Robertson -->
            <div class="getty localGetty"><img src="/storage/getty/79046400.jpg" /></div>
            <!-- Andy Goram -->
            <div class="getty localGetty"><img src="/storage/getty/1632227.jpg" /></div>
        @endif
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dataTable').DataTable({
                "order": [ [1, "desc"],[6, "asc"] ],
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