@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ $competitionType->title }}<div class="breadcrumb"><a href="/">Home</a> > <a href="/competitions/">Competitions</a> > <span>{{ $competitionType->title }}</span></div></h1>
    <div class="competitionIndexColumn">
        <div class="competitionSummaryColumn">
            <div class="competitionSummary">{{ $competitionType->summary }}</div>
            <div class="competitionMatchCount">
                @if ($competitionType->status == "C")
                <div class="competitionCountRowTitle">Qualifiers</div>
                <div class="competitionCountRow">
                    <div class="competitionCountData">P</div>
                    <div class="competitionCountData">W</div>
                    <div class="competitionCountData">D</div>
                    <div class="competitionCountData">L</div>
                    <div class="competitionCountData">F</div>
                    <div class="competitionCountData">A</div>
                    <div class="competitionCountData">GD</div>
                </div>
                <div class="competitionCountRow">
                    <div class="competitionCountData">{{ $matchNumbers['played_q'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['won_q'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['drew_q'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['lost_q'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['for_q'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['against_q'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['goal_difference_q'] }}</div>
                </div>
                <div class="competitionCountRow">&nbsp;</div>
                <div class="competitionCountRowTitle">Finals</div>
                <div class="competitionCountRow">
                    <div class="competitionCountData">P</div>
                    <div class="competitionCountData">W</div>
                    <div class="competitionCountData">D</div>
                    <div class="competitionCountData">L</div>
                    <div class="competitionCountData">F</div>
                    <div class="competitionCountData">A</div>
                    <div class="competitionCountData">GD</div>
                </div>
                <div class="competitionCountRow">
                    <div class="competitionCountData">{{ $matchNumbers['played_f'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['won_f'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['drew_f'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['lost_f'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['for_f'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['against_f'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['goal_difference_f'] }}</div>
                </div>
                @else                
                <div class="competitionCountRowTitle">All Matches</div>
                <div class="competitionCountRow">
                    <div class="competitionCountData">P</div>
                    <div class="competitionCountData">W</div>
                    <div class="competitionCountData">D</div>
                    <div class="competitionCountData">L</div>
                    <div class="competitionCountData">F</div>
                    <div class="competitionCountData">A</div>
                    <div class="competitionCountData">GD</div>
                </div>
                <div class="competitionCountRow">
                    <div class="competitionCountData">{{ $matchNumbers['played'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['won'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['drew'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['lost'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['for'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['against'] }}</div>
                    <div class="competitionCountData">{{ $matchNumbers['goal_difference'] }}</div>
                </div>
                @endif                                               
            </div>
        </div>             
        <div class="competitionKey">
            <div class="keyItem">Qualified&nbsp;</div>
            <div class="keyItem"><img src="/img/qualified.png" /></div>
            <div class="keyItem">Won&nbsp;</div>
            <div class="keyItem"><img src="/img/trophy.png" /></div>
            <div class="keyItem">Shared&nbsp;</div>
            <div class="keyItem"><img src="/img/trophy2.png" /></div>
        </div>
        <div class="video">
        @include('partial.minivideo')
        </div>
    </div>
    
    
    <div class="competitionIndexColumn">
        <div class="titleLink2">Competitions</div>
        <div class="competitionListWindow">
            <div class="recordsListAll">
                @foreach ($competitions as $comp)
                <div class="competitionListItem{{ $comp->class }}"><a href="/competitions/{{ $comp->type->url }}/{{ $comp->url }}">{{ $comp->year }} {{ $comp->stage }}</a></div>
                @endforeach
            </div>
        </div>
        <div class="titleLink2">&nbsp;</div>
    </div>
    
    <div class="competitionImageColumn">
        @if ($competitionType->getty_images != '')
        	@if (config('app.livemedia'))
            {!! $competitionType->getty_images !!}
            @else
            {!! $competitionType->local_getty_images !!}
            @endif
        @else
        	@if (config('app.livemedia'))
    	<div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:594px;"><div style="overflow:hidden;position:relative;height:0;padding:66.666667% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/1246323?et=VtG7ch94QyhfiTPC3jhQ9w&viewMoreLink=off&sig=_ef7ErbrbKdVZz2svUbEvbYFLyiaG0jfSLEpc470d8A=" width="594" height="396" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/1246323" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
    	<div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:594px;"><div style="overflow:hidden;position:relative;height:0;padding:66.835017% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/2085367?et=c71yUJhMS8F5V3wH3Cqc2w&viewMoreLink=off&sig=Jroa830_xlLYdyMqzkQ2DufEIvnWN0R8UV-k_Qx4aWc=" width="594" height="397" scrolling="no" frameborder="0" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="margin:0;"></p><div style="padding:0;margin:0 0 0 10px;text-align:left;"><a href="http://www.gettyimages.com/detail/2085367" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">View image</a> | <a href="http://www.gettyimages.com" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">gettyimages.com</a></div></div>
    		@else
        <div class="getty localGetty"><img src="/storage/getty/1246323.jpg" /></div>
        <div class="getty localGetty"><img src="/storage/getty/2085367.jpg" /></div>
			@endif
        @endif
    </div> 
@endsection