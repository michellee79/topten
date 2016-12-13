var selUserId;

$(document).ready(function(){
	$("#txtFilter").keypress(function(e){
		if (e.keyCode == 13){
			setFilter();
		}
	});
});

function deleteUser(uid){
	if (confirm('Are you sure to delete this consumer member?') == false)
		return;
	showLoading();
	$.ajax({
        url : '/aajax/user/delete/' + uid,
        type : 'get',
        dataType : 'json',
        success: function(data){
            if (data.success == 'true'){
                location.reload();
            } else{
            	hideLoading();
                showErrorToast(data.message);
            }
        }
    });
}

function setFilter(){
	f = $("#ddlFilterType").val();
	$.ajax({
        url : '/aajax/inactiveuser/setfilter',
        type : 'post',
        dataType : 'json',
        success: function(data){
        	location.reload();
        },
        data:{
        	key: f,
        	value: $("#txtFilter").val()
        }
    });
}

function resetFilter(){
	$("#ddlFilterType").val('');
	$("#txtFilter").val('');
	setFilter();
}


function deleteUser(uid){
    if (confirm('Are you sure to delete this consumer member?') == false)
        return;
    showLoading();
    $.ajax({
        url : '/aajax/user/delete/' + uid,
        type : 'get',
        dataType : 'json',
        success: function(data){
            if (data.success == 'true'){
                location.reload();
            } else{
                hideLoading();
                showErrorToast(data.message);
            }
        }
    });
}

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}