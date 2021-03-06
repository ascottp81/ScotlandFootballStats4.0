@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Clubs <a href="/admin/clubs" class="add">Add Club</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatableCompetitions">
            <thead>
            <tr>
                <th>Name</th>
                <th class="noSort"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($clubList as $club)
                <tr>
                    <td>{{ $club->name }}</td>
                    <td><a href="/admin/clubs/{{ $club->id }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/club/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="inputRow">
                    <div class="inputHead">Name: </div>
                    <div class="input">
                        <input type="text" id="name" value="{{ old('name') ?? $selectedClub->name ?? '' }}" name="name" />
                        <span class="errorMsg">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/clubs">Cancel</a></div>
            </div>
        </form>
    </div>

@endsection