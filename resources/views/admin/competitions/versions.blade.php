@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">{{ $competitionType->title }} <a href="/admin/competitions/{{ $competitionType->url }}" class="add">Add Competition</a><div class="breadcrumb"><a href="/logout">Logout</a></div><div class="breadcrumb"><a href="/admin/competitions">Competitions</a> > <span>{{ $competitionType->title }}</span></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatableCompetitions">
            <thead>
                <tr>
                    <th>Title</th>
                    <th class="noSort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($competitions as $competition)
                <tr>
                	<td>{{ $competition->name }}</td>
                    <td><a href="/admin/competitions/{{ $competitionType->url }}/{{ $competition->id }}">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/competition-version/') }}">
		{{ csrf_field() }}
        <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
        <div>
            <div class="inputRow">
                <div class="inputHead">Name: </div>
                <div class="input">
                    <input type="text" id="name" value="{{ old('name') ?? $competitionVersion->name ?? '' }}" name="name" data-required="true" />
                    <span class="errorMsg">{{ $errors->first('name') }}</span>
                </div>
            </div>
            @if ($id > 0)
            <div class="inputRow">
                <div class="inputHead">Competition Type: </div>
                <div class="input">
                    <select id="competition_type_id" name="competition_type_id">
                        <option value="">Please Select</option>
                        @foreach ($competitionTypes as $type)
                        <option value="{{ $type->id }}" @if((old('competition_type_id') ?? $competitionVersion->competition_type_id ?? '') == $type->id)selected="selected"@endif>{{ $type->title }}</option>
                        @endforeach
                    </select>
                    <span class="errorMsg">{{ $errors->first('competition_type_id') }}</span>
                </div>
            </div>
            @else
            <input type="hidden" id="competition_type_id" value="{{ $competitionType->id }}" name="competition_type_id" />
            @endif
            <div class="inputRow">
                <div class="inputHead">Year: </div>
                <div class="input">
                    <input type="text" id="year" value="{{ old('year') ?? $competitionVersion->year ?? '' }}" name="year" data-required="true" />
                    <span class="errorMsg">{{ $errors->first('year') }}</span>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Stage: </div>
                <div class="input">
                    <select id="stage" name="stage">
                        <option value="">None</option>
                        <option value="Qualifiers" @if((old('stage') ?? $competitionVersion->stage ?? '') == "Qualifiers")selected="selected"@endif>Qualifiers</option>
                        <option value="Finals" @if((old('stage') ?? $competitionVersion->stage ?? '') == "Finals")selected="selected"@endif>Finals</option>
                    </select>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Comment: </div>
                <div class="input">
                    <input type="text" id="comment" value="{{ old('comment') ?? $competitionVersion->comment ?? '' }}" name="comment" />
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Outcome: </div>
                <div class="input">
                    <select id="outcome" name="outcome">
                        <option value="">&mdash;</option>
                        <option value="won" @if((old('outcome') ?? $competitionVersion->outcome ?? '') == "won")selected="selected"@endif>Won</option>
                        <option value="shared" @if((old('outcome') ?? $competitionVersion->outcome ?? '') == "shared")selected="selected"@endif>Shared</option>
                        <option value="qualified" @if((old('outcome') ?? $competitionVersion->outcome ?? '') == "qualified")selected="selected"@endif>Qualified</option>
                    </select>
                </div>
            </div>
            <div class="inputRow">
                <div class="inputHead">Withdrew: </div>
                <div class="input">
                    <input type="checkbox" id="withdrew" name="withdrew" value="1" @if((old('withdrew') ?? $competitionVersion->withdrew ?? '') == 1)checked="checked"@endif />
                </div>
            </div>
            <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/competitions/{{ $competitionType->url }}">Cancel</a></div>
        </div>
        </form>  
    </div>

    <div class="cmsContent cmsCompetitionTables">
        <h2>Group Tables</h2>
        @if($id > 0)
        <table>
            <tbody>
            @foreach ($tables as $table)
                <tr>
                    <td>{{ $table->competitionRound->name }}</td>
                    <td><a href="/admin/competitions/{{ $id }}/table/{{ $table->id }}">Table</a></td>
                    <td><a href="/admin/competitions/{{ $id }}/table/{{ $table->id }}/results">Results</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p><a href="/admin/competitions/{{ $id }}/table" class="add">Add Group Table</a></p>
        @else
        <p>You need to add a competition before you can add a group table.</p>
        @endif
    </div>

@endsection