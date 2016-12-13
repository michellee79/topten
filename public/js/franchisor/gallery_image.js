var bId;

$(document).ready(function () {
	$("#AddNewImage").on("click", function () {
        showFields();
    });

    $("#btnImage").on("click", function () {
        showGrid();
    });

});

function upload(){
    cat = $("#ddlImageCategory").val();
    if (cat == ''){
        $("#rqrdAssignedTo").css('visibility', 'visible');
        return;
    } else{
        $("#rqrdAssignedTo").css('visibility', 'hidden');
    }
	if ($("#image").get(0).files.length > 0) {
		fdata = new FormData();
		fdata.append('category', cat);
        
        file = $("#image").get(0).files[0];
        fdata.append('image', file, file.name);

        showLoading();

        $.ajax({
            url : '/fajax/business/uploadgalleryimage',
            type : 'post',
            dataType : 'json',
            contentType: false,
            processData: false,
            success: function(data){
                hideLoading();
                if (data.success == 'true'){
                    $("#images").html(data.html);
                    showGrid();
                } else{
                    showErrorToast(data.message);
                }
            },
            data : fdata
        });
	} else{
        alert('Choose file to upload');
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


function showFields(){
    $("#pnlUpdate").slideUp();
    $("#AddImageBox").slideDown();
}

function showGrid(){
    $("#pnlUpdate").slideDown();
    $("#AddImageBox").slideUp();
}

function setCategory(){
    cat = $("#ddlFilterByCategory").val();
    $.ajax({
        url: '/fajax/gallery/setcategory/' + cat,
        type: 'get',
        success:function(){
            location.reload();
        }
    });
}