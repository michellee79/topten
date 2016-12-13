function submitRating(){
	comment = $('#txtComment').val();
	rating = 0;
	$(".fields input[type=radio]").each(function(index){
		if ($(this).attr('checked') == 'checked')
		{
			rating = index + 1;
			return;
		}
	});
	_submit(comment, rating, false);
}

function submitRatingMobile(){
	comment = $('#txtCommentMobile').val();
	rating = $("#ddlRatingsMobile").val();
	_submit(comment, rating, true);
}

function _submit(comment, rating, mobile){
	$.ajax({
		url : '/ajax/addreview',
		type : 'post',
		dataType : 'json',
		success: function(data){
			hideLoading();
			if (data.success == 'true'){
				if (mobile){
					$("#repeaterMobile").html(data.renderMobile);
					showGridMobile();
				} else{
					$("#repeater").html(data.render);
					showGrid();
				}
				showSuccessToast(data.message);
			} else{
				showErrorToast(data.message);
			}
		},
		data : {
			bid: businessId,
			rating: rating,
			comment: comment
		}
	});
}