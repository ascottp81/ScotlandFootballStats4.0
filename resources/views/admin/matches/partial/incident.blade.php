<div class="inputRow lineup">
    <div class="input shirtno">
        <input class="shirtIp" type="text" name="minute[]" data-required="true" />
    </div>
    <div class="input club">
        <select name="team_id[]" class="clubSelect">
            <option value="0">Scotland</option>
            <option value="{{ $match->opponent->id }}">{{ $match->opponent->name }}</option>
        </select>
    </div>
    <div class="input player">
        <input type="text" name="player[]" data-required="true" />
    </div>
    <div class="input club">
        <select name="incident_type_id[]" class="clubSelect">
            <option value="">Please Select</option>
            @foreach ($incidentTypes as $type)
                <option value="{{ $type->id }}">{{ $type->text }}</option>
            @endforeach
        </select>
    </div>
    <div class="input player">
        <img class="incidentImg" />
        <input type="file" name="image[]" />
    </div>
    <div class="input"><a class="removeIncident"><img src="/cms/images/remove.gif" /></a></div>
    <input type="hidden" value="0" name="id[]" data-required="true" />
</div>