@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Competitions <a href="/admin/competitions" class="add">Add Competition Type</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatableCompetitions">
            <thead>
            <tr>
                <th>Title</th>
                <th class="noSort"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($competitionList as $competitionType)
                <tr>
                    @if ($competitionType->url != "friendly")
                        <td><a href="/admin/competitions/{{ $competitionType->url }}">{{ $competitionType->title }}</a></td>
                    @else
                        <td>{{ $competitionType->title }}</td>
                    @endif
                    <td><a href="/admin/competitions/{{ $competitionType->id }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/competition/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="inputRow">
                    <div class="inputHead">Title: </div>
                    <div class="input">
                        <input type="text" id="title" value="{{ old('title') ?? $competition->title ?? '' }}" name="title" />
                        <span class="errorMsg">{{ $errors->first('title') }}</span>
                    </div>
                </div>
                @if ($id != 8)
                    <div class="inputRow">
                        <div class="inputHead">Status: </div>
                        <div class="input">
                            <select id="status" name="status">
                                <option value="">Please Select</option>
                                <option value="C" @if((old('status') ?? $competition->status ?? '') == "C")selected="selected"@endif>Competitive</option>
                                <option value="F" @if((old('status') ?? $competition->status ?? '') == "F")selected="selected"@endif>Friendly</option>
                            </select>
                            <span class="errorMsg">{{ $errors->first('status') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Url: </div>
                        <div class="input">
                            <input type="text" id="url" value="{{ old('url') ?? $competition->url ?? '' }}" name="url" />
                            <span class="errorMsg">{{ $errors->first('url') }}</span>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Summary: </div>
                        <div class="input inputClear">
                            <textarea id="summary" name="summary">{{ old('summary') ?? $competition->summary ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Short Summary: </div>
                        <div class="input inputClear">
                            <textarea id="short_summary" name="short_summary">{{ old('short_summary') ?? $competition->short_summary ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Getty Images: </div>
                        <div class="input inputClear">
                            <textarea id="getty_images" name="getty_images">{{ old('getty_images') ?? $competition->getty_images ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Local Getty Images: </div>
                        <div class="input inputClear">
                            <textarea id="local_getty_images" name="local_getty_images">{{ old('local_getty_images') ?? $competition->local_getty_images ?? '' }}</textarea>
                        </div>
                    </div>
                @endif
                <div class="inputRow">
                    <div class="inputHead">Priority: </div>
                    <div class="input">
                        <input type="text" id="priority" value="{{ old('priority') ?? $competition->priority ?? '' }}" name="priority" />
                        <span class="errorMsg">{{ $errors->first('priority') }}</span>
                    </div>
                </div>
                <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/competitions">Cancel</a></div>
            </div>
        </form>
    </div>

@endsection