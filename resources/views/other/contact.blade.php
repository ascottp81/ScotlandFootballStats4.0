@extends('app')

@section('head')
@endsection

@section('content')
    <h1 class="fullTitleBar">Contact Us</h1>
    <div class="introText">
        If you wish to contact me for any reason regarding ScotlandFootballStats, please fill in the form below, supplying me with your e-mail address, a subject title and your message.<br />
        Some stats on this website may be incomplete. If you feel that any of the stats in this website are incorrect, or you know any incomplete ones, please let me know along with where you know this from (i.e. a video clip, a respectable website).<br />
        If you have a similar website you may also get in touch so that I can add your site to my External Links page, and likewise you can add a link to ScotlandFootballStats to your site.
    </div>
    <div class="contactContent">
        <div class="contactRow" id="contactSuccess">
            <div class="contactHeading">&nbsp;</div>
            <div class="contactInput contactSuccess"></div>
        </div>
        <div class="contactRow">
            <div class="contactHeading">Your E-mail Address: </div>
            <div class="contactInput"><input type="text" id="email" name="email" /><span id="emailError"></span></div>
        </div>
        <div class="contactRow">
            <div class="contactHeading">Subject: </div>
            <div class="contactInput"><input type="text" id="subject" name="subject" /><span id="subjectError"></span></div>
        </div>
        <div class="contactRow">
            <div class="contactHeading">Message: </div>
            <div class="contactInput">
                <textarea id="message" name="message"></textarea>
                <span id="messageError"></span>
                <div class="contactButtons">
                    <a id="send">Send</a><a id="clear">Clear</a>
                </div>
            </div>
            {{ csrf_field() }}
        </div>
        <p>If you do not want to use the form above, you can send an email to <a href="mailto:scott@scotlandfootballstats.co.uk">scott@scotlandfootballstats.co.uk</a>.</p>
    </div>
@endsection