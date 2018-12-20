@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">{{ $competition->name }} <a href="/admin/competitions/{{ $competition->id }}/table/{{ $tableId }}/results" class="add">Add Result</a><div class="breadcrumb"><a href="/logout">Logout</a></div><div class="breadcrumb"><a href="/admin/competitions">Competitions</a> > <a href="/admin/competitions/{{ $competition->type->url }}">{{ $competition->type->title }}</a> > <span>{{ $competition->name }}</span></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Result</th>
                    <th>Round</th>
                    <th class="noSort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                <tr>
                	<td>{{ $result->match_date->format('Y-m-d') }}</td>
                    <td>{{ $result->result }}</td>
                    <td>{{ $result->match_round }}</td>
                    <td><a href="/admin/competitions/{{ $competition->id }}/table/{{ $tableId }}/results/{{ $result->id }}">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/competition-result/') }}">
		{{ csrf_field() }}
        <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">

        <div>
            @if ($id > 0)
                <div class="inputRow">
                    <div class="inputHead">Competition: </div>
                    <div class="input">
                        <select id="competition_table_id" name="competition_table_id">
                            @foreach ($competitionTables as $table)
                                <option value="{{ $table->id }}" @if((old('competition_table_id') ?? $tableResult->competition_table_id ?? '') == $table->id)selected="selected"@endif>{{ $table->competition->name }} - {{ $table->competitionRound->name }}</option>
                            @endforeach
                        </select>
                        <span class="errorMsg">{{ $errors->first('competition_type_id') }}</span>
                    </div>
                </div>
            @else
                <input type="hidden" name="competition_table_id" id="competition_table_id" value="{{ $tableId }}">
            @endif
            <div class="inputRow">
                <div class="inputHead">Date: </div>
                <div class="input">
                    <input type="text" class="datepicker" id="match_date" value="{{ old('match_date') ?? $tableResult->match_date ?? '' }}" name="match_date" data-required="true" />
                    <span class="errorMsg">{{ $errors->first('match_date') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Home: </div>
                <div class="input">
                    <select id="home_team_id" name="home_team_id">
                        <option value="">Please Select</option>
                        <option value="0" @if((old('home_team_id') ?? $tableResult->home_team_id ?? '-1') == 0)selected="selected"@endif>Scotland</option>
                        @foreach ($opponents as $opponent)
                        <option value="{{ $opponent->id }}" @if((old('home_team_id') ?? $tableResult->home_team_id ?? '-1') == $opponent->id)selected="selected"@endif>{{ $opponent->name }}</option>
                        @endforeach
                    </select>
                    <span class="errorMsg">{{ $errors->first('home_team_id') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Away: </div>
                <div class="input">
                    <select id="away_team_id" name="away_team_id">
                        <option value="">Please Select</option>
                        <option value="0" @if((old('away_team_id') ?? $tableResult->away_team_id ?? '-1') == 0)selected="selected"@endif>Scotland</option>
                        @foreach ($opponents as $opponent)
                        <option value="{{ $opponent->id }}" @if((old('away_team_id') ?? $tableResult->away_team_id ?? '-1') == $opponent->id)selected="selected"@endif>{{ $opponent->name }}</option>
                        @endforeach
                    </select>
                    <span class="errorMsg">{{ $errors->first('away_team_id') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Score: </div>
                <div class="input">
                    <input style="width:50px;float:left;" type="text" id="home_goals" value="{{ old('home_goals') ?? $tableResult->home_goals ?? '' }}" name="home_goals" />
                    <span style="width:20px;float:left; text-align:center;">&mdash;</span>
                    <input style="width:50px;float:left;" type="text" id="away_goals" value="{{ old('away_goals') ?? $tableResult->away_goals ?? '' }}" name="away_goals" />
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Round: </div>
                <div class="input">
                    <input type="text" id="match_round" value="{{ old('match_round') ?? $tableResult->match_round ?? '' }}" name="match_round" />
                    <span class="errorMsg">{{ $errors->first('match_round') }}</span>
                </div>
            </div>
            <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/competitions/{{ $competition->id }}/table/{{ $tableId }}/results">Cancel</a></div>
        </div>
        </form>  
    </div>
    
@endsection