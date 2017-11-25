@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Managers<div class="breadcrumb"><a href="/">Home</a> > <span>Managers</span></div></h1>
    <div class="playerImage">
        @if (config('app.livemedia'))
        <!-- Ally MacLeod -->
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:409px;"><div style="overflow:hidden;position:relative;height:0;padding:145.232274% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/3292292?et=Sd_eJWKeS4R_jMJPsoqKgA&viewMoreLink=off&sig=T3VwSZCBpkWrdp7ZSBAEF-lzM1Ht9J9IADkZQCqosek=" width="409" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/3292292" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        <!-- Craig Brown and Andy Roxburgh -->
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:445px;"><div style="overflow:hidden;position:relative;height:0;padding:69.023569% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/79036444?et=QLNvhZigRvh9D52DajHoQQ&viewMoreLink=off&sig=_dWcQM-tZWnR9buc66Vxhrume_jGquPXjZows7eSDDk=" width="445" height="307" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/79036444" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
        <!-- Ally MacLeod -->
        <div class="getty localGetty"><img src="/storage/getty/3292292.jpg" /></div>
        <!-- Craig Brown and Andy Roxburgh -->
        <div class="getty localGetty"><img src="/storage/getty/79036444.jpg" /></div>
        @endif
    </div>
    
    <div class="playersIndexColumn">
        <div class="introText">Since 1954 Scotland have had various men take the manager's role. From the charismatic Ally MacLeod, to the pragmatic Craig Brown.  It started as a part-time role, until 1967 when it became full-time. Prior to then, and for a period from 1954-1958, it was a selection committee that chose the team. </div>

        <div class="playerList">
            <table id="dataTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th class="right">From</th>
                    <th class="right">To</th>
                    <th class="right">Games</th>
                    <th class="right">Win %</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($managers as $manager)
                    <tr>
                        <td>{{ $manager->fullname }}</td>
                        <td class="right">{{ $manager->from }}</td>
                        <td class="right">{{ $manager->to }}</td>
                        <td class="right">{{ $manager->match_count }}</td>
                        <td class="right">{{ $manager->win_percentage }}</td>
                        <td><a href="/managers/{{ $manager->url }}">Details</a></td>
                        <td>{{ $manager->fullname_sort }}</td>
                        <td>{{ $manager->min_date }}</td>
                        <td>{{ $manager->max_date }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    
    <div class="managersRightColumn">
        @if (config('app.livemedia'))
        <!-- Walter Smith -->
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:297px;"><div style="overflow:hidden;position:relative;height:0;padding:150.000000% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/55905743?et=IYqOwuPnTkleXKBiv3qa9w&viewMoreLink=off&sig=kchbs20QJh53ivjAhHbfa-XwOQ-JFYXPZlSjNMQs0Uc=" width="297" height="445" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/55905743" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        <!-- Gordon Strachan -->
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:368px;"><div style="overflow:hidden;position:relative;height:0;padding:120.977597% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/491884606?et=7co87VxdRSBl5HFcxG-DPg&viewMoreLink=off&sig=XjgssKrhHxjxM00HiYvHgQ9GaY6L_TRRVjzyINkB_Ss=" width="368" height="445" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/491884606" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
        <!-- Walter Smith -->
        <div class="getty localGetty"><img src="/storage/getty/55905743.jpg" /></div>
        <!-- Gordon Strachan -->
        <div class="getty localGetty"><img src="/storage/getty/491884606.jpg" /></div>
        @endif
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dataTable').DataTable({
                "order": [ 1, "asc" ],
                "paging": false,
                "searching": false,
                "info": false,
                "columnDefs": [
                    { "orderData": 6, "targets": 0 },
                    { "orderData": 7, "targets": 1 },
                    { "orderData": 8, "targets": 2 },
                    { "orderData": 3, "orderSequence": [ "desc", "asc" ], "targets": 3 },
                    { "orderData": 4, "orderSequence": [ "desc", "asc" ], "targets": 4 },
                    { "orderable": false, "targets": 5 },
                    { "visible": false, "targets": [ 6, 7, 8 ] }
                ]
            });
        });
    </script>
@endsection