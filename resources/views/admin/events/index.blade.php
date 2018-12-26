@extends('admin.app')

@section('content')
    <h1 class="fullTitleBar">Past Events <a href="/admin/events" class="add">Add Event</a><div class="breadcrumb"><a href="/logout">Logout</a></div></h1>
    <div class="cmsContent cmsCompetitions">
        <table class="datatableCompetitions">
            <thead>
            <tr>
                <th>Date</th>
                <th>Summary</th>
                <th class="noSort"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($eventList as $event)
                <tr>
                    <td>{{ $event->date->format('Y-m-d') }}</td>
                    <td>{{ substr($event->summary, 0, 50) }}...</td>
                    <td><a href="/admin/events/{{ $event->id }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="addContent addContentHalf">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/event/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="itemid" id="itemid" value="{{ $id }}">
            <div>
                <div class="inputRow">
                    <div class="inputHead">Date: </div>
                    <div class="input">
                        <input type="text" class="datepicker" id="date" value="{{ old('date') ?? (isset($selectedEvent->date) ? date('Y-m-d', strtotime($selectedEvent->date)) : '') }}" name="date" />
                        <span class="errorMsg">{{ $errors->first('date') }}</span>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputHead">Summary: </div>
                    <div class="input inputClear">
                        <textarea id="summary" name="summary">{{ old('summary') ?? $selectedEvent->summary ?? '' }}</textarea>
                        <span class="errorMsg">{{ $errors->first('summary') }}</span>
                    </div>
                </div>
                <div class="submitRow"><button class="addLink">Save</button> <a class="addLink" href="/admin/events">Cancel</a></div>
            </div>
        </form>
    </div>

@endsection