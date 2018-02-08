@extends('admin.app')


@section('content')
    <h1 class="fullTitleBar">{{ ($player)? 'Edit' : 'Add' }} Player<div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/player/') }}">
		{{ csrf_field() }}
        <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
        <div>
            <div class="leftInputs">
                <div class="inputRow">
                	<div class="inputHead">Surname: </div>
                    <div class="input">
                    	<input type="text" id="surname" value="{{ old('surname') ?? $player->surname ?? '' }}" name="surname" />
                        <span class="errorMsg">{{ $errors->first('surname') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">First Name: </div>
                    <div class="input">
                    	<input type="text" id="firstname" value="{{ old('firstname') ?? $player->firstname ?? '' }}" name="firstname" />
                        <span class="errorMsg">{{ $errors->first('firstname') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Debut Year: </div>
                    <div class="input">
                    	<input type="text" id="debut_year" value="{{ old('debut_year') ?? $player->debut_year ?? '' }}" name="debut_year" />
                        <span class="errorMsg">{{ $errors->first('debut_year') }}</span>
                    </div>
                </div>             
                <div class="inputRow">
                	<div class="inputHead">Position: </div>
                    <div class="input">
                    	<input type="text" id="position" value="{{ old('position') ?? $player->position ?? '' }}" name="position" />
                    </div>
                </div> 
            	<div class="inputRow">
                	<div class="inputHead">Date of Birth: </div>
                    <div class="input">
                    	<input type="text" class="datepicker_dob" id="date_of_birth" value="{{ old('date_of_birth') ?? (($player) ? $player->date_of_birth->format('j F Y') : '') }}" name="date_of_birth" />
                        <span class="errorMsg">{{ $errors->first('date_of_birth') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Birthplace: </div>
                    <div class="input">
                    	<input type="text" id="birthplace" value="{{ old('birthplace') ?? $player->birthplace ?? '' }}" name="birthplace" />
                    </div>
                </div>  
                <div class="inputRow">
                	<div class="inputHead">Notes: </div>
                    <div class="input">
                    	<input type="text" id="notes" value="{{ old('notes') ?? $player->notes ?? '' }}" name="notes" />
                    </div>
                </div> 
                <div class="inputRow">
                	<div class="inputHead">Retired: </div>
                    <div class="input">
                    	<input type="checkbox" id="retired" value="1" {{ ((old('retired') ?? $player->retired ?? '0') == 1)? 'checked="checked"':'' }} name="retired" />
                    </div>
                </div> 
            </div>
            <div class="leftInputs">
                <div class="inputRow">
                	<div class="inputHead">Image: </div>
                </div>
                <div class="inputRow">
                	<textarea id="image" name="image" style="width:100%;height:300px;">{!! old('image') ?? $player->getty_image ?? '' !!}</textarea>
                </div>
            </div>
            <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/players">Cancel</a></div>
        </div>
        </form>  
    </div>
@endsection