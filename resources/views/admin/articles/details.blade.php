@extends('admin.app')

@section('head')
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/js/article_tiny_mce_config.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ ($article)? 'Edit' : 'Add' }} Article<div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/articles/') }}">
		{{ csrf_field() }}
        <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
        <div>
            <div class="inputRow">
                <div class="inputHead">Title: </div>
                <div class="input">
                    <input type="text" id="title" value="{{ old('title') ?? $article->title ?? '' }}" name="title" />
                    <span class="errorMsg">{{ $errors->first('title') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Link Text: </div>
                <div class="input">
                    <input type="text" id="link_text" value="{{ old('link_text') ?? $article->link_text ?? '' }}" name="link_text" />
                    <span class="errorMsg">{{ $errors->first('link_text') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">URL: </div>
                <div class="input">
                    <input type="text" id="url" value="{{ old('url') ?? $article->url ?? '' }}" name="url" />
                    <span class="errorMsg">{{ $errors->first('url') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Content: </div>
            </div>
            <div class="inputRow">
                <textarea class="mceEditor" id="content" name="content" style="width:100%;height:300px;">{{ old('content') ?? $article->content ?? '' }}</textarea>
                <span class="errorMsg">{{ $errors->first('content') }}</span>
            </div>
            <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/articles">Cancel</a></div>
        </div>
        </form>
    </div>
@endsection