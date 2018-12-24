@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Strips <a href="/admin/strip" class="add">Add Strip</a><div class="breadcrumb"><a href="/logout">Logout</a></div><div class="breadcrumb"><span>Strips</span></div></h1>
    <div class="cmsContent">
        <table class="datatable">
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Type</th>
                    <th>Colour</th>
                    <th class="noSort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stripList as $strip)
                <tr>
                    <td>{{ $strip->year_from }}</td>
                    <td>{{ $strip->year_to }}</td>
                    <td>{{ $strip->type }}</td>
                    <td>{{ $strip->colour }}</td>
                    <td><a href="/admin/strip/{{ $strip->id }}">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection