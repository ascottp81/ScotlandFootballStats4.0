@extends('admin.app')

@section('head')
    <script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="/js/tiny_mce_config.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">History Page <div class="breadcrumb"><a href="/logout">Logout</a></div><div class="breadcrumb"><a href="/admin/history">History</a> > <span>{{ $history->title }}</span></div></h1>
    <div class="addContent">
        <form class="form-horizontal" autocomplete="off" role="form" method="POST" action="{{ url('/admin/history/page/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="fullInputs">
                    @if ($id > 0)
                    <div class="inputRow">
                        <div class="inputHead">Chapter: </div>
                        <div class="input">
                            <select id="history_id" name="history_id">
                                @foreach ($historyChapters as $chapter)
                                    <option value="{{ $chapter->id }}" @if((old('history_id') ?? $page->history_id ?? '') == $chapter->id)selected="selected"@endif>{{ $chapter->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @else
                        <input type="hidden" name="history_id" id="history_id" value="{{ $history->id }}">
                    @endif
                    <div class="inputRow">
                        <div class="inputHead">Page No: </div>
                        <div class="input">
                            <input type="text" id="page_no" value="{{ old('page_no') ?? $page->page_no ?? '' }}" name="page_no" />
                            <span class="errorMsg">{{ $errors->first('page_no') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Title: </div>
                        <div class="input">
                            <input type="text" id="title" value="{{ old('title') ?? $page->title ?? '' }}" name="title" />
                            <span class="errorMsg">{{ $errors->first('title') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Content: </div>
                        <textarea class="mceEditor" id="content" name="history_content" style="width:100%;height:300px;">{{ old('content') ?? $page->content ?? '' }}</textarea>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Getty Image: </div>
                        <div class="input inputClear">
                            <textarea id="getty_image" name="getty_image">{{ old('getty_image') ?? $page->getty_image ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Image Text: </div>
                        <div class="input">
                            <input type="text" id="image_text" value="{{ old('image_text') ?? $page->image_text ?? '' }}" name="image_text" />
                        </div>
                    </div>
                </div>
                <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/history/{{ $history->url }}">Cancel</a></div>
            </div>
        </form>
    </div>
@endsection