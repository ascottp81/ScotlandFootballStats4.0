@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">Honours<div class="breadcrumb"><a href="/">Home</a> > <a href="/competitions">Competitions</a> > <span>Honours</span></div></h1>
    <div class="honours">
        <div class="honoursContent">
            @foreach ($honourTypes as $type)
                @if ($type->honours_count > 0)
                <div class="honoursCompetition">
                    <p><span class="yellow">{{ $type->title }}@if ($type->status == "C") Finals<br />Qualification @endif</span></p>
                    <p>{!! $type->honours !!}</p>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="honourImage">
        @if (config('app.livemedia'))
            <!-- FIFA World Cup -->
            <div class="getty embed image bottomGap" style="background-color:#fff;display:inline-block;font-family:Roboto,sans-serif;color:#a7a7a7;font-size:11px;width:195px;max-width:396px;height:292px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.co.uk/detail/844897880" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:150% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/844897880?et=DTWtCRUMS8x3mGRA_d0YDA&tld=co.uk&sig=pYZdOFP8zm-aGpRHXN65QmDdyeCJMvQoDGGrtut6SKc=&caption=true&ver=1" scrolling="no" frameborder="0" width="396" height="594" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div></div>
            <!-- Henri Delauney Trophy (European Championships) -->
            <div class="getty embed image bottomGap" style="background-color:#fff;display:inline-block;font-family:Roboto,sans-serif;color:#a7a7a7;font-size:11px;width:210px;max-width:427px;height:292px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.co.uk/detail/51953740" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:139.11006% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/51953740?et=6wAmzwVzSGttBfliupRgSg&tld=co.uk&sig=SuA73ruAKot05O88gGArUGZsNdx6gI_MvwKIGdyFMno=&caption=true&ver=1" scrolling="no" frameborder="0" width="427" height="594" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div></div>
            <!-- Kirin Cup -->
            <div class="getty embed image bottomGap" style="background-color:#fff;display:inline-block;font-family:Roboto,sans-serif;color:#a7a7a7;font-size:11px;width:244px;max-width:496px;height:292px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.co.uk/detail/57604169" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:119.75807% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/57604169?et=yCdcGCAiTFp9f4FxPbgfEw&tld=co.uk&sig=AhDu29pI6d8HFH9VIHDR-8R7RDDr92HATJQIg5Ml8uI=&caption=true&ver=1" scrolling="no" frameborder="0" width="496" height="594" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div></div>
            <!-- Rous Cup and Home British Championships Trophy -->
            <div class="getty embed image bottomGap" style="background-color:#fff;display:inline-block;font-family:Roboto,sans-serif;color:#a7a7a7;font-size:11px;width:455px;max-width:594px;height:292px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.co.uk/detail/81936736" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:64.14142% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/81936736?et=u5-_EfODSOlfxC7xBcGPbw&tld=co.uk&sig=RSKdcfIvdQHtVw4GMvSzEImJqgA3vNX807Bq6BYuUG4=&caption=true&ver=1" scrolling="no" frameborder="0" width="594" height="381" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div></div>
            <!-- UEFA Nations Cup -->
            <div class="getty embed image" style="background-color:#fff;display:inline-block;font-family:Roboto,sans-serif;color:#a7a7a7;font-size:11px;width:100%;max-width:396px;"><div style="padding:0;margin:0;text-align:left;"><a href="http://www.gettyimages.co.uk/detail/909667316" target="_blank" style="color:#a7a7a7;text-decoration:none;font-weight:normal !important;border:none;display:inline-block;">Embed from Getty Images</a></div><div style="overflow:hidden;position:relative;height:0;padding:150% 0 0 0;width:100%;"><iframe src="//embed.gettyimages.com/embed/909667316?et=odq1-Y_AQ95nYVicNJpMkA&tld=co.uk&sig=i1l-8VHIOg_GHqWsCMSzNXqOMuKxaLVtW81hNOcfKac=&caption=true&ver=1" scrolling="no" frameborder="0" width="396" height="594" style="display:inline-block;position:absolute;top:0;left:0;width:100%;height:100%;margin:0;"></iframe></div></div>
        @else
            <!-- FIFA World Cup -->
            <div class="getty localGetty bottomGap"><img src="/storage/getty/844897880.jpg" /></div>
            <!-- Henri Delauney Trophy (European Championships) -->
            <div class="getty localGetty bottomGap"><img src="/storage/getty/51953740.jpg" /></div>
            <!-- Kirin Cup -->
            <div class="getty localGetty bottomGap"><img src="/storage/getty/57604169.jpg" /></div>
            <!-- Rous Cup and Home British Championships Trophy -->
            <div class="getty localGetty bottomGap"><img src="/storage/getty/81936736.jpg" /></div>
            <!-- UEFA Nations Cup -->
            <div class="getty localGetty bottomGap"><img src="/storage/getty/909667316.jpg" /></div>
        @endif
    </div>
@endsection