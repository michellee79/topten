
$(document).ready(function () {
	$("#AddNewImage").on("click", function () {
        showFields();
    });

    $("#btnImage").on("click", function () {
        showGrid();
    });

    $('#ContentPlaceHolder1_ddlCategory').live("change", function () {
        showLoadingAndFields();
    });

    $('#ContentPlaceHolder1_ddlImageSelection').live("change", function () {
        showLoadingAndFields();
    });

    $('.image').live("mouseover", function () {
        $(this).find('.delete').show();
    });

    $('.image').live("mouseout", function () {
        $(this).find('.delete').hide();
    });

    $('.imageCollection').live("mouseover", function () {
        $(this).find('.select').show();
    });

    $('.imageCollection').live("mouseout", function () {
        $(this).find('.select').hide();
    });
});

function upload(){
	if ($("#image").get(0).files.length > 0) {
		fdata = new FormData();
		fdata.append('bid', bId);
        
        file = $("#image").get(0).files[0];
        fdata.append('image', file, file.name);

        showLoading();

        $.ajax({
            url : '/fajax/business/uploadgalleryimage/' + bId,
            type : 'post',
            dataType : 'json',
            contentType: false,
            processData: false,
            success: function(data){
                hideLoading();
                if (data.success == 'true'){
                    $("#images").html(data.html);
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
			url: '/fajax/business/deletegalleryimage/' + bId + '/' + id,
			type: 'get',
			dataType: 'json',
			success: function(data){
				$("#images").html(data.html);
				hideLoading();
			},
		});
	}
}
