@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">FIFA Rankings <a href="/admin/rankings" class="add">Add Ranking</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatableMatches">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Ranking</th>
                    <th>Europe</th>
                    <th>Points</th>
                    <th class="noSort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rankingList as $rank)
                <tr>
                    <td>{{ $rank->date->format('Y-m-d') }}</td>
                    <td>{{ $rank->ranking }}</td>
                    <td>{{ $rank->europe }}</td>
                    <td>{{ $rank->points }}</td>
                    <td><a href="/admin/rankings/{{ $rank->id }}">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/ranking/') }}">
		{{ csrf_field() }}
        <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
        <div>
            <div class="inputRow">
                <div class="inputHead">Date: </div>
                <div class="input">
                    <input type="text" class="datepicker" id="date" value="{{ old('date') ?? (($ranking) ? $ranking->date->format('Y-m-d') : '') }}" name="date" />
                    <span class="errorMsg">{{ $errors->first('date') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Ranking: </div>
                <div class="input">
                    <input type="text" id="ranking" value="{{ old('ranking') ?? $ranking->ranking ?? '0' }}" name="ranking" />
                    <span class="errorMsg">{{ $errors->first('ranking') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Europe: </div>
                <div class="input">
                    <input type="text" id="europe" value="{{ old('europe') ?? $ranking->europe ?? '0' }}" name="europe" />
                    <span class="errorMsg">{{ $errors->first('europe') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Points: </div>
                <div class="input">
                    <input type="text" id="points" value="{{ old('points') ?? $ranking->points ?? '0' }}" name="points" />
                    <span class="errorMsg">{{ $errors->first('points') }}</span>
                </div>
            </div>
            <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/rankings">Cancel</a></div>
        </div>
        </form>  
    </div>
    
@endsection