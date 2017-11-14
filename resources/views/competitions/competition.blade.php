@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ $competition->name }}<div class="breadcrumb"><a href="/">Home</a> > <a href="/competitions/">Competitions</a> > <a href="/competitions/{{ $competitionType->url }}/">{{ $competitionType->title }}</a> > <span>{{ $competition->name }}</span></div></h1>
    <div class="competitionScroller fullTitleBar">
        <ul>
            @foreach ($table->getComments() as $comment)<li>{!! $comment !!}</li>@endforeach
        </ul>
    </div>
    
    <div class="competitionVersionLeft">
        <div class="competitionTable">
            <span class="flagTitleLink"><span class="flagTitle"></span>{{ $table->group_name }} Table</span>
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
                    <div class="team"><span class="flagHolder"><img src="/img/flags/{{ $row->getFlag() }}.gif" class="tableFlag" /></span><span>{{ $row->getTeam() }}</span></div>
                    <div class="data">{{ $row->played }}</div>
                    <div class="data">{{ $row->won }}</div>
                    <div class="data">{{ $row->drew }}</div>
                    <div class="data">{{ $row->lost }}</div>
                    <div class="data">{{ $row->for }}</div>
                    <div class="data">{{ $row->against }}</div>
                    <div class="data">{{ $row->points }}</div>
                    <div class="data">{{ $row->getGoalDifference() }}</div>
                </div>
                @if ($row->getTableLine() != "")
                <div class="tableRow {{ $row->getTableLine() }}"></div>
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
            <span class="flagTitleLink"><span class="flagTitle"></span>{{ $table->group_name }} {{ $table->getMatchStatus() }}</span>
            <div class="groupResultsData">
                <div class="groupResultsColumn">
                    @foreach ($tableResults1 as $game)
                    @if ($game->getDateRow() != "")<span class="groupResultsDate">{{ $game->getDateRow() }}</span>@endif
                    <span class="groupResultsMatch">{{ $game->getShortResultString() }}</span>
                    @endforeach
                </div>
                <div class="groupResultsColumn">
                    @foreach ($tableResults2 as $game)
                    @if ($game->getDateRow() != "")<span class="groupResultsDate">{{ $game->getDateRow() }}</span>@endif
                    <span class="groupResultsMatch">{{ $game->getShortResultString() }}</span>
                    @endforeach
                </div>
                <div class="groupResultsColumn">
                    @foreach ($tableResults3 as $game)
                    @if ($game->getDateRow() != "")<span class="groupResultsDate">{{ $game->getDateRow() }}</span>@endif
                    <span class="groupResultsMatch">{{ $game->getShortResultString() }}</span>
                    @endforeach
                </div>
            </div>                    
        </div>
    </div>
    <div class="competitionVersionRight">
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
                @foreach ($games as $game)
                <div class="matchRow">
                    <div class="matchDate">{{ $game->match_date->format('d/m/Y') }}</div>
                    <div class="matchOpponent">{{ $game->opponent->name }}</div>
                    <div class="matchHA">{{ $game->getHomeAway() }}</div>
                    @if ($game->result != "")
                    <div class="matchResult">{{ $game->result }}</div>
                    <div class="matchAtt">{{ $game->getAttendance() }}</div>
                    <div class="matchLink"><a href="/match-details/{{ $game->getUrl() }}">Details</a></div>
                    @endif
                </div>
                @endforeach
                @if ($playoffs->count() > 0)
                <span class="scotlandMatchesBanner">Play-Offs</span>
                <div class="matchRow">
                    <div class="matchDate">Date</div>
                    <div class="matchOpponent">Opponent</div>
                    <div class="matchHA">H/A</div>
                    <div class="matchResult">Result</div>
                    <div class="matchAtt">Att.</div>
                    <div class="matchLink"> </div>
                </div> 
                @foreach ($playoffs->get() as $game)
                <div class="matchRow">
                    <div class="matchDate">{{ $game->match_date->format('d/m/Y') }}</div>
                    <div class="matchOpponent">{{ $game->opponent->name }}</div>
                    <div class="matchHA">{{ $game->getHomeAway() }}</div>
                    @if ($game->result != "")
                    <div class="matchResult">{{ $game->result }}</div>
                    <div class="matchAtt">{{ $game->getAttendance() }}</div>
                    <div class="matchLink"><a href="/match-details/{{ $game->getUrl() }}">Details</a></div>
                    @endif
                </div>
                @endforeach
                @endif                                              
            </div>
        </div>
        @if ($video['count'] == "1")
        <div class="pictureRow">
        @include('minivideo')
        </div>
        @endif
    </div>
@endsection