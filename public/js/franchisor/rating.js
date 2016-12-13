var rId;

$(document).ready(function () {            
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        //maxDate: "+0",
        defaultDate: "+0",
        readOnly: true
    });

});

function submit(){
	params = validate();
	$.ajax({
            url : '/fajax/savecontract/' + bId,
            type : 'post',
	        dataType : 'json',
	        success: function(data){
                if (data.success == 'true'){
                    location.reload();
                } else{
                    showErrorToast(data.message);
                }
            },
            data : params
        });
}

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}

function showEdit(rid){
	showLoading();
	$.ajax({
		url: '/fajax/getrating/' + rid,
		type: 'get',
		dataType: 'json',
		success: function(data){
			$("#lblMemberName").text(data.firstName);
			$("#imgRating").attr('src', '/Images/Rating_' + data.rating + '_of_5.png');
			$("#txtComment").text(data.comment);
			hideLoading();
			$('.grid').slideUp();
			$(".fields").slideDown();
			rId = data.id;
		}
		});
}

function hideEdit(){
	$(".fields").slideUp();
	$('.grid').slideDown();
}

function submit(){
	showLoading();
	params = validate();
	$.ajax({
		url: '/fajax/saverating/' + rId,
		type: 'post',
		dataType: 'json',
		success: function(data){
			$("#ratings").html(data.html);
			hideLoading();
			hideEdit();
		},
		data: params
	});
}

function validate(){
	param = {};
	param.comment = $("#txtComment").val();
	return param;
}

function deleteRating(id){
	var r = confirm("Do you want to delete this rating?");
	if (r == true){
		showLoading();
		$.ajax({
			url: '/fajax/deleterating/' + id,
			type: 'get',
			dataType: 'json',
			success: function(data){
				$("#ratings").html(data.html);
				hideLoading();
			},
		});
	}
}

function activateRating(id){
	showLoading();
	$.ajax({
		url: '/fajax/activaterating/' + id,
		type: 'get',
		dataType: 'json',
		success: function(data){
			$("#ratings").html(data.html);
			hideLoading();
		},
	});
}