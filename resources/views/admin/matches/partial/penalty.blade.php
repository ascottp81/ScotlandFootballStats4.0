<div class="inputRow lineup">
    <div class="input penaltyno">
        <input type="text" name="penalty_no[]" data-required="true" />
    </div>
    <div class="input club">
        <select name="team_id[]">
            <option value="0">Scotland</option>
            <option value="{{ $match->opponent->id }}">{{ $match->opponent->name }}</option>
        </select>
    </div>
    <div class="input player">
        <input type="text" name="player[]" data-required="true" />
    </div>
    <div class="input cards">
        <select name="result[]">
            <option value="scored">Scored</option>
            <option value="missed">Missed</option>
        </select>
    </div>
    <div class="input"><a class="removePenalty"><img src="/img/remove.gif" /></a></div>
    <input type="hidden" value="0" name="id[]" data-required="true" />
</div>