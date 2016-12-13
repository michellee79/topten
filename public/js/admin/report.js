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

});

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}

function filterF(){
	params = validate();
	if (params != false){
		showLoading();
		$.ajax({
			url: '/aajax/adminreport',
			type: 'post',
			dataType: 'json',
			success: function(data){
				$("#pnlUpdate").html(data.html);
				hideLoading();
			},
			data: params
		});
	}
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
	if (f){
		start = new Date($("#txtStartDate").val());
		end = new Date($("#txtEndDate").val());
		params.start = formatDate(start);
		params.end = formatDate(end);
		params.code = $("#txtFranchiseCode").val();
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