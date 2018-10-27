@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Competitions <a href="/admin/competition" class="add">Add Competition</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent">
        <table class="dataTableCompetitionType">
            <thead>
            <tr>
                <th class="noSort">Title</th>
                <th class="noSort"></th>
                <th class="noSort"></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($competitionList as $competition)
                <tr>
                    <td>{{ $competition->title }}</td>
                    <td>@if ($competition->title != "Friendly")<a href="/admin/competition/{{ $competition->id }}/versions">Versions</a>@endif</td>
                    <td><a href="/admin/competition/{{ $competition->id }}">Edit</a></td>
                    <td>{{ $competition->priority }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection