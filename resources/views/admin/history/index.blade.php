@extends('admin.app')

@section('head')
<script type="text/javascript">
    var famousMatches;
    $(document).ready(function() {

        var famousMatchIds = String($("#famous_matches").val());
        famousMatches = [];
        if (famousMatchIds != "") {
            famousMatches = famousMatchIds.split(",");
        }

        $("#matches").change(function(){

            var exists = false;
            for( var i = 0; i < famousMatches.length; i++) {
                if ( famousMatches[i] == $(this).val()) {
                    exists = true;
                }
            }

            if (exists == false) {
                famousMatches.push($(this).val());
                $("#famous_matches").val(famousMatches.join(","));
                $("#famousMatches").append('<span><a data-id="' + $(this).val() + '">X</a> ' + $("option:selected", this).text() + '</span>');
            }

            document.getElementById("matches").selectedIndex = 0;

            famousDelete();
        });

        famousDelete();

    });

    function famousDelete() {
        $("#famousMatches span a").click(function(){
            var id = $(this).data("id");

            for( var i = 0; i < famousMatches.length; i++){
                if ( famousMatches[i] == id) {
                    famousMatches.splice(i, 1);
                }
            }

            $(this).parent().remove();

            $("#famous_matches").val(famousMatches.join(","));
        });
    }
</script>
@endsection

@section('content')
    <h1 class="fullTitleBar">History <a href="/admin/history" class="add">Add Chapter</a><div class="breadcrumb"><a href="/logout">Logout</a></div><div class="breadcrumb"><span>History</span></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatableCompetitions">
            <thead>
            <tr>
                <th>Title</th>
                <th class="noSort"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($historyList as $chapter)
                <tr>
                    <td><a href="/admin/history/{{ $chapter->url }}">{{ $chapter->title }}</a></td>
                    <td><a href="/admin/history/{{ $chapter->id }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/history/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="inputRow">
                    <div class="inputHead">Title: </div>
                    <div class="input">
                        <input type="text" id="title" value="{{ old('title') ?? $history->title ?? '' }}" name="title" />
                        <span class="errorMsg">{{ $errors->first('title') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Period: </div>
                    <div class="input">
                        <input type="text" id="period" value="{{ old('period') ?? $history->period ?? '' }}" name="period" />
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">First Year: </div>
                    <div class="input">
                        <input type="text" id="first_year" value="{{ old('first_year') ?? $history->first_year ?? '' }}" name="first_year" />
                        <span class="errorMsg">{{ $errors->first('first_year') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">URL: </div>
                    <div class="input">
                        <input type="text" id="url" value="{{ old('url') ?? $history->url ?? '' }}" name="url" />
                        <span class="errorMsg">{{ $errors->first('url') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Summary: </div>
                    <div class="input inputClear">
                        <textarea id="summary" name="summary">{{ old('summary') ?? $history->summary ?? '' }}</textarea>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Getty Image: </div>
                    <div class="input inputClear">
                        <textarea id="getty_image" name="getty_image">{{ old('getty_image') ?? $history->getty_image ?? '' }}</textarea>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Famous Matches: </div>
                    <div class="input">
                        <select id="matches" name="matches">
                            <option value="">Please Select</option>
                            @foreach ($matches as $match)
                                <option value="{{ $match->id }}">{{ $match->sitemap_scoreline }}</option>
                            @endforeach
                        </select>
                        <div id="famousMatches">
                            @if ($id > 0)
                            @foreach ($history->famous_matches as $match)
                                <span><a data-id="{{ $match->id }}">X</a> {{ $match->sitemap_scoreline }}</span>
                            @endforeach
                            @endif
                        </div>
                        <input type="hidden" id="famous_matches" name="famous_matches" value="{{ old('famous_matches') ?? $history->original_famous_matches ?? '' }}" />
                        <span class="errorMsg">{{ $errors->first('famous_matches') }}</span>
                    </div>
                </div>
                <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/history">Cancel</a></div>
            </div>
        </form>
    </div>

@endsection