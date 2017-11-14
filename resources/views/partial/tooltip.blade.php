<style type="text/css">
    .tooltip {
        background-color: #000066;
    }
    .tooltipRow {
        float: left;
        clear: left;
        padding-bottom: 3px;
    }
    .tooltipIcon {
        width: 30px;
        text-align: center;
        height: 23px;
        float: left;
    }
    .sub {
        height: 23px;
        padding-top: 3px;
    }
    .goal {
        padding-top: 3px;
    }
    .tooltipIconValue {
        width: 30px;
        text-align: center;
        margin-left: -30px;
        font: normal normal bold 16px Arial;
        color: #000066;
        height: 23px;
        float: left;
        padding-top: 2px;
    }
    .tooltipKey {
        width: 105px;
        font: normal normal bold 12px Arial;
        color: #FFFFFF;
        height: 19px;
        float: left;
        padding-top: 4px;
        padding-left: 10px;
    }


    .tooltipHeading {
        float: left;
        width: 100px;
        font: italic normal bold 14px Arial;
        color: #FFFF00;
        letter-spacing: -1px;
    }
    .tooltipValue {
        width: 30px;
        text-align: center;
        font: normal normal bold 13px Arial;
        color: #FFFFFF;
        letter-spacing: -1px;
        height: 21px;
        float: left;
        padding-top: 2px;
    }

    .tooltipNote {
        background-color: #000066;
        padding: 6px;
        margin: 0px;
        width: 168px;
        font: normal normal bold 11px Arial;
        color: #FFFFFF;
        float: left;
        clear: left;
    }


</style>



@if ($type == 'player-matches')
    <div class="tooltip">
        @if ($player->goals > 0)
            <div class="tooltipRow">
                <div class="tooltipIcon"><img src="/img/goals.gif" width="25px" /></div>
                <div class="tooltipIconValue goal">{{ $player->goals }}</div>
                <div class="tooltipKey">Goals</div>
            </div>
        @endif
        @if ($player->penalties > 0)
            <div class="tooltipRow">
                <div class="tooltipIcon"><img src="/img/goals2.gif" width="25px" /></div>
                <div class="tooltipIconValue goal">{{ $player->penalties }}</div>
                <div class="tooltipKey">Penalties</div>
            </div>
        @endif
        @if ($player->cards == 'R' || $player->cards == 'RY' || $player->cards == 'YR')
            <div class="tooltipRow">
                <div class="tooltipIcon"><img src="/img/RCard.gif" width="15px" /></div>
                <div class="tooltipIconValue">1</div>
                <div class="tooltipKey">Red Card</div>
            </div>
        @endif
        @if ($player->cards == 'Y' || $player->cards == 'YR')
            <div class="tooltipRow">
                <div class="tooltipIcon"><img src="/img/YCard.gif" width="15px" /></div>
                <div class="tooltipIconValue">1</div>
                <div class="tooltipKey">Yellow Card</div>
            </div>
        @elseif ($player->cards == 'RY')
            <div class="tooltipRow">
                <div class="tooltipIcon"><img src="/img/YCard.gif" width="15px" /></div>
                <div class="tooltipIconValue">2</div>
                <div class="tooltipKey">Yellow Card</div>
            </div>
        @endif
        @if ($player->replaced > 0)
            <div class="tooltipRow">
                <div class="tooltipIcon sub"><img src="/img/onarrow.gif" width="25px" /></div>
                <div class="tooltipKey">On as Substitute</div>
            </div>
        @endif
        @if ($substitutions == 1)
            <div class="tooltipRow">
                <div class="tooltipIcon sub"><img src="/img/offarrow.gif" width="25px" /></div>
                <div class="tooltipKey">Substituted</div>
            </div>
        @endif
        @if ($player->captain == 1)
            <div class="tooltipRow">
                <div class="tooltipIcon"><img src="/img/captain.png" width="25px" /></div>
                <div class="tooltipKey">Captain</div>
            </div>
        @endif
    </div>
@endif

@if ($type == 'appearances')
    <div class="tooltip">
        <div class="tooltipRow">
            <div class="tooltipHeading">Starts: </div>
            <div class="tooltipValue">{{ $player->starts }}</div>
        </div>
        <div class="tooltip_row">
            <div class="tooltipHeading">As Substitute: </div>
            <div class="tooltipValue">{{ $player->sub_appearances}}</div>
        </div>
        <div class="tooltip_row">
            <div class="tooltipHeading">As Captain: </div>
            <div class="tooltipValue">{{ $player->captain_count }}</div>
        </div>
    </div>
@endif

@if ($type == 'goals')
    <div class="tooltip">
        <div class="tooltipRow">
            <div class="tooltipHeading">Penalties: </div>
            <div class="tooltipValue">{{ $player->pens }}</div>
        </div>
    </div>
@endif

@if ($type == 'clean-sheets')
    <div class="tooltipText">A match is only counted as a clean sheet if the goalkeeper does not concede a goal for the entire match.  If a substitution is made, the match will not be counted as a clean sheet.</div>
@endif

@if ($type == 'strip')
    <div class="tooltip">
        <div class="tooltipNote">{{ $note }}</div>
    </div>
@endif
