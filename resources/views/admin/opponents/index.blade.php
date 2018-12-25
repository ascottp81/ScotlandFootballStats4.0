@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Opponents <a href="/admin/opponents" class="add">Add Opponent</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatableCompetitions">
            <thead>
            <tr>
                <th>Name</th>
                <th class="noSort"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($opponentList as $opponent)
                <tr>
                    <td>{{ $opponent->name }}</td>
                    <td><a href="/admin/opponents/{{ $opponent->id }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/opponent/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="inputRow">
                    <div class="inputHead">Name: </div>
                    <div class="input">
                        <input type="text" id="name" value="{{ old('name') ?? $selectedOpponent->name ?? '' }}" name="name" />
                        <span class="errorMsg">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Abbreviated Name: </div>
                    <div class="input">
                        <input type="text" id="name" value="{{ old('abbr_name') ?? $selectedOpponent->abbr_name ?? '' }}" name="abbr_name" />
                        <span class="errorMsg">{{ $errors->first('abbr_name') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">URL: </div>
                    <div class="input">
                        <input type="text" id="url" value="{{ old('url') ?? $selectedOpponent->url ?? '' }}" name="url" />
                        <span class="errorMsg">{{ $errors->first('url') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Region: </div>
                    <div class="input">
                        <select id="region_id" name="region_id">
                            <option value="">Please Select</option>
                            @foreach ($regions as $region)
                            <option value="{{ $region->id }}" @if((old('region_id') ?? $selectedOpponent->region_id ?? '') == $region->id)selected="selected"@endif>{{ $region->title }}</option>
                            @endforeach
                        </select>
                        <span class="errorMsg">{{ $errors->first('region_id') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Years: </div>
                    <div class="input">
                        <input type="text" id="years" value="{{ old('years') ?? $selectedOpponent->years ?? '' }}" name="years" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Memorable Match: </div>
                    <div class="input">
                        <input type="text" id="memorable_match" value="{{ old('memorable_match') ?? $selectedOpponent->memorable_match ?? '' }}" name="memorable_match" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Summary: </div>
                    <div class="input inputClear">
                        <textarea id="summary" name="summary">{{ old('summary') ?? $selectedOpponent->summary ?? '' }}</textarea>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Getty Image: </div>
                    <div class="input inputClear">
                        <textarea id="getty_image" name="getty_image">{{ old('getty_image') ?? $selectedOpponent->getty_image ?? '' }}</textarea>
                    </div>
                </div>
                <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/opponents">Cancel</a></div>
            </div>
        </form>
    </div>

@endsection