@extends('admin.app')

@section('head')
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/js/news_tiny_mce_config.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ ($news)? 'Edit' : 'Add' }} Article<div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/news/') }}">
		{{ csrf_field() }}
        <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
        <div>
            <div class="leftInputs">
                <div class="inputRow">
                	<div class="inputHead">Date: </div>
                    <div class="input">
                    	<input type="text" class="datepicker" id="date" value="{{ old('date') ?? (($news) ? $news->date->format('Y-m-d') : '') }}" name="date" />
                        <span class="errorMsg">{{ $errors->first('date') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Type: </div>
                    <div class="input">
                    	<select id="type" name="type">
                        	<option value="">Please Select</option>
                            <option value="News" @if((old('type') ?? $news->type ?? '') == 'News')selected="selected"@endif>News</option>
                            <option value="Squad" @if((old('type') ?? $news->type ?? '') == 'Squad')selected="selected"@endif>Squad</option>
                        </select>
                        <span class="errorMsg">{{ $errors->first('type') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Headline: </div>
                    <div class="input">
                    	<input type="text" id="title" value="{{ old('title') ?? $news->title ?? '' }}" name="title" />
                        <span class="errorMsg">{{ $errors->first('title') }}</span>
                    </div>
                </div>
            	<div class="inputRow">
                    <div class="inputHead">Content: </div>
                </div>
            	<div class="inputRow">
                    <textarea id="content" name="content" style="width:100%;height:300px;">{{ old('content') ?? $news->content ?? '' }}</textarea>
                    <span class="errorMsg">{{ $errors->first('content') }}</span>
                </div> 
            </div>
            <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/news">Cancel</a></div>
        </div>
        </form>  
    </div>
@endsection