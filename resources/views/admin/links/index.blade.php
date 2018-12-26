@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">External Links <a href="/admin/links" class="add">Add Link</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatableCompetitions">
            <thead>
            <tr>
                <th>Title</th>
                <th class="noSort"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($linkList as $link)
                <tr>
                    <td>{{ $link->title }}</td>
                    <td><a href="/admin/links/{{ $link->id }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/link/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="inputRow">
                    <div class="inputHead">Title: </div>
                    <div class="input">
                        <input type="text" id="title" value="{{ old('title') ?? $selectedLink->title ?? '' }}" name="title" />
                        <span class="errorMsg">{{ $errors->first('title') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">URL: </div>
                    <div class="input">
                        <input type="text" id="url" value="{{ old('url') ?? $selectedLink->url ?? '' }}" name="url" />
                        <span class="errorMsg">{{ $errors->first('url') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Type: </div>
                    <div class="input">
                        <select id="type" name="type">
                            <option value="">Please Select</option>
                            <option value="official" @if((old('type') ?? $selectedLink->type ?? '') == 'official')selected="selected"@endif>Official</option>
                            <option value="featured" @if((old('type') ?? $selectedLink->type ?? '') == 'featured')selected="selected"@endif>Featured</option>
                            <option value="other" @if((old('type') ?? $selectedLink->type ?? '') == 'other')selected="selected"@endif>Other</option>
                        </select>
                        <span class="errorMsg">{{ $errors->first('type') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Summary: </div>
                    <div class="input inputClear">
                        <textarea id="summary" name="summary">{{ old('summary') ?? $selectedLink->summary ?? '' }}</textarea>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Order: </div>
                    <div class="input">
                        <input type="text" id="list_order" value="{{ old('list_order') ?? $selectedLink->list_order ?? '' }}" name="list_order" />
                        <span class="errorMsg">{{ $errors->first('list_order') }}</span>
                    </div>
                </div>
                <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/links">Cancel</a></div>
            </div>
        </form>
    </div>

@endsection