var bId;
var fId;

$(document).ready(function () {            
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        //maxDate: "+0",
        defaultDate: "+0",
        readOnly: true
    });
    $("#txtBusinessName").autocomplete("/fajax/business/getnames", {
    	delay: 10,
    	minChars: 2,
    	matchSubset: 1,
    	matchContains: 1
    });

});

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}


function filterB(){
	params = validate();
	if (params != false){
		showLoading();
		$.ajax({
			url: '/fajax/businessreport/' + bId,
			type: 'post',
			dataType: 'json',
			success: function(data){
				$("#lblVisits").text(data.visits);
				$("#lblDownloads").text(data.downloads);
				hideLoading();
			},
			data: params
		});
	}
}

function filterF(){
	params = validate();
	if (params != false){
		showLoading();
		$.ajax({
			url: '/fajax/franchisereport',
			type: 'post',
			dataType: 'json',
			success: function(data){
				$("#pnlUpdate").html(data.html);
				$("#txtBusinessName").val(data.businessName);
				hideLoading();
			},
			data: params
		});
	}
}

function savePDF(){
	params = validate();
	if (params != false){
		showLoading();
		$.ajax({
			url: '/fajax/franchisereportpdf',
			type: 'post',
			dataType: 'json',
			success: function(data){
				$("#pnlUpdate").html(data.html);
				$("#txtBusinessName").val(data.businessName);
				hideLoading();
				window.location = '/franchise/getreport/' + data.file;
			},
			data: params
		});
	}
}

function reset(){
	$("#txtStartDate").val('');
	$("#txtEndDate").val('');
	$("#startDateRequired").css('visibility', 'hidden');
	$("#endDateRequired").css('visibility', 'hidden');
	$("#lblVisits").text('');
	$("#lblDownloads").text('');
}

function resetF(){
	location.reload();
}

function validate(){
	params = {};
	f = true;
	if ($("#txtStartDate").val() == ''){
		$("#startDateRequired").css('visibility', 'visible');
		f = false;
	} else{
		$("#startDateRequired").css('visibility', 'hidden');
	}
	if ($("#txtEndDate").val() == ''){
		$("#endDateRequired").css('visibility', 'visible');
		f = false;
	} else{
		$("#endDateRequired").css('visibility', 'hidden');
	}
	if ($("#txtBusinessName").val() == ''){
		$("#businessNameRequired").css('visibility', 'visible');
		f = false;
	} else{
		$("#businessNameRequired").css('visibility', 'hidden');
	}
	if (f){
		start = new Date($("#txtStartDate").val());
		end = new Date($("#txtEndDate").val());
		params.start = formatDate(start);
		params.end = formatDate(end);
		params.business = $("#txtBusinessName").val();
		return params;
	}
	return f;
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}