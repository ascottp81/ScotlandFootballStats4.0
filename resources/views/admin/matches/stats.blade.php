@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Edit Match&nbsp;&nbsp;&nbsp;<span class="subTitle">Extra Stats</span><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
        <form class="form-horizontal" autocomplete="off" role="form" method="POST" action="{{ url('/admin/match/stats/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="statInputs">
                    <div class="inputRow">
                        <div class="inputHead"></div>
                        <div class="input statInput">Scotland</div>
                        <div class="input statInput">{{ $opponent->name }}</div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Colour: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_colour" value="{{ ($scotlandStats)? $scotlandStats->colour : '' }}" name="scotland_colour" data-required="true" autocomplete="on" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_colour" value="{{ ($opponentStats)? $opponentStats->colour : '' }}" name="opponent_colour" data-required="true" autocomplete="on" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Possession: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_possession" value="{{ ($scotlandStats)? $scotlandStats->possession : '' }}" name="scotland_possession" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_possession" value="{{ ($opponentStats)? $opponentStats->possession : '' }}" name="opponent_possession" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Total Shots: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_shots" value="{{ ($scotlandStats)? $scotlandStats->shots : '' }}" name="scotland_shots" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_shots" value="{{ ($opponentStats)? $opponentStats->shots : '' }}" name="opponent_shots" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Shots On Target: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_on_target" value="{{ ($scotlandStats)? $scotlandStats->on_target : '' }}" name="scotland_on_target" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_on_target" value="{{ ($opponentStats)? $opponentStats->on_target : '' }}" name="opponent_on_target" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Fouls: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_fouls" value="{{ ($scotlandStats)? $scotlandStats->fouls : '' }}" name="scotland_fouls" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_fouls" value="{{ ($opponentStats)? $opponentStats->fouls : '' }}" name="opponent_fouls" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Offside: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_offside" value="{{ ($scotlandStats)? $scotlandStats->offside : '' }}" name="scotland_offside" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_offside" value="{{ ($opponentStats)? $opponentStats->offside : '' }}" name="opponent_offside" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Corners: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_corners" value="{{ ($scotlandStats)? $scotlandStats->corners : '' }}" name="scotland_corners" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_corners" value="{{ ($opponentStats)? $opponentStats->corners : '' }}" name="opponent_corners" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Saves: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_saves" value="{{ ($scotlandStats)? $scotlandStats->saves : '' }}" name="scotland_saves" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_saves" value="{{ ($opponentStats)? $opponentStats->saves : '' }}" name="opponent_saves" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Territotial Advantage: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_ta" value="{{ ($scotlandStats)? $scotlandStats->ta : '' }}" name="scotland_ta" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_ta" value="{{ ($opponentStats)? $opponentStats->ta : '' }}" name="opponent_ta" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Yellow Cards: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_yellow_cards" value="{{ ($scotlandStats)? $scotlandStats->yellow_cards : '' }}" name="scotland_yellow_cards" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_yellow_cards" value="{{ ($opponentStats)? $opponentStats->yellow_cards : '' }}" name="opponent_yellow_cards" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Red Cards: </div>
                        <div class="input statInput">
                            <input type="text" id="scotland_red_cards" value="{{ ($scotlandStats)? $scotlandStats->red_cards : '' }}" name="scotland_red_cards" />
                        </div>
                        <div class="input statInput">
                            <input type="text" id="opponent_red_cards" value="{{ ($opponentStats)? $opponentStats->red_cards : '' }}" name="opponent_red_cards" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Source: </div>
                        <div class="input statInput">
                            <input type="text" id="source" value="{{ ($scotlandStats)? $scotlandStats->source : '' }}" name="source" />
                        </div>
                    </div>
                </div>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/match/{{ $id }}">Cancel</a></div>
            </div>
        </form>
    </div>
@endsection