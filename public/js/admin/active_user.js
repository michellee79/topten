var selUserId;

$(document).ready(function(){
	$("#txtFilter").keypress(function(e){
		if (e.keyCode == 13){
			setFilter();
		}
	});
});

$(document).keyup(function(e){
	if (e.keyCode == 27)
		hideEdit();
});

function showEdit(id){
	showLoading();
	$.ajax({
		url: '/aajax/user/getuserdetail/' + id,
		type: 'get',
		dataType: 'json',
		success: function(data){
			if (data.success == 'true'){
				$("#lblCode").val(data.promoCode);
				$("#lblUsername").html(data.email);
				$("#txtFirstName").val(data.firstName);
				$("#txtLastName").val(data.lastName);
				$("#txtZipcode").val(data.zipcode);
				showFields();
				selUserId = id;
			}
			hideLoading();
		}
	});
}

function submitEdit(){
	if (!validate())
		return;
	showLoading();
	$.ajax({
            url : '/aajax/user/saveuserdetail/' + selUserId,
            type : 'post',
	        dataType : 'json',
	        success: function(data){
	        	hideLoading();
                if (data.success == 'true'){
                    showSuccessToast('Updated user detail');
                    location.reload();
                } else{
                    showErrorToast(data.message);
                }
                hideEdit();
            },
            data : {
            	firstName: $("#txtFirstName").val(),
            	lastName: $("#txtLastName").val(),
            	zipcode: $("#txtZipcode").val()
            }
        });
}

function validate(){
	flag = true;
	$(".requiredInput").each(function(index){
		idStr = $(this).attr('name');
		if ($(this).val() == ""){
			$("#" + idStr + "Required").css('visibility', 'visible');
			flag = false;
		} else{
			$("#" + idStr + "Required").css('visibility', 'hidden');
		}
	});
	return flag;
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

function setFilter(){
	f = $("#ddlFilterType").val();
	$.ajax({
        url : '/aajax/activeuser/setfilter',
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

function showFields(){
	$("#grid").slideUp();
	$("#fields").slideDown();
}

function hideFields(){
	$("#fields").slideUp();
	$("#grid").slideDown();
}

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}