@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Edit Match&nbsp;&nbsp;&nbsp;<span class="subTitle">Incidents</span><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
        <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ url('/admin/match/incidents') }}">
            {{ csrf_field() }}
            <input type="hidden" id="itemid" value="{{ $match->id }}" name="match_id" data-required="true" />
            <div>
                <div class="inputRow lineup">
                    <div class="input shirtno">Minute</div>
                    <div class="input club">Team</div>
                    <div class="input player">Player</div>
                    <div class="input cards">Action</div>
                </div>

                @for($i = 0; $i < $incidents->count(); $i++)
                    <div class="inputRow lineup">
                        <div class="input shirtno">
                            <input class="shirtIp" type="text" value="{{ $incidents[$i]->minute }}" name="minute[]" data-required="true" />
                        </div>
                        <div class="input club">
                            <select name="team_id[]" class="clubSelect">
                                <option value="0" @if($incidents[$i]->team_id == 0)selected="selected"@endif>Scotland</option>
                                <option value="{{ $match->opponent->id }}" @if($incidents[$i]->team_id == $match->opponent->id)selected="selected"@endif>{{ $match->opponent->name }}</option>
                            </select>
                        </div>
                        <div class="input player">
                            <input type="text" value="{{ $incidents[$i]->player }}" name="player[]" data-required="true" />
                        </div>
                        <div class="input club">
                            <select name="incident_type_id[]" class="clubSelect">
                                <option value="">Please Select</option>
                                @foreach ($incidentTypes as $type)
                                    <option value="{{ $type->id }}" @if($incidents[$i]->incident_type_id == $type->id)selected="selected"@endif>{{ $type->text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input player">
                            <img class="incidentImg" src="/storage/animations/incidents/{{ $incidents[$i]->id }}.gif" />
                            <input type="file" name="image[]" />
                        </div>
                        <div class="input"><a class="removeIncident"><img src="/img/remove.gif" /></a></div>
                        <input type="hidden" value="{{ $incidents[$i]->id }}" name="id[]" data-required="true" />
                    </div>
                @endfor
                <a class="addSub" href="javascript:addIncident();"><img src="/img/add.gif" /></a>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/match/{{ $match->id }}">Cancel</a></div>
            </div>
        </form>
    </div>
@endsection