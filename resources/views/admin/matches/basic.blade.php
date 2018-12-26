@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Edit Match <span class="subTitle">Basic Details</span><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/match/basic') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $match->id }}">
            <div>
                <div class="leftInputs">
                    <div class="inputRow">
                        <div class="inputHead">Date: </div>
                        <div class="input">
                            <input type="text" class="datepicker" id="date" value="{{ old('date') ?? $match->date->format('Y-m-d') }}" name="date" />
                            <span class="errorMsg">{{ $errors->first('date') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent: </div>
                        <div class="input">
                            <select id="opponent" name="opponent">
                                <option value="">Please Select</option>
                                @foreach ($opponents as $opponent)
                                    <option value="{{ $opponent->id }}" @if((old('opponent') ?? $match->opponent_id) == $opponent->id)selected="selected"@endif>{{ $opponent->name }}</option>
                                @endforeach
                            </select>
                            <span class="errorMsg">{{ $errors->first('opponent') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Competition: </div>
                        <div class="input">
                            <select id="competition" name="competition">
                                <option value="">Please Select</option>
                                @foreach ($competitions as $competition)
                                    <option value="{{ $competition->id }}" @if((old('competition') ?? $match->competition_id) == $competition->id)selected="selected"@endif>{{ $competition->name }}</option>
                                @endforeach
                            </select>
                            <span class="errorMsg">{{ $errors->first('competition') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Round: </div>
                        <div class="input">
                            <select id="round" name="round">
                                <option value="">Please Select</option>
                                @foreach ($rounds as $round)
                                    <option value="{{ $round->id }}" @if((old('round') ?? $match->round_id) == $round->id)selected="selected"@endif>{{ $round->name }}</option>
                                @endforeach
                            </select>
                            <span class="errorMsg">{{ $errors->first('round') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Other Competition: </div>
                        <div class="input">
                            <select id="other_competition" name="other_competition">
                                <option value="0">None</option>
                                @foreach ($competitions as $competition)
                                    <option value="{{ $competition->id }}" @if((old('other_competition') ?? $match->other_competition_id) == $competition->id)selected="selected"@endif>{{ $competition->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Venue: </div>
                        <div class="input">
                            <input type="text" id="venue" value="{{ old('venue') ?? $match->venue }}" name="venue" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Location: </div>
                        <div class="input">
                            <select id="location" name="location">
                                <option value="0">Please Select</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}" @if((old('location') ?? $match->location_id) == $location->id)selected="selected"@endif>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">H/A: </div>
                        <div class="input">
                            <select id="ha" name="ha">
                                <option value="">Please Select</option>
                                <option value="H" @if((old('ha') ?? $match->ha) == 'H')selected="selected"@endif>Home</option>
                                <option value="A" @if((old('ha') ?? $match->ha) == 'A')selected="selected"@endif>Away</option>
                                <option value="N1" @if((old('ha') ?? $match->ha) == 'N1')selected="selected"@endif>Neutral (First)</option>
                                <option value="N" @if((old('ha') ?? $match->ha) == 'N')selected="selected"@endif>Neutral (Second)</option>
                            </select>
                            <span class="errorMsg">{{ $errors->first('ha') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Attendance: </div>
                        <div class="input">
                            <input type="text" id="attendance" value="{{ old('attendance') ?? $match->getOriginal('attendance') }}" name="attendance" />
                            <span class="errorMsg">{{ $errors->first('attendance') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Result: </div>
                        <div class="input">
                            <input type="text" id="result" value="{{ old('result') ?? $match->result }}" name="result" />
                            <span class="errorMsg">{{ $errors->first('result') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Kick-Off: </div>
                        <div class="input">
                            <input type="text" id="kickoff" value="{{ old('kickoff') ?? $match->kickoff }}" name="kickoff" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Manager: </div>
                        <div class="input">
                            <select id="manager" name="manager">
                                <option value="0">None</option>
                                @foreach ($managers as $manager)
                                    <option value="{{ $manager->id }}" @if((old('manager') ?? $match->manager_id) == $manager->id)selected="selected"@endif>{{ $manager->fullname }} ({{ $manager->from }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Manager Text: </div>
                        <div class="input">
                            <input type="text" id="manager_text" value="{{ old('manager_text') ?? $match->manager }}" name="manager_text" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Ranking: </div>
                        <div class="input">
                            <input type="text" id="opp_ranking" value="{{ old('opp_ranking') ?? $match->opp_ranking }}" name="opp_ranking" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Result Comment: </div>
                        <div class="input">
                            <input type="text" id="result_comment" value="{{ old('result_comment') ?? $match->getOriginal('result_comment') }}" name="result_comment" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">General Comment: </div>
                        <div class="input">
                            <input type="text" id="comment" value="{{ old('comment') ?? $match->comment }}" name="comment" />
                        </div>
                    </div>

                </div>
                <div class="leftInputs">
                    <div class="inputRow">
                        <div class="inputHead">Scotland Scorers: </div>
                        <div class="input inputClear">
                            <textarea id="scot_scorers" name="scot_scorers">{{ old('scot_scorers') ?? $match->getOriginal('scot_scorers') }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Scorers: </div>
                        <div class="input inputClear">
                            <textarea id="opp_scorers" name="opp_scorers">{{ old('opp_scorers') ?? $match->getOriginal('opp_scorers') }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Scotland Team: </div>
                        <div class="input inputClear">
                            <textarea id="team" name="team">{{ old('team') ?? $match->team }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Team: </div>
                        <div class="input inputClear">
                            <textarea id="opp_team" name="opp_team">{{ old('opp_team') ?? $match->getOriginal('opp_team') }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Scotland Red Cards: </div>
                        <div class="input">
                            <input type="text" id="scot_red_card" value="{{ old('scot_red_card') ?? $match->getOriginal('scot_red_card') }}" name="scot_red_card" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Red Cards: </div>
                        <div class="input">
                            <input type="text" id="opp_red_card" value="{{ old('opp_red_card') ?? $match->getOriginal('opp_red_card') }}" name="opp_red_card" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Scotland Missed Pens: </div>
                        <div class="input">
                            <input type="text" id="scot_pen_miss" value="{{ old('scot_pen_miss') ?? $match->getOriginal('scot_pen_miss') }}" name="scot_pen_miss" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Missed Pens: </div>
                        <div class="input">
                            <input type="text" id="opp_pen_miss" value="{{ old('opp_pen_miss') ?? $match->getOriginal('opp_pen_miss') }}" name="opp_pen_miss" />
                        </div>
                    </div>
                </div>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/match/{{ $match->id }}">Cancel</a></div>
            </div>
        </form>
    </div>
    <div class="notification">
        <p>Before you edit a match, be sure to check the following items have already been added:</p>
        <ol>
            <li>The Opponent</li>
            <li>The Competition(s)</li>
            <li>The Location</li>
            <li>The Manager</li>
            <li>All Players</li>
            <li>Each Player's Club</li>
        </ol>
        <div class="submitRow"><a class="addLink closeNotification" href="#">OK</a></div>
    </div>
@endsection