
function nominate(again){
	name = $("#businessName").val();
	city = $("#businessCity").val();
	state = $("#ddlState").val();
	phone = $("#businessPhone").val();
	firstname = $("#firstName").val();
	lastname = $("#lastName").val();
	email = $("#txtEmail").val();
	reason = $("#reason").val();

    _submit(name, city, state, phone, firstname, lastname, email, reason, again);
}

function _submit(name, city, state, phone, firstname, lastname, email, reason, again){
	if (validate(name, city, state, firstname, lastname, email, reason)){
		showLoading();
		$.ajax({
			url : '/ajax/nominatebusiness',
				type: 'post',
				dataType: 'json',
				success: function(data){
					if (data.success == 'true'){
						if (again){
							showSuccessToast('Successfully nominated a business.');
							_clearInput();
							hideLoading();
							if (data.count > 2 && data.guest){
								$("#completeEnrollmentModal").modal({fadeDuration: 100});
							}
							$("#businessNum").val(data.count);

						} else{
							if (data.guest){
                                hideLoading();
                                showSuccessToast('Successfully nominated a business.');
                                $("#completeEnrollmentModal").modal({fadeDuration: 100});
                                $("#completeEnrollmentModal").on('dialogclosed', function(){
                                    window.location = "/page/Nomination%20Submitted";
                                });
                                $(".blocker").on('click', function(){
                                    window.location = "/page/Nomination%20Submitted";
                                });
							} else {
								window.location = "/page/Nomination%20Submitted";
							}
						}
					} else{
						showErrorToast(data.message);
						hideLoading();
					}
				},
				data: {
					bname: name,
					bcity: city,
					bstate: state,
					bphone: phone,
					fname: firstname, 
					lname: lastname, 
					mail: email,
					feel: reason
				}
			});
	} else {
		alert('Input all values. (Phone number is optional)');
	}
}

function _clearInput(){
	$("#firstName").val('');
	$("#lastName").val('');
	$("#txtEmail").val('');
	$("#businessName").val('');
	$("#businessPhone").val('');
	$("#reason").val('');
}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function validate(name, city, state, firstname, lastname, email, reason){
	var f = true;
	if (name == ''){
		f = false;
		$("#businessNameRequired").css('visibility', 'visible');
	} else{
		$("#businessNameRequired").css('visibility', 'hidden');
	}
	if (firstname == ''){
		f = false;
		$("#firstNameRequired").css('visibility', 'visible');
	} else{
		$("#firstNameRequired").css('visibility', 'hidden');
	}
	if (lastname == ''){
		f = false;
		$("#lastNameRequired").css('visibility', 'visible');
	} else{
		$("#lastNameRequired").css('visibility', 'hidden');
	}
	if (city == ''){
		f = false;
		$("#cityRequired").css('visibility', 'visible');
	} else{
		$("#cityRequired").css('visibility', 'hidden');
	}
	if (state == ''){
		f = false;
		$("#stateRequired").css('visibility', 'visible');
	} else{
		$("#stateRequired").css('visibility', 'hidden');
	}
	if (email == ''){
		f = false;
		$("#emailRequired").css('visibility', 'visible');
	} else{
		$("#emailRequired").css('visibility', 'hidden');
		if (validateEmail(email)){
			$("#revEmail").css('visibility', 'hidden');
		} else{
			$("#revEmail").css('visibility', 'visible');
			f = false;
		}
	}
	return f;
}