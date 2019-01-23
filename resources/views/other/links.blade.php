@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">External Links</h1>
    <div class="linksRow">
        <div class="linksSector">
            <span class="flagTitleLink"><span class="flag"></span>Official Sites</span>
            <div class="linksSectorContent">
                @foreach ($officialLinks as $link)
                <div class="externalLinkItem">
                    <h3><a href="{{ $link->url }}" target="_blank">{{ $link->title }}</a> <i class="fa fa-external-link"></i></h3>
                    <p>{{ $link->summary }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <div class="linksSector">
            <span class="flagTitleLink"><span class="flag"></span>Featured Sites</span>
            <div class="linksSectorContent">
                @foreach ($featuredLinks as $link)
                <div class="externalLinkItem">
                    <h3><a href="{{ $link->url }}" target="_blank">{{ $link->title }}</a> <i class="fa fa-external-link"></i></h3>
                    <p>{{ $link->summary }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="linksRow">
        <div class="otherLinksSector">
            <span class="flagTitleLink"><span class="flag"></span>Other Sites</span>
            <div class="linksSectorContent">
                @foreach ($otherLinks as $link)
                <div class="externalLinkItem">
                    <h3><a href="{{ $link->url }}" target="_blank">{{ $link->title }}</a> <i class="fa fa-external-link"></i></h3>
                </div>
                @endforeach
            </div>
        </div>
        <div class="linksImage">
        	@if (config('app.livemedia'))
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:445px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.com/detail/79033764" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:69.696970% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/79033764?et=ER24YGHHT5p_TufNn-cpHA&viewMoreLink=off&sig=03NKIC8y6Zu3D7JlNj4zbfyUuqAdA5EyWWQYVBVNURY=" width="445" height="310" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div><p style="margin:0;"></p></div>
            @else
        	<div class="getty localGetty"><img src="/storage/getty/79033764.jpg"></div>
            @endif
        </div>
    </div>
@endsection