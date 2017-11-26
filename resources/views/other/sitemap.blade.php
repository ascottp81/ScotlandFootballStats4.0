@extends('app')

@section('head')
<link rel="stylesheet" href="/js/jstree/dist/themes/default/style.min.css" />	
<script>window.$q=[];window.$=window.jQuery=function(a){window.$q.push(a);};</script>
<script type="text/javascript">
$(function () {

    $("#sitemapTree").jstree().bind("select_node.jstree", function (e, data) {
         var href = data.node.a_attr.href;
         document.location.href = href;
    });
});


</script>
<script src="/js/jstree/jquery-1.10.2.min.js"></script>
<script src="/js/jstree/dist/jstree.min.js"></script>
<script>$.each($q,function(i,f){$(f)});$q=null;</script>
<script type="text/javascript">
$(document).ready(function() {
    $('#sitemapTree').jstree();
});
</script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Sitemap</h1>
    <div class="basicContent">
        <div id="sitemapTree">
            <ul>
                <li><a href="/">Home</a>
                    <ul>
                        <li><a href="/latest-news">Latest News</a></li>
                        <li><a href="/fixtures">Fixtures</a></li>
                        <li><a href="/recent-results">Recent Results</a></li>
                    </ul>
                </li>
                <li><a href="/opponents">Opponents</a>
                    <ul>
                        @foreach ($opponents as $opponent)
                        <li><a href="/opponents/{{ $opponent->url }}">{{ $opponent->name }}</a>
                            <ul>
                                @foreach ($opponent->matches()->get() as $match)
                                <li><a href="/match-details/{{ $match->url }}">{{ $match->sitemap_scoreline }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="/players">Players</a>
                    <ul>
                        <li><a href="/players/a-z">Players A-Z</a>
                            <ul>
                                @foreach ($players as $player)
                                <li><a href="/players/{{ $player->id }}/{{ $player->url }}">{{ $player->fullname }} ({{ $player->debut_year }})</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="/players/sfa-hall-of-fame">SFA Hall of Fame</a></li>
                        <li><a href="/players/silver-caps">Silver Caps (25-49)</a></li>
                        <li><a href="/players/leading-goalscorers">Leading Goalscorers</a></li>
                        <li><a href="/players/current-players">Current Players</a></li>
                    </ul>
                </li>
                <li><a href="/competitions">Competitions</a>
                    <ul>
                        @foreach ($competitionTypes as $type)
                        <li><a href="/competitions/{{ $type->url }}">{{ $type->title }}</a>
                            @if ($type->competitions()->count() > 1) {
                            <ul>
                                @foreach ($type->competitions()->get() as $competition)
                                <li><a href="/competitions/{{ $type->url }}/{{ $competition->url }}">{{ $competition->title }}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="/managers">Managers</a>
                    <ul>
                        @foreach ($managers as $manager)
                        <li><a href="/managers/{{ $manager->url }}">{{ $manager->fullname }} ({{ $manager->years }})</a></li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="/history">History</a>
                    <ul>
                        @foreach ($chapters as $chapter)
                        <li><a href="/history/{{ $chapter->url }}">{{ $chapter->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="/fifa-rankings">FIFA Rankings</a></li>
                <li><a href="/strips">Strips</a>
                    <ul>
                        @foreach ($strips as $strip)
                        <li><a href="/strips/{{ $strip->url }}">{{ $strip->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <!--<li><a href="/videos">Videos</a></li>-->
                <li><a href="/links">Links</a></li>
                <li><a href="/contact">Contact Us</a></li>
            </ul>
        </div>
        <div class="sitemapImage">
            @if (config('app.livemedia'))
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:594px;"><div style="overflow:hidden;position:relative;height:0;padding:66.666667% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1246323?et=VtG7ch94QyhfiTPC3jhQ9w&viewMoreLink=off&sig=_ef7ErbrbKdVZz2svUbEvbYFLyiaG0jfSLEpc470d8A=" width="594" height="396" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1246323" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
            @else
            <div class="getty localGetty"><img src="/storage/getty/1246323.jpg" /></div>
            @endif
        </div>
    </div>
@endsection