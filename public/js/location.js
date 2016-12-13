function setLocation(mobile){
	l = $("#location" + mobile).val();
	if (l == ''){
		$("#locationRequired" + mobile).css('visibility', 'visible');
	} else{
		$("#locationRequired" + mobile).css('visibility', 'hidden');
		if (mobile == '')
			showLoading();
		$.ajax({
			url : '/ajax/setlocation',
				type: 'post',
				dataType: 'json',
				success: function(data){
					if (data.success == 'true'){
						window.location.href = "/businesses";
					}
				},
				data: {
					location: l
				}
			});
	}
}
