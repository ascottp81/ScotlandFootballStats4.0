@extends('admin.app')

@section('head')
<script type="text/javascript">
$(document).ready(function(){
	$(".topCb, .poCb").click(function(){
		if ($(this).is(":checked")) {
			$(this).next().val("1");	
		}
		else {
			$(this).next().val("0");
		}
	});
	
	$("#sortable").sortable();
	$('#sortable').bind('sortupdate', function(event, ui) {
		var result = $('#sortable').sortable('toArray'); 
		orderTable(result);
	});	
});
</script>
@endsection

@section('content')
    <h1 class="fullTitleBar">{{ $competition->name }} Table <div class="breadcrumb"><a href="/logout">Logout</a></div><div class="breadcrumb"><a href="/admin/competitions">Competitions</a> > <a href="/admin/competitions/{{ $competition->type->url }}">{{ $competition->type->title }}</a> > <span>{{ $competition->name }}</span></div></h1>
    <div class="addContent">
    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/competition-table') }}">
		{{ csrf_field() }}

        <input type="hidden" id="competition_table_id" value="{{ $table->id ?? '' }}" name="competition_table_id" data-required="true" />
        <div>
            <div class="leftInputs">
                @if ($id > 0)
                    <div class="inputRow">
                        <div class="inputHead">Competition: </div>
                        <div class="input">
                            <select id="competition_id" name="competition_id">
                                @foreach ($competitions as $version)
                                    <option value="{{ $version->id }}" @if((old('competition_id') ?? $competition->id ?? '') == $version->id)selected="selected"@endif>{{ $version->name }}</option>
                                @endforeach
                            </select>
                            <span class="errorMsg">{{ $errors->first('competition_type_id') }}</span>
                        </div>
                    </div>
                @else
                    <input type="hidden" id="competition_id" value="{{ $competition->id ?? '' }}" name="competition_id" data-required="true" />
                @endif
                <div class="inputRow">
                    <div class="inputHead">Group Name: </div>
                    <div class="input">
                        <input type="text" id="group_name" value="{{ old('group_name') ?? $table->group_name ?? '' }}" name="group_name" />
                        <span class="errorMsg">{{ $errors->first('group_name') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Round: </div>
                    <div class="input">
                        <select id="round_id" name="round_id">
                            <option value="">Please Select</option>
                            @foreach ($rounds as $round)
                                <option value="{{ $round->id }}" @if((old('round_id') ?? $table->round_id ?? '') == $round->id)selected="selected"@endif>{{ $round->name }}</option>
                            @endforeach
                        </select>
                        <span class="errorMsg">{{ $errors->first('round_id') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Home Page: </div>
                    <div class="input">
                        <input type="checkbox" id="home" name="home" value="1" @if((old('home') ?? $table->home ?? '') == 1)checked="checked"@endif />
                    </div>
                </div>
            </div>
            <div class="leftInputs">
                <div class="inputRow">
                    <div class="inputHead">Win Points: </div>
                    <div class="input">
                        <input type="text" id="win_points" value="{{ old('win_points') ?? $table->win_points ?? '3' }}" name="win_points" />
                        <span class="errorMsg">{{ $errors->first('win_points') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Head to Head: </div>
                    <div class="input">
                        <input type="checkbox" id="head_to_head" name="head_to_head" value="1" @if((old('head_to_head') ?? $table->head_to_head ?? '') == 1)checked="checked"@endif />
                    </div>
                </div>
            </div>
            <div class="inputRow"><br /><br /></div>

            <div class="inputRow table">
                <div class="input player">Team</div>
                <div class="input goals">P</div>
                <div class="input goals">W</div>
                <div class="input goals">D</div>
                <div class="input goals">L</div>
                <div class="input goals">F</div>
                <div class="input goals">A</div>
                <div class="input goals">Pts</div>
                <div class="input shirtcb">Top</div>
                <div class="input shirtcb">Play-off</div>
            </div>
			<ul id="sortable" class="ui-sortable clearFloatLeft">
        @if ($row)
        @for($i = 0; $i < $row->count(); $i++)
            <li id="{{ $row[$i]->id }}" class="inputRow lineup">
                <div class="input player">
                    <select name="team_id[]" class="playerSelect">
                        <option value="">Please Select</option>
                        <option value="0" @if($row[$i]->team_id == 0)selected="selected"@endif >SCOTLAND</option>
                        @foreach ($opponents as $opponent)
                        <option value="{{ $opponent->id }}" @if($row[$i]->team_id == $opponent->id)selected="selected"@endif >{{ $opponent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="{{ $row[$i]->played }}" name="played[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="{{ $row[$i]->won }}" name="won[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="{{ $row[$i]->drew }}" name="drew[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="{{ $row[$i]->lost }}" name="lost[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="{{ $row[$i]->for }}" name="for[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="{{ $row[$i]->against }}" name="against[]" data-required="true" />
                </div>
                <div class="input goals">
                    <input class="goalsIp" type="text" value="{{ $row[$i]->points }}" name="points[]" data-required="true" />
                </div>
                <div class="input shirtcb">
                    <input class="topCb" type="checkbox" value="1" @if($row[$i]->top_place == 1)checked="checked"@endif />
                    <input type="hidden" value="{{ $row[$i]->top_place }}" name="top_place[]" data-required="true" />
                </div>
                <div class="input shirtcb">
                    <input class="poCb" type="checkbox" value="1" @if($row[$i]->playoff == 1)checked="checked"@endif />
                    <input type="hidden" value="{{ $row[$i]->playoff }}" name="playoff[]" data-required="true" />
                </div>
                <div class="input"><a class="removeRow"><img src="/img/cms/remove.gif" /></a></div>
                <input type="hidden" value="{{ $row[$i]->id }}" name="id[]" data-required="true" />
            </li>
        @endfor
        @endif
        	</ul>   
        	<a class="addRow clearFloatLeft" href="javascript:addTableRow();"><img src="/img/cms/add.gif" /></a>
        	<p class="clearFloatLeft">Re-order the teams by dragging and dropping.<br />Note: You cannot re-order the teams after you have added a new team to the table.  You will need to save the table first.</p>
            <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/competitions/{{ $competition->type->url }}/{{ $competition->id }}">Cancel</a></div>
        </div>
        </form> 
    </div>
@endsection