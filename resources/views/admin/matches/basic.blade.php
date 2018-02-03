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
                            <input type="text" class="datepicker" id="match_date" value="{{ $match->date->format('Y-m-d') }}" name="match_date" data-required="true" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent: </div>
                        <div class="input">
                            <select id="opponent" name="opponent">
                                <option value="">Please Select</option>
                                @foreach ($opponents as $opponent)
                                    <option value="{{ $opponent->id }}" {!! ($match->opponent_id == $opponent->id)? 'selected="selected"':'' !!}>{{ $opponent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Competition: </div>
                        <div class="input">
                            <select id="competition" name="competition">
                                <option value="">Please Select</option>
                                @foreach ($competitions as $competition)
                                    <option value="{{ $competition->id }}" {!! ($match->competition_id == $competition->id)? 'selected="selected"':'' !!}>{{ $competition->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Round: </div>
                        <div class="input">
                            <select id="round" name="round">
                                <option value="">Please Select</option>
                                @foreach ($rounds as $round)
                                    <option value="{{ $round->id }}" {!! ($match->round_id == $round->id)? 'selected="selected"':'' !!}>{{ $round->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Other Competition: </div>
                        <div class="input">
                            <select id="other_competition" name="other_competition">
                                <option value="0">None</option>
                                @foreach ($competitions as $competition)
                                    <option value="{{ $competition->id }}" {!! ($match->other_competition_id == $competition->id)? 'selected="selected"':'' !!}>{{ $competition->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Venue: </div>
                        <div class="input">
                            <input type="text" id="venue" value="{{ $match->venue }}" name="venue" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Location: </div>
                        <div class="input">
                            <select id="location" name="location">
                                <option value="">Please Select</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}" {!! ($match->location_id == $location->id)? 'selected="selected"':'' !!}>{{ $location->city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">H/A: </div>
                        <div class="input">
                            <select id="ha" name="ha">
                                <option value="">Please Select</option>
                                <option value="H" {!! ($match->ha == 'H')? 'selected="selected"':'' !!}>Home</option>
                                <option value="A" {!! ($match->ha == 'A')? 'selected="selected"':'' !!}>Away</option>
                                <option value="N1" {!! ($match->ha == 'N1')? 'selected="selected"':'' !!}>Neutral (First)</option>
                                <option value="N" {!! ($match->ha == 'N')? 'selected="selected"':'' !!}>Neutral (Second)</option>
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Attendance: </div>
                        <div class="input">
                            <input type="text" id="attendance" value="{{ $match->getOriginal('attendance') }}" name="attendance" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Result: </div>
                        <div class="input">
                            <input type="text" id="result" value="{{ $match->result }}" name="result" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Kick-Off: </div>
                        <div class="input">
                            <input type="text" id="kickoff" value="{{ $match->kickoff }}" name="kickoff" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Manager: </div>
                        <div class="input">
                            <select id="manager" name="manager">
                                <option value="0">None</option>
                                @foreach ($managers as $manager)
                                    <option value="{{ $manager->id }}" {!! ($match->manager_id == $manager->id)? 'selected="selected"':'' !!}>{{ $manager->fullname }} ({{ $manager->from }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Manager Text: </div>
                        <div class="input">
                            <input type="text" id="manager_text" value="{{ $match->manager }}" name="manager_text" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Ranking: </div>
                        <div class="input">
                            <input type="text" id="opp_ranking" value="{{ $match->opp_ranking }}" name="opp_ranking" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Result Comment: </div>
                        <div class="input">
                            <input type="text" id="result_comment" value="{{ $match->getOriginal('result_comment') }}" name="result_comment" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">General Comment: </div>
                        <div class="input">
                            <input type="text" id="comment" value="{{ $match->comment }}" name="comment" data-required="false" />
                        </div>
                    </div>

                </div>
                <div class="leftInputs">
                    <div class="inputRow">
                        <div class="inputHead">Scotland Scorers: </div>
                        <div class="input inputClear">
                            <textarea id="scot_scorers" name="scot_scorers">{{ $match->getOriginal('scot_scorers') }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Scorers: </div>
                        <div class="input inputClear">
                            <textarea id="opp_scorers" name="opp_scorers">{{ $match->getOriginal('opp_scorers') }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Scotland Team: </div>
                        <div class="input inputClear">
                            <textarea id="team" name="team">{{ $match->team }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Team: </div>
                        <div class="input inputClear">
                            <textarea id="opp_team" name="opp_team">{{ $match->getOriginal('opp_team') }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Scotland Red Cards: </div>
                        <div class="input">
                            <input type="text" id="scot_red_card" value="{{ $match->getOriginal('scot_red_card') }}" name="scot_red_card" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Red Cards: </div>
                        <div class="input">
                            <input type="text" id="opp_red_card" value="{{ $match->getOriginal('opp_red_card') }}" name="opp_red_card" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Scotland Missed Pens: </div>
                        <div class="input">
                            <input type="text" id="scot_pen_miss" value="{{ $match->getOriginal('scot_pen_miss') }}" name="scot_pen_miss" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Missed Pens: </div>
                        <div class="input">
                            <input type="text" id="opp_pen_miss" value="{{ $match->getOriginal('opp_pen_miss') }}" name="opp_pen_miss" data-required="false" />
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
        <div class="submitRow"><a class="addLink closeNotification" id="submit" href="#">OK</a></div>
    </div>
@endsection