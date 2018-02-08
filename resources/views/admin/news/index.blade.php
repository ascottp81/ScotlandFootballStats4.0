@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">News <a href="/admin/news/article" class="add">Add Article</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent">
        <table class="datatableMatches">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Headline</th>
                    <th>Type</th>
                    <th class="noSort"></th>
                    <th class="noSort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($newsList as $article)
                <tr>
                    <td>{{ $article->date->format('Y-m-d') }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->type }}</td>
                    <td><a href="/admin/news/article/{{ $article->id }}">Edit</a></td>
                    <td><a href="javascript:deleteArticle({{ $article->id }})">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection