@extends('admin.app')


@section('content')
    <h1 class="fullTitleBar">{{ ($manager)? 'Edit' : 'Add' }} Manager<div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/manager/') }}">
		{{ csrf_field() }}
        <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
        <div>
            <div class="leftInputs">
                <div class="inputRow">
                	<div class="inputHead">Surname: </div>
                    <div class="input">
                    	<input type="text" id="surname" value="{{ old('surname') ?? $manager->surname ?? '' }}" name="surname" />
                        <span class="errorMsg">{{ $errors->first('surname') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">First Name: </div>
                    <div class="input">
                    	<input type="text" id="firstname" value="{{ old('firstname') ?? $manager->firstname ?? '' }}" name="firstname" />
                        <span class="errorMsg">{{ $errors->first('firstname') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Name Extension: </div>
                    <div class="input">
                        <input type="text" id="name_extension" value="{{ old('name_extension') ?? $manager->name_extension ?? '' }}" name="name_extension" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">URL: </div>
                    <div class="input">
                        <input type="text" id="url" value="{{ old('url') ?? $manager->url ?? '' }}" name="url" />
                        <span class="errorMsg">{{ $errors->first('url') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">From: </div>
                    <div class="input">
                    	<input type="text" id="from" value="{{ old('from') ?? $manager->from ?? '' }}" name="from" />
                        <span class="errorMsg">{{ $errors->first('from') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">To: </div>
                    <div class="input">
                        <input type="text" id="to" value="{{ old('to') ?? $manager->to ?? '' }}" name="to" />
                        <span class="errorMsg">{{ $errors->first('to') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Took Charge: </div>
                    <div class="input">
                        <input type="text" id="took_charge" value="{{ old('took_charge') ?? $manager->took_charge ?? '' }}" name="took_charge" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Appointed: </div>
                    <div class="input">
                        <input type="text" id="appointed" value="{{ old('appointed') ?? $manager->appointed ?? '' }}" name="appointed" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Reign Ended: </div>
                    <div class="input">
                        <input type="text" id="reign_ended" value="{{ old('reign_ended') ?? $manager->reign_ended ?? '' }}" name="reign_ended" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Reason: </div>
                    <div class="input">
                        <select id="reason" name="reason">
                            <option value="">Please Select</option>
                            <option value="Resigned" @if((old('reason') ?? $manager->reason ?? '') == "Resigned")selected="selected"@endif>Resigned</option>
                            <option value="Sacked" @if((old('reason') ?? $manager->reason ?? '') == "Sacked")selected="selected"@endif>Sacked</option>
                            <option value="Left Job" @if((old('reason') ?? $manager->reason ?? '') == "Left Job")selected="selected"@endif>Left Job</option>
                            <option value="Last Match" @if((old('reason') ?? $manager->reason ?? '') == "Last Match")selected="selected"@endif>Last Match</option>
                        </select>
                    </div>
                </div>
            	<div class="inputRow">
                	<div class="inputHead">Born: </div>
                    <div class="input">
                    	<input type="text" class="datepicker_dob" id="born" value="{{ old('born') ?? (($manager) ? $manager->born->format('j F Y') : '') }}" name="born" />
                        <span class="errorMsg">{{ $errors->first('born') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Birthplace: </div>
                    <div class="input">
                    	<input type="text" id="birthplace" value="{{ old('birthplace') ?? $manager->birthplace ?? '' }}" name="birthplace" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Died: </div>
                    <div class="input">
                        <input type="text" id="died" value="{{ old('died') ?? $manager->died ?? '' }}" name="died" />
                    </div>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Assistants: </div>
                    <div class="input">
                    	<input type="text" id="assistants" value="{{ old('assistants') ?? $manager->assistants ?? '' }}" name="assistants" />
                    </div>
                </div> 
                <div class="inputRow">
                	<div class="inputHead">Caretaker: </div>
                    <div class="input">
                    	<input type="checkbox" id="caretaker" value="1" {{ ((old('caretaker') ?? $manager->caretaker ?? '0') == 1)? 'checked="checked"':'' }} name="caretaker" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Appointed First: </div>
                    <div class="input">
                        <input type="checkbox" id="appointed_first" value="1" {{ ((old('appointed_first') ?? $manager->appointed_first ?? '0') == 1)? 'checked="checked"':'' }} name="appointed_first" />
                    </div>
                </div>
            </div>
            <div class="leftInputs">
                <div class="inputRow">
                    <div class="inputHead">Summary: </div>
                </div>
                <div class="inputRow">
                    <textarea id="image" name="summary" style="width:100%;height:150px;">{!! old('summary') ?? $manager->summary ?? '' !!}</textarea>
                </div>
                <div class="inputRow">
                	<div class="inputHead">Image: </div>
                </div>
                <div class="inputRow">
                	<textarea id="image" name="getty_image" style="width:100%;height:250px;">{!! old('getty_image') ?? $manager->getty_image ?? '' !!}</textarea>
                </div>
            </div>
            <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/managers">Cancel</a></div>
        </div>
        </form>  
    </div>
@endsection