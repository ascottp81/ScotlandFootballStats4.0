@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">{{ (is_null($match->result)) ? $match->fixture : $match->sitemap_scoreline }}<div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="dashboardContent">
        <a class="dashboardItem" href="/admin/match/{{ $match->id }}/basic"><i class="fa fa-edit"></i><p>Basic Details</p></a>
        <a class="dashboardItem" href="/admin/match/{{ $match->id }}/lineup"><i class="fa fa-users"></i><p>Lineup</p></a>
        <a class="dashboardItem" href="/admin/match/{{ $match->id }}/strips"><i class="fa fa-user"></i><p>Strip Details</p></a>
        <a class="dashboardItem" href="/admin/match/{{ $match->id }}/summary"><i class="fa fa-newspaper-o"></i><p>Summary</p></a>
        <a class="dashboardItem" href="/admin/match/{{ $match->id }}/stats"><i class="fa fa-line-chart"></i><p>Extra Stats</p></a>
        <a class="dashboardItem" href="/admin/match/{{ $match->id }}/incidents"><i class="fa fa-history"></i><p>Incidents</p></a>
        <a class="dashboardItem" href="/admin/match/{{ $match->id }}/penalties"><i class="fa fa-futbol-o"></i><p>Penalties</p></a>
        <a class="dashboardItem" href="/admin/match/{{ $match->id }}/other"><i class="fa fa-sticky-note-o"></i><p>Other</p></a>
    </div>
@endsection