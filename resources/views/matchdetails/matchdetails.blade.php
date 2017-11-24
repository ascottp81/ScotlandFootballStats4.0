<div id="basic">
    <div class="mdBasicLeft">
        @include('matchdetails.partial.basicmatchdetails')
        @if ($video->count() && $match->stats->count())
            <div class="mdVideoHolder">
                @include('partial.minivideo')
            </div>
        @endif
    </div>
    <div class="mdBasicRight">
        <div class="mdBasicLineups">
            <div class="basicLineupsTeam lineup{{ $match->ha }}">
                <div class="basicLineupsTitle"><span class="basicLineupsFlag" style="background-image: url('/img/flags/scotland.gif');"></span>Scotland</div>
                @if ($match->scot_scorers || sizeof($match->scot_pen_miss) > 0 || sizeof($match->scot_red_card) > 0)
                    <div class="basicLineupsSector">
                        <div>
                        @foreach ($match->scot_scorers as $scorer)
                            <p class="basicScorer"><i class="fa fa-futbol-o"></i> {{ $scorer }}</p>
                        @endforeach
                        </div>
                        <div class="penMiss">
                        @foreach ($match->scot_pen_miss as $pen)
                            <p class="basicScorer"><span class="fa-stack"><i class="fa fa-futbol-o fa-stack-1x"></i><i class="fa fa-close fa-stack-1x" style="color: #ff0000;"></i></span> {{ $pen }}</p>
                        @endforeach
                        </div>
                        <div class="redCard">
                        @foreach ($match->scot_red_card as $card)
                            <p class="basicScorer"><i class="redcard-icon"></i> {{ $card }}</p>
                        @endforeach
                        </div>
                    </div>
                @endif
                <div class="basicLineupsSector topPadding">
                    @if ($match->strips && $match->strips->strip)
                        <div class="basicStripHolder"><img src="/img/strips/shirts/{{ $match->strips->strip->name }}.gif" /><br />@if($match->strips->scotland_shorts)<img src="/img/strips/shorts/{{ $match->strips->scotland_shorts }}.gif" width="76px" height="30px" />@endif</div>
                    @endif
                    <p>{!! $match->scot_team !!}</p>
                    <p>&nbsp;</p>
                    <p>Manager:<br />{{ $match->manager }}</p>
                    @if ($match->scot_ranking != "")
                        <p>&nbsp;</p>
                        <p>FIFA Ranking: {{ $match->scot_ranking }}</p>
                    @endif
                </div>
            </div>
            <div class="basicLineupsTeam lineup{{ $match->ha }}">
                <div class="basicLineupsTitle"><span class="basicLineupsFlag" style="background-image: url('/img/flags/{{ $match->opponent->name }}.gif');"></span>{{ $match->opponent->name }}</div>
                @if ($match->opp_scorers || sizeof($match->opp_pen_miss) > 0 || sizeof($match->opp_red_card) > 0)
                    <div class="basicLineupsSector">
                        <div>
                        @foreach ($match->opp_scorers as $scorer)
                            <p class="basicScorer"><i class="fa fa-futbol-o"></i> {{ $scorer }}</p>
                        @endforeach
                        </div>
                        <div class="penMiss">
                        @foreach ($match->opp_pen_miss as $pen)
                            <p class="basicScorer"><span class="fa-stack"><i class="fa fa-futbol-o fa-stack-1x"></i><i class="fa fa-close fa-stack-1x" style="color: #ff0000;"></i></span> {{ $pen }}</p>
                        @endforeach
                        </div>
                        <div class="redCard">
                        @foreach ($match->opp_red_card as $card)
                            <p class="basicScorer"><i class="redcard-icon"></i> {{ $card }}</p>
                        @endforeach
                        </div>
                    </div>
                @endif
                <div class="basicLineupsSector topPadding">
                    @if ($match->strips && $match->strips->opponent_shirt)
                        <div class="basicStripHolder"><img src="/img/strips/shirts/{{ $match->strips->opponent_shirt }}.gif" /><br />@if($match->strips->opponent_shorts)<img src="/img/strips/shorts/{{ $match->strips->opponent_shorts }}.gif" width="76px" height="30px" />@endif</div>
                    @endif
                    <p>{!! $match->opp_team !!}</p>
                    @if ($match->opp_ranking)
                        <p>&nbsp;</p>
                        <p>FIFA Ranking: {{ $match->opp_ranking }}</p>
                    @endif
                </div>
            </div>
            <div class="basicVerticalDivider"></div>
        </div>
        @if ($match->penalties->count())
        <div class="mdPenaltyShootout">
            <div class="basicLineupsTitle">Penalty Shoot-out <span class="scorelineComment">({{ $match->penalties()->first()->first_team }} First)</span></div>
            <div class="basicLineupsTeam lineup{{ $match->ha }}">
                <div class="basicLineupsSector">
                    <div>
                        @if ($match->penalties()->first()->opponent_first)
                            <p class="basicScorer">&nbsp;</p>
                        @endif
                        @foreach ($match->penalties()->scotland()->get() as $penalty)
                            @if ($penalty->result == "scored")
                                <p class="basicScorer"><i class="fa fa-futbol-o"></i> {{ $penalty->player }} <span class="penaltyScoreline">{{ $penalty->scoreline }}</span></p>
                            @else
                                <p class="basicScorer"><span class="fa-stack"><i class="fa fa-futbol-o fa-stack-1x"></i><i class="fa fa-close fa-stack-1x" style="color: #ff0000;"></i></span> {{ $penalty->player }} <span class="penaltyScoreline">{{ $penalty->scoreline }}</span></p>
                            @endif
                                <p class="basicScorer">&nbsp;</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="basicLineupsTeam lineup{{ $match->ha }}">
                <div class="basicLineupsSector">
                    <div>
                        @if ($match->penalties()->first()->scotland_first)
                        <p class="basicScorer">&nbsp;</p>
                        @endif
                        @foreach ($match->penalties()->opponent()->get() as $penalty)
                            @if ($penalty->result == "scored")
                                <p class="basicScorer"><i class="fa fa-futbol-o"></i> {{ $penalty->player }} <span class="penaltyScoreline">{{ $penalty->scoreline }}</span></p>
                            @else
                                <p class="basicScorer"><span class="fa-stack"><i class="fa fa-futbol-o fa-stack-1x"></i><i class="fa fa-close fa-stack-1x" style="color: #ff0000;"></i></span> {{ $penalty->player }} <span class="penaltyScoreline">{{ $penalty->scoreline }}</span></p>
                            @endif
                                <p class="basicScorer">&nbsp;</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="basicVerticalDivider"></div>
        </div>
        @endif
        <div class="basicKey">
            <p class="basicScorer">
                <span>Key: </span>
                <span class="basicKeyItem"><i class="fa fa-futbol-o"></i> Goals</span>
                <span class="basicKeyItem"><em class="fa-stack"><i class="fa fa-futbol-o fa-stack-1x"></i><i class="fa fa-close fa-stack-1x" style="color: #ff0000;"></i></em> Missed Penalty</span>
                <span class="basicKeyItem"><i class="redcard-icon"></i> Red Card</span>
            </p>
        </div>

        @if ($match->stats->count())
            <div class="extraStats">
                <div class="extraStatsRow"><div class="extraStatsTitle">&nbsp;</div><div class="extraStatsTeamLeft">{{ $match->home_team }}</div><div class="extraStatsTeamRight">{{ $match->away_team }}</div></div>
                @foreach ($match->getStats() as $row)
                    @if (sizeof($row) > 0)
                    <div class="extraStatsRow">
                        <div class="extraStatsTitle">{{ $row[0] }}</div>
                        <div class="extraStatsBar">
                            <div class="extraStatsLeft {{ $row[5] }}Back" style="width:{{ $row[3] }}px;">{{ $row[1] }}</div>
                            <div class="extraStatsRight {{ $row[6] }}Back" style="width:{{ $row[4] }}px;">{{ $row[2] }}</div>
                        </div>
                    </div>
                    @endif
                @endforeach
                <div class="extraStatsRow"><div class="extraStatsFooter">Source: {{ $match->stats->first()->source }}</div></div>
            </div>
            <div class="extraStatsImage">
                {!! $match->image !!}
            </div>
        @endif
    </div>
</div>