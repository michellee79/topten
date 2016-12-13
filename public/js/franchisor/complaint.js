var cId;

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

function showEdit(cid){
	showLoading();
	$.ajax({
		url: '/fajax/getcomplaint/' + cid,
		type: 'get',
		dataType: 'json',
		success: function(data){
			$("#lblMemberName").text(data.firstName);
			$("#lblEmail").text(data.email);
			$("#imgRating").attr('src', '/Images/Rating_' + data.rating + '_of_5.png');
			$("#txtComment").val(data.comment);
            $("[name='rblRatings']").each(function(idx, el) {
                if(el.value == this.rating)
                    el.checked = true;
            }.bind(data));

			if (data.isResolved){
				$("#cbxIsResolved").attr('checked', 'checked');
			} else{
				$("#cbxIsResolved").removeAttr('checked', 'checked');
			}
			hideLoading();
			$('.grid').slideUp();
			$(".fields").slideDown();
			cId = data.id;
		}
		});
}

function hideEdit(){
	$(".fields").slideUp();
	$('.grid').slideDown();
}

function deleteComplaint(cId) {
    showLoading();
    $.ajax({
        url: '/fajax/deletecomplaint/' + cId,
        type: 'delete',
        dataType: 'json',
        success: function(data){
            hideLoading();
            if(data['success'] == "true")
            {
                $("#trComplaint_" + cId).remove();
            }
        }
    });
}

function submit(){
	showLoading();
	params = validate();
	$.ajax({
		url: '/fajax/savecomplaint/' + cId,
		type: 'post',
		dataType: 'json',
		success: function(data){
            updateComplaintView(cId, param);
			hideLoading();
			hideEdit();
		},
		data: params
	});
}

function updateComplaintView(cId, params) {
    $("#lblIsResolved_" + cId).text(params.isResolved == 1 ? 'True' : 'False');
    $("#lblComment_" + cId).text(params.comment);
    $("#imgRating_" + cId).prop('src', '/Images/Rating_' + params.rating + '_of_5.png');
}

function getRatingValue() {
    var result = {'rating': 0};
    $("[name='rblRatings']").each(function(idx, el) {
        if(el.checked == true)
            this.rating = el.value;
    }.bind(result));
    return result.rating;
}

function validate(){
	param = {};
	param.isResolved = $("#cbxIsResolved").attr('checked') == 'checked' ? 1 : 0;
    param.comment = $("#txtComment").val();
    param.rating = getRatingValue();
	return param;
}