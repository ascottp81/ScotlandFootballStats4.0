@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Dashboard<div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="dashboardContent">
        <a class="dashboardItem" href="/admin/matches"><i class="fa fa-futbol-o"></i><p>Match Details</p></a>
        <a class="dashboardItem" href="/admin/competitions"><i class="fa fa-trophy"></i><p>Competitions</p></a>
        <a class="dashboardItem" href="/admin/players"><i class="fa fa-male"></i><p>Players</p></a>
        <a class="dashboardItem" href="/admin/rankings"><i class="fa fa-line-chart"></i><p>FIFA Rankings</p></a>
        <a class="dashboardItem" href="/admin/news"><i class="fa fa-newspaper-o"></i><p>News</p></a>
        <a class="dashboardItem" href="menus.php"><i class="fa fa-history"></i><p>History</p></a>
        <a class="dashboardItem" href="menus.php"><i class="fa fa-user"></i><p>Managers</p></a>
        <a class="dashboardItem" href="menus.php"><i class="fa fa-users"></i><p>Strips</p></a>
        <a class="dashboardItem" href="/admin/videos"><i class="fa fa-film"></i><p>Videos</p></a>
        <a class="dashboardItem" href="menus.php"><i class="fa fa-book"></i><p>Articles</p></a>
        <a class="dashboardItem" href="menus.php"><i class="fa fa-globe"></i><p>Opponents</p></a>
        <a class="dashboardItem" href="menus.php"><i class="fa fa-shield"></i><p>Clubs</p></a>
        <a class="dashboardItem" href="menus.php"><i class="fa fa-map-marker"></i><p>Locations</p></a>
        <a class="dashboardItem" href="menus.php"><i class="fa fa-history"></i><p>Past Events</p></a>
        <a class="dashboardItem" href="menus.php"><i class="fa fa-external-link"></i><p>External Links</p></a>
    </div>
@endsection