@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Edit Match&nbsp;&nbsp;&nbsp;<span class="subTitle">Strip Details</span><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/match/strips/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $match->id }}">
            <div>
                <div class="leftInputs">
                    <div class="inputRow">
                        <div class="inputHead">Scotland Top: </div>
                        <div class="input">
                            <select id="scotland_top" name="scotland_top">
                                <option value="">Please Select</option>
                                @foreach ($scotlandShirts as $strip)
                                    @if ($match->strips && $match->strips->strip)
                                        <option value="{{ $strip->id }}" {!! ($match->strips->strip->id == $strip->id)? 'selected="selected"':'' !!}>{{ $strip->name }}</option>
                                    @else
                                        <option value="{{ $strip->id }}">{{ $strip->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Scotland Shorts: </div>
                        <div class="input">
                            <input type="text" id="scotland_shorts" value="{{ ($match->strips) ? $match->strips->scotland_shorts : '' }}" name="scotland_shorts" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Shirt: </div>
                        <div class="input">
                            <input type="text" id="opponent_shirt" value="{{ ($match->strips) ? $match->strips->opponent_shirt : '' }}" name="opponent_shirt" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Opponent Shorts: </div>
                        <div class="input">
                            <input type="text" id="opponent_shorts" value="{{ ($match->strips) ? $match->strips->opponent_shorts : '' }}" name="opponent_shorts" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Goalkeeper Top: </div>
                        <div class="input">
                            <input type="text" id="goalkeeper_top" value="{{ ($match->strips) ? $match->strips->goalkeeper_top : '' }}" name="goalkeeper_top" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Strip Note: </div>
                        <div class="input">
                            <textarea id="match_note" name="match_note">{{ ($match->strips) ? $match->strips->match_note : '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/match/{{ $match->id }}">Cancel</a></div>
            </div>
        </form>
    </div>
@endsection