@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ $chapter->title }} {{ $chapter->period }}<div class="breadcrumb"><a href="/">Home</a> > <a href="/history">History</a> > <span>{{ $chapter->title }} {{ $chapter->period }}</span></div></h1>
    <div id="historyAccordion">
        @foreach ($chapter->pages()->get() as $page)
        <h3 class="flagTitleLink"><span class="flagTitle"></span>{{ $page->title }}</h3>
        <div class="subChapter">
            <div class="subChapterText">
                {!! $page->content !!}
            </div>
            <div class="subChapterImage">
                {!! $page->image !!}
                <p>{{ $page->image_text }}</p>
            </div>
        </div>
        @endforeach
    </div>
@endsection