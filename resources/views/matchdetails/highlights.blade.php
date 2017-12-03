@if ($match->videos->count())
<div id="highlights">
    <div class="mdBasicLeft">
        @include('matchdetails.partial.basicmatchdetails')
    </div>
    <div class="videoHolder">
        @include('partial.matchvideo')
    </div>
</div>
@endif