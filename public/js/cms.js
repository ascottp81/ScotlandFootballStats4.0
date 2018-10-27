// JavaScript Document
$(document).ready(function()
{
	// Date picker
	$(".datepicker").datepicker({
 		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1872:2050'
	});
	
	$(".datepicker_dob").datepicker({
 		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd MM yy',
		defaultDate: '-15y',
		yearRange: '1820:' + (new Date().getFullYear() - 15)
	});

	$('.datatable').dataTable({
	    aLengthMenu: [
	        [25, 50, 100, 200, -1],
	        [25, 50, 100, 200, "All"]
	    ],
	    iDisplayLength: 100,
		"order": [[0, "asc"]]
	});
	
	$('.datatableMatches').dataTable({
	    aLengthMenu: [
	        [25, 50, 100, 200, -1],
	        [25, 50, 100, 200, "All"]
	    ],
	    iDisplayLength: 100,
		"order": [[0, "desc"]]
	});

    $('.dataTableCompetitionType').DataTable({
        "order": [ 0, "asc" ],
        "paging": false,
        "searching": false,
        "info": false,
        "columnDefs": [
            { "orderData": 3, "targets": 0 },
            { "orderData": [ 1, 3 ], "targets": 1 },
            { "orderable": false, "targets": 2 },
            { "visible": false, "targets": 3 }
        ]
    });
	
	$('.datatableCompetitions').dataTable({
		"ordering": false,
	    aLengthMenu: [
	        [25, 50, 100, 200, -1],
	        [25, 50, 100, 200, "All"]
	    ],
	    iDisplayLength: 100
	});
	
	$("#submit").click(function(e) {
		var valid = true;
        $("input[type=text], select").removeClass("errorInput");

		$("input[type=text]").each(function() {
			if ($(this).attr("data-required") == "true" && $(this).val() == "") {
				$(this).addClass("errorInput");
				valid = false;
			}
		});
        $("select").each(function() {
            if ($(this).attr("data-required") == "true" && $(this).val() == "") {
                $(this).addClass("errorInput");
                valid = false;
            }
        });
		
		if (!valid){
			e.preventDefault();
		}
	});
	
	$(".closeNotification").click(function() {
		$(".notification").hide();
	});


	
	// match details functions
    setupShirtNoCheckbox();
	setupRemoveSub();
    setupRemoveIncident();
    setupRemovePenalty();
	
	
	// Competition Table Input
	$("#playoff").click(function(){
		if ($(this).is(':checked')) {
			$("#competitionTable").addClass("hide");
		}
		else {
			$("#competitionTable").removeClass("hide");
		}
	});
	
	setupRemoveTableRow();
	
});


/* ================================== Team Lineup ==================================== */

function addSub() {
	$.get("/admin/ajax/lineup/" + $("#itemid").val(), function(data){
		$(".addSub").before(data);

		setupShirtNoCheckbox();
		setupRemoveSub();
	});		
}
function setupRemoveSub() {
    $(".removesub").unbind( "click" ).click(function(){
		if (confirm("Are you sure you want to delete this sub?")){	
			$(this).parent().parent().remove();
			
			var id = $(this).parent().next().next().val();
			$.get("/admin/ajax/lineup/remove/" + id);	
		}
	});	
}
function setupShirtNoCheckbox() {
    $(".shirtCb, .captainCb").unbind("click").click(function(){
        if ($(this).is(":checked")) {
            $(this).next().val("1");
        }
        else {
            $(this).next().val("0");
        }
    });
}
function allShirtNo(){
	if ($("#ShirtCb").is(":checked")){
		$(".shirtCb").attr("checked", "checked").prop("checked", true).next().val('1');
	}
	else{
		$(".shirtCb").removeAttr("checked").prop("checked", false).next().val('0');
	}
}


function submitForm(){
	$("form").removeAttr("target").attr("action", $("#action").val()).submit();
}

function changeFormation() {
	$(".formationip input").removeClass();
	
	var formationArray = String($("#formation").val()).split("-");
	
	$(".formationip input:eq(0)").addClass("row1").addClass("size1");
	
	var count = 1;
	for (var i = 0; i < formationArray.length; i++) {
		
		for (var j = 0; j < formationArray[i]; j++) {
			$(".formationip input:eq(" + count + ")").addClass("row" + (i + 2));
			if (j == 0) {
				$(".formationip input:eq(" + count + ")").addClass("size" + formationArray[i]);
			}
			count++;
		}
	}
	
}


/* ================================== Penalty Shoot-out ==================================== */

function addPenalty() {
	$.get("/admin/ajax/penalty/" + $("#itemid").val(), function(data){
		$(".addSub").before(data);
		setupRemovePenalty();
	});
}
function setupRemovePenalty() {
    $(".removePenalty").unbind( "click" ).click(function(){
		if (confirm("Are you sure you want to delete this penalty?")){
			$(this).parent().parent().remove();

			var id = $(this).parent().next().val();
			$.get("/admin/ajax/penalty/remove/" + id);
		}
	});
}


/* ================================== Incidents ==================================== */

function addIncident() {
	$.get("/admin/ajax/incident/" + $("#itemid").val(), function(data){
		$(".addSub").before(data);
		setupRemoveIncident();
	});
}
function setupRemoveIncident() {
    $(".removeIncident").unbind( "click" ).click(function(){
		if (confirm("Are you sure you want to delete this incident?")){
			$(this).parent().parent().remove();

			var id = $(this).parent().next().val();
			$.get("/admin/ajax/incident/remove/" + id);
		}
	});
}


/* ================================== Competition Table ==================================== */

function addTableRow() {
	$.get("/admin/ajax/table", function(data){
		$("#sortable").append(data);
		setupRemoveTableRow();
		$( "#sortable" ).sortable( "disable" );
		var result = $('#sortable').sortable('toArray'); 
		orderTable(result);
		
		$(".topCb, .poCb").click(function(){
			if ($(this).is(":checked")) {
				$(this).next().val("1");	
			}
			else {
				$(this).next().val("0");
			}
		});
	});
}
function setupRemoveTableRow() {
	$(".removeRow").click(function(){
		if (confirm("Are you sure you want to delete this team?")){	
			$(this).parent().parent().remove();
			
			var id = $(this).parent().next().val();
			$.get("/admin/ajax/table/remove/" + id);	
		}
	});
}

function orderTable(order) {
	$.get("/admin/ajax/table/position/" + order);
}



/* =============================== News ===================================== */

function deleteArticle(id) {
	if (confirm("Are you sure that you want to delete this article?")) {
		location.href = "/admin/news/delete/" + id;
	}
}

