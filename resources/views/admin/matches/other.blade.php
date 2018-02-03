@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Edit Match&nbsp;&nbsp;&nbsp;<span class="subTitle">Other</span><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/match/other/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $match->id }}">
            <div>
                <div class="leftInputs">
                    <div class="inputRow">
                        <div class="inputHead">Formation: </div>
                        <div class="input">
                            <input type="text" id="formation" value="{{ $match->formation_string }}" name="formation" onkeyup="changeFormation()" />
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead"></div>
                        <div class="input formationip">
                            <input type="text" class="row1 size1" id="formation_shirt1" value="{{ $match->formation_shirt_numbers[0] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[0] }}" id="formation_shirt2" value="{{ $match->formation_shirt_numbers[1] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[1] }}" id="formation_shirt3" value="{{ $match->formation_shirt_numbers[2] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[2] }}" id="formation_shirt4" value="{{ $match->formation_shirt_numbers[3] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[3] }}" id="formation_shirt5" value="{{ $match->formation_shirt_numbers[4] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[4] }}" id="formation_shirt6" value="{{ $match->formation_shirt_numbers[5] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[5] }}" id="formation_shirt7" value="{{ $match->formation_shirt_numbers[6] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[6] }}" id="formation_shirt8" value="{{ $match->formation_shirt_numbers[7] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[7] }}" id="formation_shirt9" value="{{ $match->formation_shirt_numbers[8] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[8] }}" id="formation_shirt10" value="{{ $match->formation_shirt_numbers[9] }}" name="formation_shirt[]" />
                            <input type="text" class="{{ $match->formation_input_classes[9] }}" id="formation_shirt11" value="{{ $match->formation_shirt_numbers[10] }}" name="formation_shirt[]" />
                        </div>
                    </div>
                </div>
                <div class="leftInputs">
                    <div class="inputRow">
                        <div class="inputHead">Fact: </div>
                        <div class="input">
                            <textarea id="fact" name="fact">{{ ($match->fact()->first()) ? $match->fact()->first()->text : '' }}</textarea>
                        </div>
                    </div>
                    <div class="inputRow">
                        <div class="inputHead">Getty Image: </div>
                        <div class="input">
                            <textarea id="image" name="image" style="height:180px">{{ $match->getty_image }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/match/{{ $match->id }}">Cancel</a></div>
            </div>
        </form>
    </div>
@endsection