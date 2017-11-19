// JavaScript Document

$(document).ready(function() {
						   
	// Home page scroller					   
	$("#introTicker").show();
	$("#introTicker").liScroll();
	
	// Search form dates
	$("#dateFrom, #dateTo").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		yearRange: '1872:' + new Date().getFullYear()
	});
	
	// Match Details Tabs
	$( "#matchDetails" ).tabs();

	// Competition Tables Tabs
	$( "#competitionTables" ).tabs();
	
	
	// Fix position after scrolling to bottom of header
	$.fn.fixedAfter = function (pos) {
		var $this = this,
			$window = $(window);
	 
		$window.scroll(function (e) {
			if ($window.scrollTop() > pos) {
				$this.css({
					position: 'fixed',
					top: '10px'
				});
			} else {
				$this.css({
					position: 'relative',
					top: '0'
				});
			}
		});
	};
	 
	$('.playerLeftContainer').fixedAfter(160);
	$('.managerLeftContainer').fixedAfter(160);
	$('.matchListSearch').fixedAfter(160);
	
	
	// Setup Tooltips
	SetupPlayerTooltip();
	SetupPlayerMatchTooltip();
	SetupCompetitionTooltip();
	SetupStripTooltip();
	
	
	// Scrollbar in Competition Index Page
	$('.competitionListWindow').jScrollPane({showArrows: true});
	$('.jspArrowUp').html('<i class="fa fa-chevron-up"></i>');
	$('.jspArrowDown').html('<i class="fa fa-chevron-down"></i>');
	
	
	// History page accordion
	$( "#historyAccordion" ).accordion({
    	heightStyle: "content"
    });
	
	
	// Contact us
	sendMessage();
});


/* ====================================== Match Search ======================================== */

function matchSearch() {
	var opponent = $("#opponent").val();
	var datefrom = $("#dateFrom").val();
	if (datefrom != "") {
		datefrom = datefrom.substr(6,4) + "-" + datefrom.substr(3,2) + "-" + datefrom.substr(0,2);
	}
	var dateto = $("#dateTo").val();
	if (dateto != "") {
		dateto = dateto.substr(6,4) + "-" + dateto.substr(3,2) + "-" + dateto.substr(0,2);
	}
	var result = $("#result").val();
	var venue = $("#venue").val();
	var matchtype = $("#matchtype").val();
	
	var query = "";
	if (opponent != ""){
		query += "&opponent=" + opponent;
	}
	if (datefrom != ""){
		query += "&datefrom=" + datefrom;
	}
	if (dateto != ""){
		query += "&dateto=" + dateto;
	}
	if (venue != ""){
		query += "&venue=" + venue;
	}
	if (result != ""){
		query += "&result=" + result;
	}	
	if (matchtype != ""){
		query += "&matchtype=" + matchtype;
	}	
	
	query = query.substr(1);
	
	if (query == "") {
		query = "all";	
	}
	
	location.href = "/match-search/" + query + "/";
}


/* ===================================== Player Search ========================================== */

function playerSearch() {
	var name = $("#playername").val();
	var datefrom = $("#dateFrom").val();
	if (datefrom != "") {
		datefrom = datefrom.substr(6,4) + "-" + datefrom.substr(3,2) + "-" + datefrom.substr(0,2);
	}
	var dateto = $("#dateTo").val();
	if (dateto != "") {
		dateto = dateto.substr(6,4) + "-" + dateto.substr(3,2) + "-" + dateto.substr(0,2);
	}
	var manager = $("#manager").val();
	var club = $("#club").val();
	
	var query = "";
	if (name != ""){
		query += "&name=" + name;
	}
	if (datefrom != ""){
		query += "&datefrom=" + datefrom;
	}
	if (dateto != ""){
		query += "&dateto=" + dateto;
	}
	if (manager != ""){
		query += "&manager=" + manager;
	}	
	if (club != ""){
		query += "&club=" + club;
	}	
	
	query = query.substr(1);
	
	if (query == "") {
		query = "all";	
	}
	
	location.href = "/players/search/" + query + "/";
}


/* ====================================== Match List Tooltip ========================================= */

function SetupPlayerMatchTooltip(){

    // http://qtip2.com/
    $('.matchIcon').each(function() {
        $(this).qtip({
            content: {
                text: function (event, api) {
                    $.ajax({
                        url: '/players/tooltip/matches/' + $(this).attr('id')
                    })
                        .then(function(content) {
                            // Set the tooltip content upon successful retrieval
                            api.set('content.text', content);
                        }, function(xhr, status, error) {
                            // Upon failure... set the tooltip content to error
                            api.set('content.text', status + ': ' + error);
                        });
                    return '';
                }
            },
            position: { my: 'rightMiddle', at: 'leftMiddle' },
            style: { classes: 'matchTooltip' }
        });
    });
}

/* ====================================== Player Details Tooltip ========================================= */

function SetupPlayerTooltip(){
    // http://qtip2.com/
    $('.icon').each(function() {
        $(this).qtip({
            content: {
                text: function (event, api) {
                    $.ajax({
                        url: '/players/tooltip/' + $(this).data('type') + '/' + $(this).data('id')
                    })
                        .then(function(content) {
                            // Set the tooltip content upon successful retrieval
                            api.set('content.text', content);
                        }, function(xhr, status, error) {
                            // Upon failure... set the tooltip content to error
                            api.set('content.text', status + ': ' + error);
                        });
                    return '';
                }
            },
            position: { my: 'lefttop', at: 'rightmiddle' },
            style: { classes: 'playerTooltip' }
        });
    });

	/*$('.icon').each(function() {
		$(this).qtip({
			content: {
				url: '/ajax/tooltip/' + $(this).data('type') + '/' + $(this).data('id')
			},
			position: {
				corner: {
					target: 'rightMiddle',
					tooltip: 'leftTop'
				}
			},
			show: 'mouseover',
			hide: 'mouseout',
			style: {
				tip: {corner: 'leftTop', color: '#FFFFFF'},
				width: 210,
				backgroundColor: '#000066',
				border: {width: 1, color: '#FFFFFF'}
			}
		});
	});*/
}

/* ====================================== Competition Tooltip ========================================= */

function SetupCompetitionTooltip(){

    // http://qtip2.com/
    $('.icon1').each(function() {
        $(this).qtip({
            content: {
                text: '<div class="tooltipText">' + $(this).data("summary") +  '</div>'
            },
            position: { my: 'lefttop', at: 'rightmiddle' },
            style: { classes: 'playerTooltip' }
        });
    });


	/*$('.icon1').each(function() {
        $(this).qtip({
			content: '<div class="tooltipText">' + $(this).data("summary") +  '</div>',
			position: {
				corner: {
					target: 'rightMiddle',
					tooltip: 'leftTop'
				}
			},
			show: 'mouseover',
			hide: 'mouseout',
			style: {
				tip: {corner: 'leftTop', color: '#FFFFFF'},
				width: 210,
				backgroundColor: '#000066',
				border: {width: 1, color: '#FFFFFF'}
			}
		})
	}); */
}

/* ====================================== Strip Details Tooltip ========================================= */

function SetupStripTooltip(){
    $('.stripIcon').each(function() {
        $(this).qtip({
            content: {
                url: '/ajax/strip-tooltip/' + $(this).attr('id')
            },
            position: {
                corner: {
                    target: 'leftMiddle',
                    tooltip: 'rightMiddle'
                }
            },
            show: 'mouseover',
            hide: 'mouseout',
            style: {
                tip: {corner: 'rightMiddle', color: '#000066'},
                width: 200,
                backgroundColor: '#000066',
                border: { width: 0 }
            }
        })
    });    
}

/* ======================================= Contact Us =========================================== */

function sendMessage() {
	$("#send").click(function(){
		
		var valid = true;
		
		if (String($("#email").val()).indexOf("@") < 1){
			$("#emailError").html("Please input a valid email address");
			valid = false;
		}
		else {
			$("#emailError").html("");
		}
		
		if ($("#subject").val() == ""){
			$("#subjectError").html("Please input a subject title");
			valid = false;
		}
		else {
			$("#subjectError").html("");
		}
		
		if ($("#message").val() == ""){
			$("#messageError").html("Please input a message");
			valid = false;
		}
		else {
			$("#messageError").html("");
		}
		
		if (valid) {
			$.post( "/ajax/email", { email: $("#email").val(), subject: $("#subject").val(), message: $("#message").val(), _token: $("input[name=_token]").val() })
			.done(function( data ) {
				$("#clear").click();
				$(".contactSuccess").html("Your message has been sent.");
				$("#contactSuccess").show();
			})
			.fail(function( data ) {
				$("#clear").click();
				$(".contactSuccess").html("Your message has failed.");
				$("#contactSuccess").show();
			});
		}
	});
	
	$("#clear").click(function() {
		$("#email").val('');	
		$("#subject").val('');
		$("#message").val('');
		$("#emailError").html("");
		$("#subjectError").html("");
		$("#messageError").html("");
		$("#contactSuccess").hide();
	});
	
}



