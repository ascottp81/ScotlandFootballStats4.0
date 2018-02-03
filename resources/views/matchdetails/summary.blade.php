@if ($match->summary || $match->incidents->count() )
<div id="summary">
    @if ($match->incidents->count() == 0 || config('app.livemedia'))
    <div class="mdBasicLeft">
        @include('matchdetails.partial.basicmatchdetails')
    </div>
    <div class="summary novideo">{!! $match->summary->content !!}</div>
    @else
    <div class="summary">@if ($match->summary){!! $match->summary->content !!}@else <p>There is currently no match summary for this match.<br />There may be one in the near future.</p><p>In the mean time you may want to read the history section <a href="/history">here</a>.</p>@endif</div>
    <div class="timeline">
        @foreach ($match->incidents()->get() as $incident)
        <div class="incident">
            <div class="incidentImage"><img src="/storage/animations/incidents/{{ $incident->id }}.gif" /></div>
            <div class="incidentData">
                <div class="incidentFlag"><img src="/img/flags/{{ $incident->flag }}.gif" /></div>
                <div class="incidentMinute">{{ $incident->minute }} Minutes</div>
                <div class="incidentPlayer">{{ $incident->player }}</div>
                <div class="incidentAction">{{ $incident->type->text }}</div>
                <div class="incidentScore">{{ $incident->scoreline }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endif