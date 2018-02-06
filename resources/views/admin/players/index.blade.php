@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Players <a href="/admin/player" class="add">Add Player</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent">
        <table class="datatable">
            <thead>
                <tr>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Debut Year</th>
                    <th>Position</th>
                    <th>Date of Birth</th>
                    <th>Retired</th>
                    <th class="noSort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($playerList as $player)
                <tr>
                    <td>{{ $player->surname }}</td>
                    <td>{{ $player->firstname }}</td>
                    <td>{{ $player->debut_year }}</td>
                    <td>{{ $player->position }}</td>
                    <td>{{ ($player->date_of_birth->getTimestamp())? $player->date_of_birth->format('Y-m-d') : '' }}</td>
                    <td>{{ ($player->retired == 1)? 'Yes' : 'No' }}</td>
                    <td><a href="/admin/player/{{ $player->id }}">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection