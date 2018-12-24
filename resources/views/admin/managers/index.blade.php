@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Managers <a href="/admin/manager" class="add">Add Manager</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent">
        <table class="datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th class="noSort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($managerList as $manager)
                <tr>
                    <td>{{ $manager->id }}</td>
                    <td>{{ $manager->surname }}</td>
                    <td>{{ $manager->firstname }}</td>
                    <td>{{ $manager->from }}</td>
                    <td>{{ $manager->to }}</td>
                    <td><a href="/admin/manager/{{ $manager->id }}">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection