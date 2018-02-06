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
                    	<input type="text" id="surname" value="{{ ($player)? $player->surname : '' }}" name="surname" data-required="true" />
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">First Name: </div>
                    <div class="input">
                    	<input type="text" id="firstname" value="{{ ($player)? $player->firstname : '' }}" name="firstname" data-required="true" />
                    </div>
                </div>            
                <div class="inputRow">
                	<div class="inputHead">Debut Year: </div>
                    <div class="input">
                    	<input type="text" id="debut_year" value="{{ ($player)? $player->debut_year : '' }}" name="debut_year" data-required="true" />
                    </div>
                </div>             
                <div class="inputRow">
                	<div class="inputHead">Position: </div>
                    <div class="input">
                    	<input type="text" id="position" value="{{ ($player)? $player->position : '' }}" name="position" data-required="false" />
                    </div>
                </div> 
            	<div class="inputRow">
                	<div class="inputHead">Date of Birth: </div>
                    <div class="input">
                    	<input type="text" class="datepicker_dob" id="date_of_birth" value="{{ ($player)? $player->date_of_birth->format('j F Y') : '' }}" name="date_of_birth" data-required="true" />
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Birthplace: </div>
                    <div class="input">
                    	<input type="text" id="birthplace" value="{{ ($player)? $player->birthplace : '' }}" name="birthplace" data-required="false" />
                    </div>
                </div>  
                <div class="inputRow">
                	<div class="inputHead">Notes: </div>
                    <div class="input">
                    	<input type="text" id="notes" value="{{ ($player)? $player->notes : '' }}" name="notes" data-required="false" />
                    </div>
                </div> 
                <div class="inputRow">
                	<div class="inputHead">Retired: </div>
                    <div class="input">
                    	<input type="checkbox" id="retired" value="1" {{ ($player && $player->retired == 1)? 'checked="checked"':'' }} name="retired" data-required="false" />
                    </div>
                </div> 
            </div>
            <div class="leftInputs">
                <div class="inputRow">
                	<div class="inputHead">Image: </div>
                </div>
                <div class="inputRow">
                	<textarea id="image" name="image" style="width:100%;height:300px;">{!! ($player)? $player->getty_image : '' !!}</textarea>
                </div>
            </div>
            <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/players">Cancel</a></div>
        </div>
        </form>  
    </div>
@endsection