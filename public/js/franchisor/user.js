var rId;

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}

function sendEmail(id){
	showLoading();
	$.ajax({
		url: '/fajax/sendactivationemail/' + id,
		type: 'get',
		dataType: 'json',
		success: function(data){
			if (data.success){
				showSuccessToast(data.message);
			} else {
				showErrorToast(data.message);
			}
			hideLoading();
		},
	});
}