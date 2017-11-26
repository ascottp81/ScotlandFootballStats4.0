@extends('app')

@section('head')
<!-- Google Charts -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

// Load the Visualization API.
google.load('visualization', '1', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawChart);

function drawChart() {
	$("#fifaChart").html('<div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
	
	var jsonData = $.ajax({
		url: "/fifa-rankings/chart/" + $("#start").val() + "/" + $("#end").val() + "/" + $("#chart").val(),
		dataType: "json",
		async: false
	}).responseText;
	
	// Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

	var options = {
		vAxis: { direction: -1 },
		legend: { position: 'none' },
		chartArea:{ left: 50, top: 22, width: "90%", height: "75%" },
		fontSize: 10,
		hAxis: { textStyle: { fontSize: 10 } }
	};

	var chart = new google.visualization.LineChart(document.getElementById('fifaChart'));
	chart.draw(data, options);
}

function updateChart() {
	if ($("#chart").val() == 1) {
		$("#chart").val(2);
		$("#chartLink").html("View Global Chart");
	}
	else {
		$("#chart").val(1);
		$("#chartLink").html("View Zonal Chart");
	}
	drawChart();
}

// Date Slider
$(document).ready(function() {
	$( "#sliderRange" ).slider({
		range: true,
		min: 1,
		max: {{ $ranking->current->id }},
		values: [ 0, {{ $ranking->current->id }} ],
		stop: function( event, ui ) {
			changeDate(ui.values[ 0 ], ui.values[ 1 ]);
		}
	});
    getSliderDates();
});

function changeDate(start, end) {
	$("#start").val(start);
	$("#end").val(end);
	getSliderDates();
	drawChart();
}
function getSliderDates()
{
	$.get("/fifa-rankings/date-range/" + $("#start").val() + "/" + $("#end").val(), function(data){
		$("#sliderDate").html(data);
	});	
}

</script>            

@endsection

@section('content')
    <h1 class="fullTitleBar">FIFA Rankings<div class="breadcrumb"><a href="/">Home</a> > <span>FIFA Rankings</span></div></h1>
    <div class="introText">The FIFA Rankings is a method of ranking the international teams that are members of FIFA.  Every month a new list is published, with the rankings based on each team's results.  The system was started back in December 1992.</div>
    <div class="rankingStats">
        <div class="rankingHeading">Current Ranking:</div>
        <div class="rankingData">{{ $ranking->current->ranking }}</div>
        <div class="rankingHeading">Highest Ranking:</div>
        <div class="rankingData">{{ $ranking->highest->ranking }} ({{ $ranking->highest->date->format('F Y') }})</div>
        <div class="rankingHeading">Lowest Ranking:</div>
        <div class="rankingData">{{ $ranking->lowest->ranking }} ({{ $ranking->lowest->date->format('F Y') }})</div>
        <div class="rankingHeading">Greatest Rise:</div>
        <div class="rankingData">+{{ $ranking->rise_fall['greatestRise'] }} ({{ $ranking->rise_fall['greatestRiseDate'] }})</div>
        <div class="rankingHeading">Greatest Fall:</div>
        <div class="rankingData">-{{ $ranking->rise_fall['greatestFall'] }} ({{ $ranking->rise_fall['greatestFallDate'] }})</div>
        <div class="rankingHeading">Next FIFA Ranking:</div>
        <div class="rankingData">{{ $ranking->next_ranking }}</div>
        <div class="rankingHeading">&nbsp;</div>
        <div class="rankingHeadingTitle">Zonal Records (UEFA):</div>
        <div class="rankingHeading">Current Ranking:</div>
        <div class="rankingData">{{ $ranking->current->europe }}</div>
        <div class="rankingHeading">Highest Ranking:</div>
        <div class="rankingData">{{ $ranking->highest->europe->ranking }} ({{ $ranking->highest->europe->date->format('F Y') }})</div>
        <div class="rankingHeading">Lowest Ranking:</div>
        <div class="rankingData">{{ $ranking->lowest->europe->ranking }} ({{ $ranking->lowest->europe->date->format('F Y') }})</div>
        <div class="rankingHeading">Greatest Rise:</div>
        <div class="rankingData">+{{ $ranking->rise_fall['greatestZonalRise'] }} ({{ $ranking->rise_fall['greatestZonalRiseDate'] }})</div>
        <div class="rankingHeading">Greatest Fall:</div>
        <div class="rankingData">-{{ $ranking->rise_fall['greatestZonalFall'] }} ({{ $ranking->rise_fall['greatestZonalFallDate'] }})</div>
        
        <a onclick="updateChart()" class="chartLink" id="chartLink">View Zonal Chart</a>
    </div>
    
    <div id="fifaChart"></div>
    
    <div class="rankingSliderHolder">
        <div class="rankingSliderTitle">Chart Date Range</div>
        <div class="rankingSliderSubTitle">Use the slider below to change the max and min date values for the chart above.</div>
        <div class="sliderScale">
            @foreach ($ranking->slider_scale as $marker)
            <div class="sliderScaleSector">{{ $marker->date->format('Y') }}</div>
            @endforeach
        </div>
        <div class="rankingSlider">
            <div id="sliderRange"></div>
        </div>
        <div class="sliderDate"><span class="sliderDateHeading">Date Range: </span><span id="sliderDate"></span></div>
    </div>
    
    <div class="rankingRecords">
        @for ($i = 0; $i < 3; $i++)
        <div class="rankingRecordsColumn">
            <div class="rankingRecordsRow">
                <div class="rankingRecordsDate">Date</div>
                <div class="rankingRecordsRanking">Ranking</div>
                <div class="rankingRecordsRanking">Points</div>
                <div class="rankingRecordsRanking">Europe</div>
            </div>
            @foreach ($ranking->monthly_records[$i] as $record)
            <div class="rankingRecordsRow">
                <div class="rankingRecordsDate">{{ $record->date->format('F Y') }}</div>
                <div class="rankingRecordsRanking">{{ $record->ranking }}</div>
                <div class="rankingRecordsRanking">{{ $record->points }}</div>
                <div class="rankingRecordsRanking">{{ $record->europe }}</div>
            </div>
            @endforeach
        </div>
        @endfor
    </div>

    <input type="hidden" id="start" value="1" />
    <input type="hidden" id="end" value="{{ $ranking->current->id }}" />
    <input type="hidden" id="chart" value="1" />
@endsection