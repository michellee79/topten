function deleteBusiness(bId){
	r = confirm("Do you want to delete this business?");
	if (r == false){
		return;
	}
	$.ajax({
        url: '/fajax/removebusiness/' + bId,
            type: 'get',
            dataType: 'json',
            success: function(data){
                if (data.success == 'true'){
                	showSuccessToast(data.message);
                    location.reload();
                } else{
                    showErrorToast(data.message);
                }
            }
        });
}