@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">Strips<div class="breadcrumb"><a href="/">Home</a> > <span>Strips</span></div></h1>
    <div class="playerImage">
        @if (config('app.livemedia'))
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:315px;"><div style="overflow:hidden;position:relative;height:0;padding:141.428571% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/174049644?et=E1aRw106Qt1GfbK0lI9TfQ&viewMoreLink=off&sig=mkSns9UZCL5BJsVFh_osGnUeB6EBurC0BPJJbS_6Hys=" width="315" height="445" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/174049644" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:362px;"><div style="overflow:hidden;position:relative;height:0;padding:164.088398% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1553427?et=uICDn9LPT6toveeenTbetw&viewMoreLink=off&sig=bYW2h3GO2_LHm7md-fFeHG5f4YoWIu2zUfsgolluMnA=" width="362" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1553427" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:394px;"><div style="overflow:hidden;position:relative;height:0;padding:150.761421% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1279345?et=z__LAXCfQktaN4DbwCvjcQ&viewMoreLink=off&sig=eMc1W76ifj1SED2cw41P5JyzHNpPGFuaiNjyulkFWrY=" width="394" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1279345" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
        <div class="getty localGetty"><img src="/storage/getty/174049644.jpg" /></div>
        <div class="getty localGetty"><img src="/storage/getty/1553427.jpg" /></div>
        <div class="getty localGetty"><img src="/storage/getty/1279345.jpg" /></div>
        @endif
    </div>
    
    <div class="playersIndexColumn">
        <div class="introText">Scotland have worn many famous strips through the years.  From Lord Roseberry's colours (pink and yellow) pre-war, to a saltire on a white shirt in 2007.  The most prominent colour was established as being navy blue and white, and some famous tops such as the round collar in the 60s and the blue banded shorts in the 80s became popular.  In 1994 tartan was also introduced as the main colour in the top that was worn at Euro '96.</div>            
        
        <div class="stripLinksHolder">
            <div class="stripLinksColumn">
                @foreach ($home as $strip)
                <a class="stripLink titleBar" href="/strips/{{ $strip->url }}">{{ $strip->title}}</a>
                @endforeach
            </div>
            <div class="stripLinksColumn">
                @foreach ($away as $strip)
                <a class="stripLink titleBar" href="/strips/{{ $strip->url }}">{{ $strip->title }}</a>
                @endforeach
            </div>                
        </div>
        
    </div>
    
    <div class="managersRightColumn">  
        @if (config('app.livemedia'))
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:374px;"><div style="overflow:hidden;position:relative;height:0;padding:158.823529% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1579214?et=zLvynafXQFR4ujdjx0jq0A&viewMoreLink=off&sig=QBUCzIzkiwp04VkYM7bNuIb7ID4pux2crHgpvHjtr_Y=" width="374" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1579214" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:396px;"><div style="overflow:hidden;position:relative;height:0;padding:150.000000% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/76890491?et=gs4PYzyjSZRBiu80UYC-yQ&viewMoreLink=off&sig=g7XW4vXEy4LmMOOjgOhJPOijGT1TjISR-AQSDpBGOZA=" width="396" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/76890491" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:393px;"><div style="overflow:hidden;position:relative;height:0;padding:151.145038% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/535710879?et=Vbezba9YQBxadUaQVMWyYA&viewMoreLink=off&sig=q8RZsCXqy7MKFQb9pDoGT3sbu9ncCXYw67g66PQB8OE=" width="393" height="594" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/535710879" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
        @else
        <div class="getty localGetty"><img src="/storage/getty/1579214.jpg" /></div>
        <div class="getty localGetty"><img src="/storage/getty/76890491.jpg" /></div>
        <div class="getty localGetty"><img src="/storage/getty/535710879.jpg" /></div>
        @endif
    </div>
@endsection