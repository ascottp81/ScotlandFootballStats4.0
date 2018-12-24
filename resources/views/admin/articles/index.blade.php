@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Articles <a href="/admin/articles/details" class="add">Add Article</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent">
        <table class="datatableMatches">
            <thead>
                <tr>
                    <th>Title</th>
                    <th class="noSort"></th>
                    <th class="noSort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articleList as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td><a href="/admin/articles/details/{{ $article->id }}">Edit</a></td>
                    <td><a href="javascript:deleteArticle({{ $article->id }})">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection