@extends('admin.app')

@section('head')
    <script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="/js/tiny_mce_config.js"></script>
@endsection

@section('content')
    <h1 class="fullTitleBar">Edit Match&nbsp;&nbsp;&nbsp;<span class="subTitle">Match Summary</span><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="addContent">
        <form class="form-horizontal" autocomplete="off" role="form" method="POST" action="{{ url('/admin/match/summary/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="fullInputs">
                    <div class="inputRow">
                        <textarea class="mceEditor" id="summary" name="summary" style="width:100%;height:300px;">{{ ($summary)? $summary->content : '' }}</textarea>
                    </div>
                </div>
                <div class="submitRow"><a class="addLink" id="submit" href="javascript:submitForm();">Save</a> <a class="addLink" href="/admin/match/{{ $id }}">Cancel</a></div>
            </div>
        </form>
    </div>
@endsection