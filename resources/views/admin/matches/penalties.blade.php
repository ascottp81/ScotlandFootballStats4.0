@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Edit Match&nbsp;&nbsp;&nbsp;<span class="subTitle">Penalties</span><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/match/penalties') }}">
            {{ csrf_field() }}
            <input type="hidden" id="itemid" value="{{ $match->id }}" name="match_id" data-required="true" />
            <div>
                <div class="inputRow lineup">
                    <div class="input penaltyno">Penalty No.</div>
                    <div class="input club">Team</div>
                    <div class="input player">Player</div>
                    <div class="input cards">Result</div>
                </div>

                @for($i = 0; $i < $penalties->count(); $i++)
                    <div class="inputRow lineup">
                        <div class="input penaltyno">
                            <input type="text" value="{{ $penalties[$i]->penalty_no }}" name="penalty_no[]" data-required="true" />
                        </div>
                        <div class="input club">
                            <select name="team_id[]">
                                <option value="0" @if($penalties[$i]->team_id == 0)selected="selected"@endif>Scotland</option>
                                <option value="{{ $match->opponent->id }}" @if($penalties[$i]->team_id == $match->opponent->id)selected="selected"@endif>{{ $match->opponent->name }}</option>
                            </select>
                        </div>
                        <div class="input player">
                            <input type="text" value="{{ $penalties[$i]->player }}" name="player[]" data-required="true" />
                        </div>
                        <div class="input cards">
                            <select name="result[]">
                                <option value="scored" @if($penalties[$i]->result == "scored")selected="selected"@endif>Scored</option>
                                <option value="missed" @if($penalties[$i]->result == "missed")selected="selected"@endif>Missed</option>
                            </select>
                        </div>
                        <div class="input"><a class="removePenalty"><img src="/cms/images/remove.gif" /></a></div>
                        <input type="hidden" value="{{ $penalties[$i]->id }}" name="id[]" data-required="true" />
                    </div>
                @endfor
                <a class="addSub" href="javascript:addPenalty();"><img src="/cms/images/add.gif" /></a>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/match/{{ $match->id }}">Cancel</a></div>
            </div>
        </form>
    </div>
@endsection