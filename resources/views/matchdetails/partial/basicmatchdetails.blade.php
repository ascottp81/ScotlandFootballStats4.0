<div class="mdBasicDetails">
    <p class="competition">{{ $match->competition->name }}@if ($match->other_competition_id > 0) {!! ' /<br />' . $match->otherCompetition->name !!}@endif</p>
    <p>{{ $match->date->format('D jS F Y') }}@if ($match->kickoff != "unknown")<br />{{ $match->kickoff }}@endif</p>
    <p>{{ $match->venue_ha }}<br />Att: {{ $match->attendance }}</p>
    @if ($match->comment != "")
        <p class="basicComment">{{ $match->comment }}</p>
    @endif
</div>
@if ($match->competition_table_count > 0)
    <div class="mdCurrentTable">
        <div class="basicLineupsTitle">{{ ($match->competition_table->group_name != "")? $match->competition_table->group_name : 'Group Table' }} <div class="currentTableDate">({{ $match->match_round_date }})</div></div>
        <div class="currentTableHolder">
            <div class="currentTableRow">
                <div class="currentTableCountry">&nbsp;</div>
                <div class="currentTableValue">P</div>
                <div class="currentTableValue">W</div>
                <div class="currentTableValue">D</div>
                <div class="currentTableValue">L</div>
                <div class="currentTableValue">F</div>
                <div class="currentTableValue">A</div>
                <div class="currentTableValue">Pts</div>
            </div>
            @foreach ($match->getMatchRoundTable() as $row)
                <div class="currentTableRow">
                    <div class="currentTableCountry">{{ $row[0] }}</div>
                    <div class="currentTableValue">{{ $row[1] }}</div>
                    <div class="currentTableValue">{{ $row[2] }}</div>
                    <div class="currentTableValue">{{ $row[3] }}</div>
                    <div class="currentTableValue">{{ $row[4] }}</div>
                    <div class="currentTableValue">{{ $row[5] }}</div>
                    <div class="currentTableValue">{{ $row[6] }}</div>
                    <div class="currentTableValue">{{ $row[7] }}</div>
                </div>
            @endforeach
        </div>
        <div class="currentGroupFixtures">
            @foreach ($match->getMatchRoundResults() as $result)
                @if ($result["date"] != "")
                    <div class="tableFixturesDate">{{ $result["date"] }}</div>
                @endif
                <div class="tableFixture">{{ $result["result"] }}</div>
            @endforeach
        </div>
    </div>
@endif