@extends('admin.app')


@section('content')
    <h1 class="fullTitleBar">{{ ($strip)? 'Edit' : 'Add' }} Strip<div class="breadcrumb"><a href="/logout">Logout</a></div><div class="breadcrumb"><a href="/admin/strips">Strips</a> > <span>@if ($strip){{ $strip->name }}@else New @endif</span></div></h1>
    <div class="addContent">
    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/strip/') }}">
		{{ csrf_field() }}
        <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
        <div>
            <div class="leftInputs">
                <div class="inputRow">
                	<div class="inputHead">Tag Name: </div>
                    <div class="input">
                    	<input type="text" id="name" value="{{ old('name') ?? $strip->name ?? '' }}" name="name" />
                        <span class="errorMsg">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Year From: </div>
                    <div class="input">
                    	<input type="text" id="year_from" value="{{ old('year_from') ?? $strip->year_from ?? '' }}" name="year_from" />
                        <span class="errorMsg">{{ $errors->first('year_from') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Year To: </div>
                    <div class="input">
                        <input type="text" id="year_to" value="{{ old('year_to') ?? $strip->year_to ?? '' }}" name="year_to" />
                        <span class="errorMsg">{{ $errors->first('year_to') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Type: </div>
                    <div class="input">
                        <select id="type" name="type">
                            <option value="">Please Select</option>
                            <option value="Home" @if((old('type') ?? $strip->type ?? '') == "Home")selected="selected"@endif>Home</option>
                            <option value="Away" @if((old('type') ?? $strip->type ?? '') == "Away")selected="selected"@endif>Away</option>
                            <option value="Third" @if((old('type') ?? $strip->type ?? '') == "Third")selected="selected"@endif>Third</option>
                        </select>
                        <span class="errorMsg">{{ $errors->first('type') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Colour: </div>
                    <div class="input">
                    	<input type="text" id="colour" value="{{ old('colour') ?? $strip->colour ?? '' }}" name="colour" />
                        <span class="errorMsg">{{ $errors->first('colour') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Famous Match: </div>
                    <div class="input">
                        <input type="text" id="match" value="{{ old('match') ?? $strip->match ?? '' }}" name="match" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Complete: </div>
                    <div class="input">
                        <input type="checkbox" id="complete" value="1" {{ ((old('complete') ?? $strip->complete ?? '0') == 1)? 'checked="checked"':'' }} name="complete" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Designer: </div>
                    <div class="input">
                        <input type="text" id="designer" value="{{ old('designer') ?? $strip->designer ?? '' }}" name="designer" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Note: </div>
                    <div class="input">
                        <input type="text" id="note" value="{{ old('note') ?? $strip->note ?? '' }}" name="note" />
                    </div>
                </div>
            </div>
            <div class="leftInputs">
                <div class="inputRow">
                	<div class="inputHead">Getty Image: </div>
                </div>
                <div class="inputRow">
                	<textarea id="getty_image" name="getty_image" style="width:100%;height:250px;">{!! old('getty_image') ?? $strip->getty_image ?? '' !!}</textarea>
                </div>
            </div>
            <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/strips">Cancel</a></div>
        </div>
        </form>  
    </div>
@endsection