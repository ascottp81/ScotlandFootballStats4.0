            <li id="0" class="inputRow lineup">
                <div class="input player">
                    <select name="team_id[]" class="playerSelect">
                        <option value="">Please Select</option>
                        <option value="0">SCOTLAND</option>
                        @foreach ($opponents as $opponent)
                        <option value="{{ $opponent->id }}">{{ $opponent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="0" name="played[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="0" name="won[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="0" name="drew[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="0" name="lost[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="0" name="for[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="0" name="against[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="0" name="points[]" data-required="true" />
                </div>
                <div class="input shirtcb">
                    <input class="topCb" type="checkbox" value="1" />
                    <input type="hidden" value="0" name="top_place[]" data-required="true" />
                </div>
                <div class="input shirtcb">
                    <input class="poCb" type="checkbox" value="1" />
                    <input type="hidden" value="0" name="playoff[]" data-required="true" />
                </div>
                <div class="input"><a class="removeRow"><img src="/img/cms/remove.gif" /></a></div>
                <input type="hidden" value="0" name="id[]" data-required="true" />
            </li>
