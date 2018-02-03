@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Match Details <a href="/admin/fixture" class="add">Add Fixture</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent">
        <table class="datatableMatches">
            <thead>
            <tr>
                <th>Date</th>
                <th>Opponent</th>
                <th>Competition</th>
                <th>HA</th>
                <th>Attendance</th>
                <th>Result</th>
                <th class="noSort"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($matchList as $match)
                <tr>
                    <td>{{ $match->date->format('Y-m-d') }}</td>
                    <td>{{ $match->opponent->name }}</td>
                    <td>{{ $match->competition->name }}</td>
                    <td>{{ $match->ha }}&nbsp;&nbsp;&nbsp;</td>
                    <td>{{ $match->attendance }}</td>
                    <td>{{ $match->result }}</td>
                    <td><a href="/admin/{{ ($match->date > date('Y-m-d 00:00:00')) ? 'fixture' : 'match' }}/{{ $match->id }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection