@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Leading Goalscorers<div class="breadcrumb"><a href="/">Home</a> > <a href="/players/">Players</a> > <span>Leading Goalscorers</span></div></h1>
    <div class="playerImage">
        @if (config('app.livemedia'))
            <!-- Kenny Dalglish -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:362px;"><div style="overflow:hidden;position:relative;height:0;padding:164.088398% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1632319?et=TNw225bCSERY5bVmJjcQkg&viewMoreLink=off&sig=pkZEEazvi1AKrX8XsAckBsZQSo0lqOPMVSdQRAvXTzk=" width="362" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1632319" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- Ally McCoist -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:402px;"><div style="overflow:hidden;position:relative;height:0;padding:147.761194% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/79034694?et=92FkSCFfS9pEwteUjmAEzw&viewMoreLink=off&sig=1KT4Do9oCW1p-eqfvfhc4K8rtkOjvbl7jUKJHTDHkyo=" width="402" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/79034694" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- Joe Jordan -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:422px;"><div style="overflow:hidden;position:relative;height:0;padding:140.758294% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/78982535?et=7wrI01tSQMNlNV5WnjHJzQ&viewMoreLink=off&sig=sNmeKYgUeD9FbVgpPX98rnNi4Jkt3aGPXBoQruNO2zE=" width="422" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/78982535" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- Denis Law -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:445px;"><div style="overflow:hidden;position:relative;height:0;padding:66.498316% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/80747156?et=dOKpD6vJRfpuZlS1p-jQtw&viewMoreLink=off&sig=tqp3mX9W7OY5Ifo2sD7moULSBkV41BIAcWQTEoGmmS8=" width="445" height="296" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/80747156" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <!-- Kenny Dalglish -->
            <div class="getty localGetty"><img src="/storage/getty/1632319.jpg" /></div>
            <!-- Ally McCoist -->
            <div class="getty localGetty"><img src="/storage/getty/79034694.jpg" /></div>
            <!-- Joe Jordan -->
            <div class="getty localGetty"><img src="/storage/getty/78982535.jpg" /></div>
            <!-- Denis Law -->
            <div class="getty localGetty"><img src="/storage/getty/80747156.jpg" /></div>
        @endif
    </div>
    
    <div class="playersIndexColumn">
        <div class="introText">There have been may great goalscorers for Scotland over the years, and this page contains a record of every player who has scored 5 or more goals for Scotland.</div>   
                    
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
    <input type="hidden" id="playersUrl" value="leading-goalscorers" />	
    
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
            <!-- Kenny Miller -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:396px;"><div style="overflow:hidden;position:relative;height:0;padding:150.000000% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/176552159?et=KeCymVNgThtxVXNMKqq9tg&viewMoreLink=off&sig=4spLnlY5Dnnt5MCStiJWWnJjGucnx1t4pGiOSqRAFV0=" width="396" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/176552159" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- James McFadden -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:396px;"><div style="overflow:hidden;position:relative;height:0;padding:150.000000% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/76890491?et=XpkBlpEzQVVQWPc7rwhegQ&viewMoreLink=off&sig=ZiUM1oZoImFTeZ-a6EXEEILIe7d7cBypk_MZAXeTy2I=" width="396" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/76890491" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            <!-- Mo Johnston -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:399px;"><div style="overflow:hidden;position:relative;height:0;padding:148.872180% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1628520?et=LII2uyU-Q_pK4-vmvEY2lQ&viewMoreLink=off&sig=7jpikeZJ1ZebOxrRdfZcumbpVlYvb-tuY0qumXtG_tU=" width="399" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1628520" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
            <!-- Kenny Miller -->
            <div class="getty localGetty"><img src="/storage/getty/176552159.jpg" /></div>
            <!-- James McFadden -->
            <div class="getty localGetty"><img src="/storage/getty/76890491.jpg" /></div>
            <!-- Mo Johnston -->
            <div class="getty localGetty"><img src="/storage/getty/1628520.jpg" /></div>
        @endif
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dataTable').DataTable({
                "order": [ [2, "desc"],[6, "asc"] ],
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