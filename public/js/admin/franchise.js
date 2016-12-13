var fId;

function showCreate(){
	fId = 0;
	$("#lblAddOrEdit").text('Add');
	$("#txtCode").val('');
	$("#txtCode").removeAttr('disabled');
	$("#txtName").val('');
	$("#txtLegalName").val('');
	$("#txtStreetAddress").val('');
	$("#txtZipcode").val('');
	$("#txtCity").val('');
	$("#ddlState").val('');
	$("#txtZipcodes").val('');
	$("#txtFirstName").val('');
	$("#txtLastName").val('');
	$("#txtEmails").val('');
	$("#txtPhone").val('');
	$("#txtLmGroup").val('');
	$("#txtLmUsername").val('');
	$("#txtLmPassword").val('');
	$("#cbxStatus").removeAttr('checked');
	$("#cbxLaunchStatus").removeAttr('checked');
	$("#cbxShowOnContract").removeAttr('checked');

	showFields();
}

function showEdit(id){
	showLoading();
	$.ajax({
		url: '/aajax/franchise/getfranchiseedetail/' + id,
		type: 'get',
		dataType: 'json',
		success: function(data){
			if (data.success == 'true'){
				$("#lblAddOrEdit").text('Edit');
				$("#txtCode").val(data.code);
				$("#txtCode").attr('disabled', 'disabled');
				$("#txtName").val(data.name);
				$("#txtLegalName").val(data.legalName);
				$("#txtStreetAddress").val(data.streetAddress);
				$("#txtCity").val(data.city);
				$("#txtCity").val(data.city);
				$("#ddlState").val(data.state);
				$("#txtZipcode").val(data.zipcode);
				$("#txtZipcodes").val(data.zipcodes);
				$("#txtFirstName").val(data.firstName);
				$("#txtLastName").val(data.lastName);
				$("#txtEmails").val(data.emails);
				$("#txtPhone").val(data.phone);
				$("#txtLmGroup").val(data.lmGroup);
				$("#txtLmUsername").val(data.lmUser);
				$("#txtLmPassword").val(data.lmPassword);
				if (data.status){
					$("#cbxStatus").attr('checked', 'checked');
				} else{
					$("#cbxStatus").removeAttr('checked');
				}
				if (data.launchStatus){
					$("#cbxLaunchStatus").attr('checked', 'checked');
				} else{
					$("#cbxLaunchStatus").removeAttr('checked');
				}
				if (data.showOnContract){
					$("#cbxShowOnContract").attr('checked', 'checked');
				} else{
					$("#cbxShowOnContract").removeAttr('checked');
				}
				showFields();
				fId = id;
			}
			hideLoading();
		}
	});
}

function submitEdit(){
	params = validate();
	if (params === false)
		return;
	showLoading();
	$.ajax({
            url : '/aajax/franchise/savefranchise/' + fId,
            type : 'post',
	        dataType : 'json',
	        success: function(data){
	        	hideLoading();
                if (data.success == 'true'){
            		showSuccessToast(data.message);
                    $("#franchisees").html(data.html);
                    hideFields();
                } else{
                    showErrorToast(data.message);
                }
            },
            data : params
        });
}

function validate(){
	flag = true;
	params = {};
	params['status'] = $("#cbxStatus").attr('checked') == 'checked' ? 1 : 0;
	if (params['status'] == 1){
		$(".requiredParam").each(function(index){
			idStr = $(this).attr('name');
			if ($(this).val() == ""){
				$("#" + idStr + "Required").css('visibility', 'visible');
				flag = false;
			} else{
				$("#" + idStr + "Required").css('visibility', 'hidden');
				params[idStr] = $(this).val();
			}
		});
		if (flag == false)
			return false;
	}
	params['emails'] = $("#txtEmails").val();
	params['zipcodes'] = $("#txtZipcodes").val();
	params['status'] = $("#cbxStatus").attr('checked') == 'checked' ? 1 : 0;
	params['launchStatus'] = $("#cbxLaunchStatus").attr('checked') == 'checked' ? 1 : 0;
	params['showOnContract'] = $("#cbxShowOnContract").attr('checked') == 'checked' ? 1 : 0;
	return params;
}

function toggleFranchiseeStatus(id){
	showLoading();
	$.ajax({
        url : '/aajax/franchise/togglefranchiseestatus/' + id,
        type : 'get',
        dataType : 'json',
        success: function(data){
        	hideLoading();
            if (data.success == 'true'){
                $("#lbStatus_" + id).html(data.status);
            } else{
                showErrorToast(data.message);
            }
        }
    });
}

function deleteFranchisee(id){
	if (confirm('Are you sure to delete this coupon?') == false)
		return;
	showLoading();
	$.ajax({
        url : '/aajax/franchise/delete/' + id,
        type : 'get',
        dataType : 'json',
        success: function(data){
            if (data.success == 'true'){
                $("#row_" + id).remove();
                hideLoading();
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
	$(".validator").css('visibility', 'hidden');
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