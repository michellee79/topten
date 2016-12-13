
$(document).ready(function () {
});

function upload(){
	if ($("#fup").get(0).files.length > 0) {
		fdata = new FormData();
        
        file = $("#fup").get(0).files[0];
        fdata.append('file', file, file.name);
        fdata.append('promo', $("#txtPromoCode").val());

        showLoading();

        showInfoToast("Your file has been accepted. It might take longer. We're processing your request, so you may do something else.");

        $.ajax({
            url : '/aajax/user/import',
            type : 'post',
            dataType : 'json',
            contentType: false,
            processData: false,
            success: function(data){
                hideLoading();
                if (data.success == 'true'){
                    showSuccessToast(data.message);
                } else{
                    showErrorToast(data.message);
                }
            },
            data : fdata
        });
	}
}

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}

function deleteImage(id){
	var r = confirm("Do you want to delete this image?");
	if (r == true){
		showLoading();
		$.ajax({
			url: '/fajax/business/deletegalleryimage/' + id,
			type: 'get',
			dataType: 'json',
			success: function(data){
				$("#images").html(data.html);
				hideLoading();
			},
		});
	}
}
