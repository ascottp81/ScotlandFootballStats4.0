@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ $competition->name }}<div class="breadcrumb"><a href="/">Home</a> > <a href="/competitions/">Competitions</a> > <span>{{ $competition->name }}</span></div></h1>

    <div class="competitionVersionLeft">
        <div class="competitionSingleSummaryColumn">
            <div class="competitionSummary">
                {{ $competitionType->summary }}
                @if (sizeof($table->comments) > 0)
                <ul>
                    @foreach ($table->comments as $comment)<li>{!! $comment !!}</li>@endforeach
                </ul>
                @endif
            </div>
        </div>

        <div class="competitionResults">
            <span class="flagTitleLink"><span class="flagTitle"></span>Scotland Matches</span>
            <div class="competitionResultsData">
                @if ($competition->stage != "")<span class="scotlandMatchesBanner">{{ $table->group_name }}</span>@endif
                <div class="matchRow">
                    <div class="matchDate">Date</div>
                    <div class="matchOpponent">Opponent</div>
                    <div class="matchHA">H/A</div>
                    <div class="matchResult">Result</div>
                    <div class="matchAtt">Att.</div>
                    <div class="matchLink"> </div>
                </div>
                @foreach ($matches as $match)
                <div class="matchRow">
                    <div class="matchDate">{{ $match->date->format('d/m/Y') }}</div>
                    <div class="matchOpponent">{{ $match->opponent->name }}</div>
                    <div class="matchHA">{{ $match->home_away }}</div>
                    @if ($match->result != "")
                    <div class="matchResult">{{ $match->result }}</div>
                    <div class="matchAtt">{{ $match->attendance }}</div>
                    <div class="matchLink"><a href="/match-details/{{ $match->url }}">Details</a></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="competitionVersionRight">
        <div class="competitionTable">
            <span class="flagTitleLink"><span class="flagTitle"></span>{{ $table->competitionRound()->first()->name }} - {{ $table->group_name }} Table</span>
            <div class="competitionTableData">
                <div class="tableRow">
                    <div class="team">&nbsp;</div>
                    <div class="data">P</div>
                    <div class="data">W</div>
                    <div class="data">D</div>
                    <div class="data">L</div>
                    <div class="data">F</div>
                    <div class="data">A</div>
                    <div class="data">Pts</div>
                    <div class="data">GD</div>
                </div>
                @foreach ($table->teams()->get() as $row)
                    <div class="tableRow">
                        <div class="team"><span class="flagHolder"><img src="/img/flags/{{ $row->flag }}.gif" class="tableFlag" /></span><span>{{ $row->team }}</span></div>
                        <div class="data">{{ $row->played }}</div>
                        <div class="data">{{ $row->won }}</div>
                        <div class="data">{{ $row->drew }}</div>
                        <div class="data">{{ $row->lost }}</div>
                        <div class="data">{{ $row->for }}</div>
                        <div class="data">{{ $row->against }}</div>
                        <div class="data">{{ $row->points }}</div>
                        <div class="data">{{ $row->goal_difference }}</div>
                    </div>
                    @if ($row->table_line != "")
                        <div class="tableRow {{ $row->table_line }}"></div>
                    @endif
                @endforeach
                @if ($table->head_to_head == 1)
                    <div class="tableFooterNote">When level on points, position is determined by the results between all of the level teams.</div>
                @elseif ($table->head_to_head == 2)
                    <div class="tableFooterNote">When level on points, position is determined by total goal difference then goals scored.  Following this the results between all of the level teams are taken into account.  If only two teams are level, away goals between them are then taken into account.</div>
                @endif
            </div>
        </div>
        <div class="groupResults">
            <span class="flagTitleLink"><span class="flagTitle"></span>{{ $table->competitionRound()->first()->name }} - {{ $table->group_name }} {{ $table->fixture_result_text }}</span>
            <div class="groupResultsData">
                <div class="groupResultsColumn">
                    @foreach ($tableResults1 as $game)
                        @if ($game->date_row != "")<span class="groupResultsDate">{{ $game->date_row }}</span>@endif
                        <span class="groupResultsMatch">{{ $game->short_result}}</span>
                    @endforeach
                </div>
                <div class="groupResultsColumn">
                    @foreach ($tableResults2 as $game)
                        @if ($game->date_row != "")<span class="groupResultsDate">{{ $game->date_row }}</span>@endif
                        <span class="groupResultsMatch">{{ $game->short_result }}</span>
                    @endforeach
                </div>
                <div class="groupResultsColumn">
                    @foreach ($tableResults3 as $game)
                        @if ($game->date_row != "")<span class="groupResultsDate">{{ $game->date_row }}</span>@endif
                        <span class="groupResultsMatch">{{ $game->short_result }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection