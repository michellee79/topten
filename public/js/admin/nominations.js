function refreshApproval(){
	code = $("#ddlApprovalStatus").val();
	$.ajax({
		url: '/aajax/nomination/setapprovalfilter/' + code,
		type: 'get',
		dataType: 'json',
		success: function(data){
			location.reload();
		}
	});
}

function refreshFranchisee(){
	code = $("#ddlFranchiseCode").val();
	$.ajax({
		url: '/aajax/nomination/setfranchiseefilter/' + code,
		type: 'get',
		dataType: 'json',
		success: function(data){
			location.reload();
		}
	});
}

function toggleApproval(id){
	showLoading();
	$.ajax({
		url: '/aajax/nomination/setapproval/' + id,
		type: 'get',
		dataType: 'json',
		success: function(data){
			location.reload();
		}
	});
}

function deleteNomination(id){
	r = confirm("Do you really want to delete this nomination?");
	if (r == false)
		return;
	showLoading();
	$.ajax({
		url: '/aajax/nomination/delete/' + id,
		type: 'get',
		dataType: 'json',
		success: function(data){
			if (data.success == 'true'){
				$("#row_" + id).remove();
			}
			hideLoading();
		}
	});
}

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}