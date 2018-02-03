<div class="inputRow lineup">
    <div class="input shirtno">
        <input class="shirtIp" type="text" value="0" name="shirt_no[]" data-required="true" />
    </div>
    <div class="input shirtcb">
        <input class="shirtCb" type="checkbox" value="1" data-required="true" />
        <input type="hidden" value="0" name="shirt_no_show[]" data-required="true" />
    </div>
    <div class="input player">
        <select name="player_id[]" class="playerSelect">
            <option value="">Please Select</option>
            @foreach ($players as $player)
                <option value="{{ $player->id }}">{{ $player->surname }}, {{ $player->firstname }} ({{ $player->debut_year }})</option>
            @endforeach
        </select>
    </div>
    <div class="input club">
        <select name="club_id[]" class="clubSelect">
            <option value="">Please Select</option>
            @foreach ($clubs as $club)
                <option value="{{ $club->id }}">{{ $club->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="input goals">
        <input class="goalsIp" type="text" value="0" name="replaced[]" data-required="true" />
    </div>
    <div class="input goals">
        <input class="goalsIp" type="text" value="0" name="minute[]" data-required="true" />
    </div>
    <div class="input goals">
        <input class="goalsIp" type="text" value="0" name="goals[]" data-required="true" />
    </div>
    <div class="input goals">
        <input class="goalsIp" type="text" value="0" name="penalties[]" data-required="true" />
    </div>
    <div class="input cards">
        <select name="cards[]" class="cardsSelect">
            <option value="">None</option>
            <option value="Y">Yellow</option>
            <option value="R">Red</option>
            <option value="RY">Double Booking</option>
            <option value="YR">Yellow &amp; Red</option>
        </select>
    </div>
    <div class="input"><a class="removesub"><img src="/cms/images/remove.gif" /></a></div>
    <input type="hidden" value="0" name="captain[]" data-required="true" />
    <input type="hidden" value="0" name="id[]" data-required="true" />
</div>
