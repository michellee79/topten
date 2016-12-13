function addToMyCoupon(){
	$ajax({
		url : '/ajax/add_to_my_coupon',
		type : 'post',
		dataType : 'json',
		success: function(data){

		},
		data : {
			cid : couponId
		}
	});
}

function removeMyCoupon(cId){

}

function showHint(){
	$("#hint").fadeIn();
}

function closeHint(){
	$("#hint").fadeOut();
}