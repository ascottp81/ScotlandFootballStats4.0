@extends('app')

@section('head')
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="/js/jquery/jquery.qtip.min.css" type="text/css" media="all" />
    <style type="text/css">
        .matchTooltip {
            border: solid 3px #000066;
            background-color: #000066;
            width: 175px;
        }
        .playerTooltip {
            border: solid 2px #ffffff;
            background-color: #000066;
        }
    </style>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="/js/jquery/jquery.qtip.min.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Competitions<div class="breadcrumb"><a href="/">Home</a> > <span>Competitions</span></div></h1>

    <div class="introText">
        Scotland have taken part in many different competitions, this includes the first international tournament in 1884 with the British
        Championships (Home Championships). It was 1949 when Scotland first took part in the FIFA World Cup, the main tournament in
        international football. Seventeen years later they took part in their first European Championships. The World Cup and European
        Championships make up the two competitive international tournaments that are alternated every two years. Scotland have also
        taken part in some friendly competitions.
    </div>

    <div class="competitiveHolder">
        @foreach ($competitive as $type)
        <a href="/competitions/{{ $type->url }}" class="competitiveBlock">
            <h2>{{ $type->title }}</h2>
            <p class="competitiveYears"><span>{{ $type->years }}</span><br />{{ $type->competitions()->count() }} Competitions</p>
            <p>{{ $type->short_summary }}</p>
        </a>
        @endforeach
    </div>

    <div class="competitionsLeft">

        @foreach ($friendly as $type)
        <div class="competitionRow">
            <a href="/competitions/{{ $type->url }}" class="competitionTitle titleBar">{{ $type->title }}</a>
            <div class="competitionInfo">
                <div class="competitionStats">
                    <span class="yellow">{{ $type->years }}</span><br /><span class="blue">{{ $type->competitions()->count() }} Competitions</span>
                </div>
                <div class="competitionIcon">
                    <img class="icon1" src="/img/info.png" data-summary="{{ $type->short_summary }}">
                </div>
            </div>
        </div>
        @endforeach

        <a class="honoursLink" href="/competitions/honours">
            <h2><i class="fa fa-trophy"></i>&nbsp;&nbsp;&nbsp;Honours&nbsp;&nbsp;&nbsp;<i class="fa fa-trophy"></i></h2>
        </a>
        <div class="video">
        @include('partial.video')
        </div>
    </div>

    <div class="competitionsRight">
        @if (config('app.livemedia'))
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:594px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.com/detail/79045203" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:64.814815% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/79045203?et=C7vUgr-KSbpV3J6k3PhnmA&viewMoreLink=on&sig=9h6UOVagpnNOwS-7-zQigTBXphSLlC3mKZN5FQHqotQ=" width="594" height="385" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div><p style="margin:0;"></p></div>
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:594px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.com/detail/2730826" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:65.488215% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/2730826?et=IfkBvJQ8RvZX_H6FcJO-hg&viewMoreLink=off&sig=H0Kl86pnPzLRpkpby9gOFzHYsJjk68xqGF9eifo5n0Y=" width="594" height="389" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div><p style="margin:0;"></p></div>
        @else
        <div class="getty localGetty"><img src="/storage/getty/79045203.jpg" /></div>
        <div class="getty localGetty"><img src="/storage/getty/2730826.jpg" /></div>
        @endif
    </div>


@endsection