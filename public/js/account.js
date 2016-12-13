function save(suffix){
	if (validate(suffix)){
		if (suffix == ""){
			showLoading();
		}
		firstName = $("#txtFirstName" + suffix).val();
		lastName = $("#txtLastName" + suffix).val();
		zipcode = $("#txtZipcode" + suffix).val();

		$.ajax({
			url : '/ajax/updatemyaccount',
			type : 'post',
			dataType : 'json',
			success: function(data){
				hideLoading();
				if (data.success == 'true'){
					showSuccessToast(data.message);
					$("#lblCurrentLocation").text(zipcode);
				} else{
					showErrorToast(data.message);
				}
			},
			data : {
				fname: firstName,
				lname: lastName,
				zipcode: zipcode
			}
		});
	}
}

function validate(suffix){
	firstName = $("#txtFirstName" + suffix).val();
	lastName = $("#txtLastName" + suffix).val();
	zipcode = $("#txtZipcode" + suffix).val();

	$("#requiredFirstName" + suffix).css('visibility', 'hidden');
	$("#requiredLastName" + suffix).css('visibility', 'hidden');
	$("#requiredZipcode" + suffix).css('visibility', 'hidden');
	$("#validatorZipcode" + suffix).css('visibility', 'hidden');

	result = true;

	if (firstName == "")
	{
		$("#requiredFirstName" + suffix).css('visibility', 'visible');
		result = false;
	}
	if (lastName == "")
	{
		$("#requiredLastName" + suffix).css('visibility', 'visible');
		result = false;
	}
	if (zipcode == "")
	{
		$("#requiredZipcode" + suffix).css('visibility', 'visible');
		return false;
	}

	var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(zipcode);
    if (!isValid) {
    	$("#validatorZipcode" + suffix).css('visibility', 'visible');
    	result = false;    	
    }
    return result;
}

function addToMyCoupon(mobile){
	if (mobile == false){
		showLoading();
	}
	$.ajax({
		url : '/ajax/addtomycoupon',
		type : 'post',
		dataType : 'json',
		success: function(data){
			hideLoading();
			if (data.success == 'true'){
				ga('send', 'event', 'Coupon', 'download', data.coupon);
				showSuccessToast(data.message);
			} else{
				showErrorToast(data.message);
			}
		},
		data : {
			cid : couponId
		}
	});
}

function removeMyCoupon(cId, mobile){
	if (!mobile)
		showLoading();
	$.ajax({
		url : '/ajax/removemycoupon',
		type : 'post',
		dataType : 'json',
		success: function(data){
			hideLoading();
			if (data.success == 'true'){
				if (!mobile){
					$("#MyCoupons").html(data.render);
				} else{
					$("#MyCouponsMobile").html(data.renderMobile);
				}
				showSuccessToast(data.message);
			} else{
				showErrorToast(data.message);
			}
		},
		data : {
			cid : cId
		}
	});
}

function changePassword(mobile){
	f = false;
	oldPswd = $("#currentPassword" + mobile).val();
	newPswd = $("#newPassword" + mobile).val();
	conPswd = $("#confirmPassword" + mobile).val();

	if (oldPswd == ''){
		f = true;
		$("#currentPasswordRequired" + mobile).css('visibility', 'visible');
	} else{
		$("#currentPasswordRequired" + mobile).css('visibility', 'hidden');
	}

	if (newPswd == ''){
		f = true;
		$("#newPasswordRequired" + mobile).css('visibility', 'visible');
	} else{
		$("#newPasswordRequired" + mobile).css('visibility', 'hidden');
	}

	if (conPswd == ''){
		f = true;
		$("#confirmPasswordRequired" + mobile).css('visibility', 'visible');
	} else{
		$("#confirmPasswordRequired" + mobile).css('visibility', 'hidden');
	}

	if (newPswd != conPswd){
		f = true;
		$("#newPasswordCompare" + mobile).css('visibility', 'visible');
	} else{
		$("#newPasswordCompare" + mobile).css('visibility', 'hidden');
	}

	if (f)
		return false;

	$.ajax({
		url : '/auth/changepassword',
		type : 'post',
		dataType : 'json',
		success: function(data){
			if (data.success == 'true'){
				if (mobile == ''){
					$("#regFormContainer").html(data.render);
				} else{
					$("#regFormContainerMobile").html(data.renderMobile);
				}
			} else{
				$("#error" + mobile).html(data.message)
			}
		},
		data : {
			oldPass: oldPswd,
			newPass: newPswd
		}
	});
}

function showHint(){
	$("#hint").fadeIn();
	$("#hintMobile").fadeIn();
}

function closeHint(){
	$("#hint").fadeOut();
	$("#hintMobile").fadeOut();
}