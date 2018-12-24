@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Videos <a href="/admin/videos" class="add">Add Video</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatableCompetitions">
            <thead>
            <tr>
                <th>Title</th>
                <th class="noSort"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($videoList as $video)
                <tr>
                    <td>{{ $video->title }}</td>
                    <td><a href="/admin/videos/{{ $video->id }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/video/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="inputRow">
                    <div class="inputHead">Title: </div>
                    <div class="input">
                        <input type="text" id="title" value="{{ old('title') ?? $selectedVideo->title ?? '' }}" name="title" />
                        <span class="errorMsg">{{ $errors->first('title') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Sub-title: </div>
                    <div class="input">
                        <input type="text" id="sub_title" value="{{ old('sub_title') ?? $selectedVideo->sub_title ?? '' }}" name="sub_title" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Summary: </div>
                    <div class="input">
                        <input type="text" id="videoSummary" value="{{ old('summary') ?? $selectedVideo->summary ?? '' }}" name="summary" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Match: </div>
                    <div class="input">
                        <select id="match_id" name="match_id">
                            <option value="">Please Select</option>
                            @foreach ($matches as $match)
                                <option value="{{ $match->id }}" @if((old('match_id') ?? $selectedVideo->match_id ?? '') == $match->id)selected="selected"@endif>{{ $match->sitemap_scoreline }}</option>
                            @endforeach
                        </select>
                        <span class="errorMsg">{{ $errors->first('match_id') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Type: </div>
                    <div class="input">
                        <select id="type_id" name="type_id">
                            <option value="">Please Select</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @if((old('type_id') ?? $selectedVideo->type_id ?? '') == $type->id)selected="selected"@endif>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <span class="errorMsg">{{ $errors->first('type_id') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Filename: </div>
                    <div class="input">
                        <input type="text" id="filename" value="{{ old('filename') ?? $selectedVideo->filename ?? '' }}" name="filename" />
                        <span class="errorMsg">{{ $errors->first('filename') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">YouTube: </div>
                    <div class="input">
                        <input type="text" id="youtube" value="{{ old('youtube') ?? $selectedVideo->youtube ?? '' }}" name="youtube" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Featured: </div>
                    <div class="input">
                        <input type="checkbox" id="featured" name="featured" value="1" @if((old('featured') ?? $selectedVideo->featured ?? '') == 1)checked="checked"@endif />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Classic: </div>
                    <div class="input">
                        <input type="checkbox" id="classic" name="classic" value="1" @if((old('classic') ?? $selectedVideo->classic ?? '') == 1)checked="checked"@endif />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">History: </div>
                    <div class="input">
                        <input type="checkbox" id="history" name="history" value="1" @if((old('history') ?? $selectedVideo->history ?? '') == 1)checked="checked"@endif />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">URL: </div>
                    <div class="input">
                        <input type="text" id="url" value="{{ old('url') ?? $selectedVideo->url ?? '' }}" name="url" />
                        <span class="errorMsg">{{ $errors->first('url') }}</span>
                    </div>
                </div>
                <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/videos">Cancel</a></div>
            </div>
        </form>
    </div>

@endsection