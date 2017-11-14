<div id="lineup">
    <div class="lineupDetails">
        <table id="lineupDetailsTable">
            @foreach ($match->appearances()->starts()->get() as $start)
                <tr>
                    <td class="shirtNo">{{ ($start->shirt_no_show == '1')? $start->shirt_no : '' }}</td>
                    <td class="playerName">{{ $start->player->full_name }} <span class="lineupClub">({{ $start->club->name }})</span>@if ($start->captain == 1)<span class="captain"> Captain</span>@endif</td>
                    <td>@if ($start->cards != "")<img src="/img/{{ $start->cards }}Card.gif" />@endif</td>
                    <td style="max-width:60px;" align="center">@for ($i = 0; $i < $start->goals; $i++)<img src="/img/football.png" width="15px" height="15px" />@endfor</td>
                    <td class="capCount">({{ $start->caps }})</td>
                    <td class="age">Age: {{ $start->age }}</td>
                </tr>
            @endforeach
            <tr><td colspan="6">&nbsp;</td></tr>
            @foreach ($match->appearances()->substitutes()->get() as $sub)
                <tr>
                    <td class="shirtNo">{{ ($sub->shirt_no_show == '1')? $sub->shirt_no : '' }}</td>
                    <td class="playerName">{{ $sub->player->full_name }} <span class="lineupClub">({{ $sub->club->name }})</span></td>
                    <td>@if ($sub->cards != "")<img src="/img/{{ $sub->cards }}Card.gif" />@endif</td>
                    <td style="max-width:60px;" align="center">@for ($i = 0; $i < $sub->goals; $i++)<img src="/img/football.png" width="15px" height="15px" />@endfor</td>
                    <td class="capCount">({{ $sub->caps }})</td>
                    <td class="age">Age: {{ $sub->age }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="5" class="substituted">(Replaced {{ $sub->replaced_player }} {{ $sub->minute }} min)</td>
                <tr>
            @endforeach
            <tr>
                <td colspan="6" class="key"><img src="/img/YCard.gif" />&nbsp;Yellow Card&nbsp;&nbsp;<img src="/img/RCard.gif" />&nbsp;Red Card&nbsp;&nbsp;<img src="/img/RYCard.gif" />&nbsp;Double Booking&nbsp;&nbsp;<img src="/img/football.png" width="15px" height="15px" />&nbsp;Goals Scored</td>
            </tr>
        </table>
    </div>

    <div class="formation">
        @if ($match->formation != "")
            <span class="formationLabel">({{ $match->formation_string }})</span>
            @foreach ($match->formation_shirts as $row)
                <div class="formationRow{{ sizeof($row) }}" style="height:{{ $row[0][3] }}px">
                    @foreach ($row as $player)
                        <div class="formationShirtHolder"><img src="/img/formation/{{ $player[2] }}{{ $player[0] }}.gif" alt="{{ $player[1] }}" title="{{ $player[1] }}" /></div>
                    @endforeach
                </div>
            @endforeach
        @else
            <span class="noFormation">Formation Is Unknown</span>
        @endif
    </div>

    @if ($match->appearances()->count() && $lineupImage = $match->lineup_image)
        <div class="lineupPicture">{!! $lineupImage[0] !!}<p><span class="shirtNo">{{ $lineupImage[1] }}</span> {{ $lineupImage[2] }}</p></div>
    @else
        <div class="lineupPicture"><p class="noPicture">There are no player pictures for this game.</p></div>
    @endif

    @if ($match->fact)
        <div class="interestingFact">
            <div class="factHeading">Interesting Fact</div>
            <div class="factText">{!! $match->fact->text !!}</div>
        </div>
    @endif
</div>