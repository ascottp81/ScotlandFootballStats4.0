@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Edit Match&nbsp;&nbsp;&nbsp;<span class="subTitle">Lineup</span><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/match/lineup') }}">
            {{ csrf_field() }}
            <input type="hidden" id="itemid" value="{{ $id }}" name="match_id" data-required="true" />
            <div>
                <div class="inputRow lineup">
                    <div class="input shirtno">Shirt No.</div>
                    <div class="input shirtcb">
                        <input id="ShirtCb" onClick="allShirtNo();" type="checkbox" value="1" data-required="true" />
                    </div>
                    <div class="input player">Player</div>
                    <div class="input club">Club</div>
                    <div class="input captaincb">Captain</div>
                    <div class="input goals">Goals</div>
                    <div class="input goals">Pens</div>
                    <div class="input cards">Cards</div>
                </div>

                @for($i = 0; $i < $starts->count(); $i++)
                    <div class="inputRow lineup">
                        <div class="input shirtno">
                            <input class="shirtIp" type="text" value="{{ $starts[$i]->shirt_no }}" name="shirt_no[]" data-required="true" />
                        </div>
                        <div class="input shirtcb">
                            <input class="shirtCb" type="checkbox" value="1" data-required="true" @if($starts[$i]->shirt_no_show == 1)checked="checked"@endif />
                            <input type="hidden" value="{{ $starts[$i]->shirt_no_show }}" name="shirt_no_show[]" data-required="true" />
                        </div>
                        <div class="input player">
                            <select name="player_id[]" class="playerSelect">
                                <option value="">Please Select</option>
                                @foreach ($players as $player)
                                    <option value="{{ $player->id }}" @if($starts[$i]->player_id == $player->id)selected="selected"@endif >{{ $player->surname }}, {{ $player->firstname }} ({{ $player->debut_year }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input club">
                            <select name="club_id[]" class="clubSelect">
                                <option value="">Please Select</option>
                                @foreach ($clubs as $club)
                                    <option value="{{ $club->id }}" @if($starts[$i]->club_id == $club->id)selected="selected"@endif>{{ $club->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input captaincb">
                            <input class="captainCb" type="checkbox" value="1" data-required="true" @if($starts[$i]->captain == 1)checked="checked"@endif />
                            <input type="hidden" value="{{ $starts[$i]->captain }}" name="captain[]" data-required="true" />
                        </div>
                        <div class="input goals">
                            <input class="goalsIp" type="text" value="{{ $starts[$i]->goals }}" name="goals[]" data-required="true" />
                        </div>
                        <div class="input goals">
                            <input class="goalsIp" type="text" value="{{ $starts[$i]->penalties }}" name="penalties[]" data-required="true" />
                        </div>
                        <div class="input cards">
                            <select name="cards[]" class="cardsSelect">
                                <option value="">None</option>
                                <option value="Y" @if($starts[$i]->cards == "Y")selected="selected"@endif>Yellow</option>
                                <option value="R" @if($starts[$i]->cards == "R")selected="selected"@endif>Red</option>
                                <option value="RY" @if($starts[$i]->cards == "RY")selected="selected"@endif>Double Booking</option>
                                <option value="YR" @if($starts[$i]->cards == "YR")selected="selected"@endif>Yellow &amp; Red</option>
                            </select>
                        </div>
                        <input type="hidden" value="0" name="replaced[]" data-required="true" />
                        <input type="hidden" value="0" name="minute[]" data-required="true" />
                        <input type="hidden" value="{{ $starts[$i]->id }}" name="id[]" data-required="true" />
                    </div>
                @endfor
                @for($i = $starts->count(); $i < 11; $i++)
                    <div class="inputRow lineup">
                        <div class="input shirtno">
                            <input class="shirtIp" type="text" value="" name="shirt_no[]" data-required="true" />
                        </div>
                        <div class="input shirtcb">
                            <input class="shirtCb" type="checkbox" value="1" />
                            <input type="hidden" value="" name="shirt_no_show[]" data-required="true" />
                        </div>
                        <div class="input player">
                            <select name="player_id[]" class="playerSelect">
                                <option value="">Please Select</option>
                                @foreach ($players as $player)
                                    <option value="{{ $player->id }}">{{ $player->surname }}, {{ $player->firstname }} ({{ $player->debut_year }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input club">
                            <select name="club_id[]" class="clubSelect">
                                <option value="">Please Select</option>
                                @foreach ($clubs as $club)
                                    <option value="{{ $club->id }}">{{ $club->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input captaincb">
                            <input class="captainCb" type="checkbox" value="1" data-required="true" />
                            <input type="hidden" value="" name="captain[]" data-required="true" />
                        </div>
                        <div class="input goals">
                            <input class="goalsIp" type="text" value="0" name="goals[]" data-required="true" />
                        </div>
                        <div class="input goals">
                            <input class="goalsIp" type="text" value="0" name="penalties[]" data-required="true" />
                        </div>
                        <div class="input cards">
                            <select name="cards[]" class="cardsSelect">
                                <option value="">None</option>
                                <option value="Y">Yellow</option>
                                <option value="R">Red</option>
                                <option value="RY">Double Booking</option>
                                <option value="YR">Yellow &amp; Red</option>
                            </select>
                        </div>
                        <input type="hidden" value="0" name="replaced[]" data-required="true" />
                        <input type="hidden" value="0" name="minute[]" data-required="true" />
                        <input type="hidden" value="0" name="id[]" data-required="true" />
                    </div>
                @endfor

                <div class="inputRow lineup lineupHeading">
                    <div class="input shirtno">Shirt No.</div>
                    <div class="input shirtcb">&nbsp;</div>
                    <div class="input player">Player</div>
                    <div class="input club">Club</div>
                    <div class="input goals">Replace</div>
                    <div class="input goals">Minute</div>
                    <div class="input goals">Goals</div>
                    <div class="input goals">Pens</div>
                    <div class="input cards">Cards</div>
                </div>
                @for($i = 0; $i < $subs->count(); $i++)
                    <div class="inputRow lineup">
                        <div class="input shirtno">
                            <input class="shirtIp" type="text" value="{{ $subs[$i]->shirt_no }}" name="shirt_no[]" data-required="true" />
                        </div>
                        <div class="input shirtcb">
                            <input class="shirtCb" type="checkbox" value="1" @if($subs[$i]->shirt_no_show == 1)checked="checked"@endif />
                            <input type="hidden" value="{{ $subs[$i]->shirt_no_show }}" name="shirt_no_show[]" data-required="true" />
                        </div>
                        <div class="input player">
                            <select name="player_id[]" class="playerSelect">
                                <option value="">Please Select</option>
                                @foreach ($players as $player)
                                    <option value="{{ $player->id }}" @if($subs[$i]->player_id == $player->id)selected="selected"@endif >{{ $player->surname }}, {{ $player->firstname }} ({{ $player->debut_year }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input club">
                            <select name="club_id[]" class="clubSelect">
                                <option value="">Please Select</option>
                                @foreach ($clubs as $club)
                                    <option value="{{ $club->id }}" @if($subs[$i]->club_id == $club->id)selected="selected"@endif>{{ $club->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input goals">
                            <input class="goalsIp" type="text" value="{{ $subs[$i]->replaced }}" name="replaced[]" data-required="true" />
                        </div>
                        <div class="input goals">
                            <input class="goalsIp" type="text" value="{{ $subs[$i]->minute }}" name="minute[]" data-required="true" />
                        </div>
                        <div class="input goals">
                            <input class="goalsIp" type="text" value="{{ $subs[$i]->goals }}" name="goals[]" data-required="true" />
                        </div>
                        <div class="input goals">
                            <input class="goalsIp" type="text" value="{{ $subs[$i]->penalties }}" name="penalties[]" data-required="true" />
                        </div>
                        <div class="input cards">
                            <select name="cards[]" class="cardsSelect">
                                <option value="">None</option>
                                <option value="Y" @if($subs[$i]->cards == "Y")selected="selected"@endif>Yellow</option>
                                <option value="R" @if($subs[$i]->cards == "R")selected="selected"@endif>Red</option>
                                <option value="RY" @if($subs[$i]->cards == "RY")selected="selected"@endif>Double Booking</option>
                                <option value="YR" @if($subs[$i]->cards == "YR")selected="selected"@endif>Yellow &amp; Red</option>
                            </select>
                        </div>
                        <div class="input"><a class="removesub"><img src="/cms/images/remove.gif" /></a></div>
                        <input type="hidden" value="0" name="captain[]" data-required="true" />
                        <input type="hidden" value="{{ $subs[$i]->id }}" name="id[]" data-required="true" />
                    </div>
                @endfor
                <a class="addSub" href="javascript:addSub();"><img src="/cms/images/add.gif" /></a>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/match/{{ $id }}">Cancel</a></div>
            </div>
        </form>
    </div>
@endsection