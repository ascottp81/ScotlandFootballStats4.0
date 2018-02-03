@extends('admin.app')

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
                            <input type="text" class="datepicker" id="date" value="{{ $fixture->date ?? '' }}" name="date" data-required="true" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent: </div>
                        <div class="input">
                            <select id="opponent" name="opponent">
                                <option value="">Please Select</option>
                                @foreach ($opponents as $opponent)
                                    <option value="{{ $opponent->id }}" {!! ($fixture)? (($fixture->opponent_id == $opponent->id)? 'selected="selected"':''):'' !!}>{{ $opponent->name }}</option>
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
                                    <option value="{{ $competition->id }}" {!! ($fixture)? (($fixture->competition_id == $competition->id)? 'selected="selected"':''):'' !!}>{{ $competition->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Venue: </div>
                        <div class="input">
                            <input type="text" id="venue" value="{{ $fixture->venue ?? '' }}" name="venue" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Location: </div>
                        <div class="input">
                            <select id="location" name="location">
                                <option value="">Please Select</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}" {!! ($fixture)? (($fixture->location_id == $location->id)? 'selected="selected"':''):'' !!}>{{ $location->city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">H/A: </div>
                        <div class="input">
                            <select id="ha" name="ha">
                                <option value="">Please Select</option>
                                <option value="H" {!! ($fixture)? (($fixture->ha == 'H')? 'selected="selected"':''):'' !!}>Home</option>
                                <option value="A" {!! ($fixture)? (($fixture->ha == 'A')? 'selected="selected"':''):'' !!}>Away</option>
                                <option value="N1" {!! ($fixture)? (($fixture->ha == 'N1')? 'selected="selected"':''):'' !!}>Neutral (First)</option>
                                <option value="N" {!! ($fixture)? (($fixture->ha == 'N')? 'selected="selected"':''):'' !!}>Neutral (Second)</option>
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Kick-Off: </div>
                        <div class="input">
                            <input type="text" id="kickoff" value="{{ $fixture->kickoff ?? '' }}" name="kickoff" data-required="false" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Ranking: </div>
                        <div class="input">
                            <input type="text" id="ranking" value="{{ $fixture->ranking ?? '' }}" name="ranking" data-required="false" />
                        </div>
                    </div>
                </div>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/matches">Cancel</a></div>
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
        <div class="submitRow"><a class="addLink closeNotification" id="submit" href="#">OK</a></div>
    </div>
@endsection