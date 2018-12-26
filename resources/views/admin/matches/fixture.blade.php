@extends('admin.app')

@section('head')

@endsection

@section('content')
    <h1 class="fullTitleBar">{{ ($id == null)? 'Add':'Edit' }} Fixture<div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/fixture') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="leftInputs">
                    <div class="inputRow">
                        <div class="inputHead">Date: </div>
                        <div class="input">
                            <input type="text" class="datepicker" id="date" value="{{ old('date') ?? (isset($fixture->date) ? date('Y-m-d', strtotime($fixture->date)) : '') }}" name="date" />
                            <span class="errorMsg">{{ $errors->first('date') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent: </div>
                        <div class="input">
                            <select id="opponent" name="opponent">
                                <option value="">Please Select</option>
                                @foreach ($opponents as $opponent)
                                    <option value="{{ $opponent->id }}" @if((old('opponent') ?? $fixture->opponent_id ?? '') == $opponent->id)selected="selected"@endif>{{ $opponent->name }}</option>
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
                                    <option value="{{ $competition->id }}" @if((old('competition') ?? $fixture->competition_id ?? '') == $competition->id)selected="selected"@endif>{{ $competition->name }}</option>
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
                                    <option value="{{ $round->id }}" @if((old('round') ?? $fixture->round_id ?? '') == $round->id)selected="selected"@endif>{{ $round->name }}</option>
                                @endforeach
                            </select>
                            <span class="errorMsg">{{ $errors->first('round') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Venue: </div>
                        <div class="input">
                            <input type="text" id="venue" value="{{ old('venue') ?? $fixture->venue ?? '' }}" name="venue" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Location: </div>
                        <div class="input">
                            <select id="location" name="location">
                                <option value="0">Please Select</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}" @if((old('location') ?? $fixture->location_id ?? '') == $location->id)selected="selected"@endif>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">H/A: </div>
                        <div class="input">
                            <select id="ha" name="ha">
                                <option value="">Please Select</option>
                                <option value="H" @if((old('ha') ?? $fixture->ha ?? '') == 'H')selected="selected"@endif>Home</option>
                                <option value="A" @if((old('ha') ?? $fixture->ha ?? '') == 'A')selected="selected"@endif>Away</option>
                                <option value="N1" @if((old('ha') ?? $fixture->ha ?? '') == 'N1')selected="selected"@endif>Neutral (First)</option>
                                <option value="N" @if((old('ha') ?? $fixture->ha ?? '') == 'N')selected="selected"@endif>Neutral (Second)</option>
                            </select>
                            <span class="errorMsg">{{ $errors->first('ha') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Kick-Off: </div>
                        <div class="input">
                            <input type="text" id="kickoff" value="{{ old('kickoff') ?? $fixture->kickoff ?? '' }}" name="kickoff" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Ranking: </div>
                        <div class="input">
                            <input type="text" id="ranking" value="{{ old('ranking') ?? $fixture->opp_ranking ?? '' }}" name="ranking" />
                        </div>
                    </div>
                </div>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:$('form').submit();">Save</a> <a class="addLink" href="/admin/matches">Cancel</a></div>
            </div>
        </form>
    </div>
    <div class="notification">
        <p>Before you add or edit a fixture, be sure to check the following items have already been added:</p>
        <ol>
            <li>The Opponent</li>
            <li>The Competition</li>
            <li>The Location</li>
        </ol>
        <div class="submitRow"><a class="addLink closeNotification" href="#">OK</a></div>
    </div>
@endsection