@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">{{ $history->title }} <a href="/admin/history/{{ $history->url }}/add" class="add">Add Page</a><div class="breadcrumb"><a href="/logout">Logout</a></div><div class="breadcrumb"><a href="/admin/history">History</a> > <span>{{ $history->title }}</span></div></h1>
    <div class="cmsContent">
        <table class="datatable">
            <thead>
            <tr>
                <th>Page No</th>
                <th>Title</th>
                <th class="noSort"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($historyPages as $page)
                <tr>
                    <td>{{ $page->page_no }}</td>
                    <td>{{ $page->title }}</td>
                    <td><a href="/admin/history/page/{{ $page->id }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection