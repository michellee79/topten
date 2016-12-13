function registerWithPromo(suffix){
	promoCode = $("#promoCode" + suffix).val();
	firstName = $("#firstname" + suffix).val();
	lastName = $("#lastname" + suffix).val();
	zipcode = $("#zipcode" + suffix).val();
	mail = $("#email" + suffix).val();
	pswd = $("#password" + suffix).val();
	pswdAgain = $("#passwordAgain" + suffix).val();

	if (validate_promo(promoCode, firstName, lastName, zipcode, mail, pswd, pswdAgain, suffix)){
		
		showLoading(suffix);

		$.ajax({
			url : '/ajax/registerwithpromo',
			type : 'post',
			dataType : 'json',
			success: function(data){
				if (data.success == 'true'){
					if (data.redirect == ''){
						location.reload();
					} else{
						showSuccessToast(data.message);
						location.replace('/');
					}
				} else{
					showErrorToast(data.message);
				}
				hideLoading(suffix);
			},
			data : {
				promo: promoCode,
				fname: firstName,
				lname: lastName,
				zipcode: zipcode,
				email: mail,
				password: pswd
			}
		});
	}
}

function registerFromNomination(suffix) {
    firstName = $("#firstname" + suffix).val();
    lastName = $("#lastname" + suffix).val();
    zipcode = $("#zipcode" + suffix).val();
    mail = $("#email" + suffix).val();
    pswd = $("#password" + suffix).val();
    pswdAgain = $("#passwordAgain" + suffix).val();

    if(validate_register(firstName, lastName, zipcode, mail, pswd, pswdAgain, suffix))
    {
        showLoading(suffix);

        $.ajax({
            url : '/ajax/registerfromnomination',
            type : 'post',
            dataType : 'json',
            success: function(data){
                if (data.success == 'true'){
                    showSuccessToast(data.message);
                    location.replace('/');
                } else{
                    showErrorToast(data.message);
                }
                hideLoading(suffix);
            },
            data : {
                fname       : firstName,
                lname       : lastName,
                zip         : zipcode,
                email       : mail,
                password    : pswd
            }
        });
    }
}

function registerWithNomination(suffix){
	firstName = $("#firstname" + suffix).val();
	lastName = $("#lastname" + suffix).val();
	zipcode = $("#zipcode" + suffix).val();
	mail = $("#email" + suffix).val();
	pswd = $("#password" + suffix).val();
	pswdAgain = $("#passwordAgain" + suffix).val();

	name1 = $("#businessName1" + suffix).val();
	city1 = $("#businessCity1" + suffix).val();
	state1 = $("#ddlBusinessState1" + suffix).val();
	phone1 = $("#businessPhone1" + suffix).val();
	reason1 = $("#reason1" + suffix).val();

	name2 = $("#businessName2" + suffix).val();
	city2 = $("#businessCity2" + suffix).val();
	state2 = $("#ddlBusinessState2" + suffix).val();
	phone2 = $("#businessPhone2" + suffix).val();
	reason2 = $("#reason2" + suffix).val();

	if (validate_register_nominate(firstName, lastName, zipcode, mail, pswd, pswdAgain, name1, city1, state1, phone1, reason1, name2, city2, state2, phone2, suffix)){

		showLoading(suffix);

		$.ajax({
			url : '/ajax/registerwithnomination',
			type : 'post',
			dataType : 'json',
			success: function(data){
				if (data.success == 'true'){
					showSuccessToast(data.message);
					location.replace('/');
				} else{
					showErrorToast(data.message);
				}
				hideLoading(suffix);
			},
			data : {
				fname       : firstName,
				lname       : lastName,
				zip         : zipcode,
				email       : mail,
				password    : pswd,
                bname1      : name1,
                bcity1      : city1,
                bstate1     : state1,
                bphone1     : phone1,
                breason1    : reason1,
                bname2      : name2,
                bcity2      : city2,
                bstate2     : state2,
                bphone2     : phone2,
                breason2    : reason2
			}
		});
	}
}

function validate_promo(promoCode, firstName, lastName, zipcode, mail, pswd, pswdAgain, suffix){

	result = true;

	if (promoCode == ''){
		result = false;
		$("#promoRequired" + suffix).css('visibility', 'visible');
	} else{
		$("#promoRequired" + suffix).css('visibility', 'hidden');
	}
	if (firstName == ''){
		result = false;
		$("#nameRequired" + suffix).css('visibility', 'visible');
	} else{
		if (lastName == ''){
			result = false;
			$("#nameRequired" + suffix).css('visibility', 'visible');
		} else{
			$("#nameRequired" + suffix).css('visibility', 'hidden');
		}
	}
	if (zipcode == ''){
		result = false;
		$("#zipcodeRequired" + suffix).css('visibility', 'visible');
	} else{
		$("#zipcodeRequired" + suffix).css('visibility', 'hidden');
	}
	if (mail == ''){
		result = false;
		$("#emailRequired" + suffix).css('visibility', 'visible');
	} else{
		$("#emailRequired" + suffix).css('visibility', 'hidden');
		if (validateEmail(mail)){
			$("#revEmail" + suffix).css('visibility', 'hidden');
		} else{
			$("#revEmail" + suffix).css('visibility', 'visible');
			result = false;
		}
	}
	if (pswd == ''){
		result = false;
		$("#passwordRequired" + suffix).css('visibility', 'visible');
	} else{
		$("#passwordRequired" + suffix).css('visibility', 'hidden');
	}
	if (pswdAgain == ''){
		result = false;
		$("#passwordAgainRequired" + suffix).css('visibility', 'visible');
	} else{
		$("#passwordAgainRequired" + suffix).css('visibility', 'hidden');
		if (pswd == pswdAgain){
			$("#revPasswordAgain" + suffix).css('visibility', 'hidden');
		} else{
			result = false;
			$("#revPasswordAgain" + suffix).css('visibility', 'visible');
		}
	}

    return result;
}

function validate_register_nominate(firstName, lastName, zipcode, mail, pswd, pswdAgain, name1, city1, state1, reason1, name2, city2, state2, reason2, suffix){

	var result = true;
    result = validate_register(firstName, lastName, zipcode, mail, pswd, pswdAgain, suffix);

	if (name1 == ''){
		result = false;
		$("#businessName1Required" + suffix).css('visibility', 'visible');
	} else{
		$("#businessName1Required" + suffix).css('visibility', 'hidden');
	}
	if (city1 == ''){
		result = false;
		$("#businessCity1Required" + suffix).css('visibility', 'visible');
	} else{
		$("#businessCity1Required" + suffix).css('visibility', 'hidden');
	}
	if (state1 == ''){
		result = false;
		$("#businessState1Required" + suffix).css('visibility', 'visible');
	} else{
		$("#businessState1Required" + suffix).css('visibility', 'hidden');
	}
	if (reason1 == ''){
		result = false;
		$("#reason1Required" + suffix).css('visibility', 'visible');
	} else{
		$("#reason1Required" + suffix).css('visibility', 'hidden');
	}

	if (name2 == ''){
		result = false;
		$("#businessName2Required" + suffix).css('visibility', 'visible');
	} else{
		$("#businessName2Required" + suffix).css('visibility', 'hidden');
	}
	if (city2 == ''){
		result = false;
		$("#businessCity2Required" + suffix).css('visibility', 'visible');
	} else{
		$("#businessCity2Required" + suffix).css('visibility', 'hidden');
	}
	if (state2 == ''){
		result = false;
		$("#businessState2Required" + suffix).css('visibility', 'visible');
	} else{
		$("#businessState2Required" + suffix).css('visibility', 'hidden');
	}
	if (reason2 == ''){
		result = false;
		$("#reason2Required" + suffix).css('visibility', 'visible');
	} else{
		$("#reason2Required" + suffix).css('visibility', 'hidden');
	}

    return result;
}

function validate_register(firstName, lastName, zipcode, mail, pswd, pswdAgain, suffix) {
    var result = true;
    if (firstName == ''){
        result = false;
        $("#nameRequired" + suffix).css('visibility', 'visible');
    } else{
        if (lastName == ''){
            result = false;
            $("#nameRequired" + suffix).css('visibility', 'visible');
        } else{
            $("#nameRequired" + suffix).css('visibility', 'hidden');
        }
    }
    if (zipcode == ''){
        result = false;
        $("#zipcodeRequired" + suffix).css('visibility', 'visible');
    } else{
        $("#zipcodeRequired" + suffix).css('visibility', 'hidden');
    }
    if (mail == ''){
        result = false;
        $("#emailRequired" + suffix).css('visibility', 'visible');
    } else{
        $("#emailRequired" + suffix).css('visibility', 'hidden');
        if (validateEmail(mail)){
            $("#revEmail" + suffix).css('visibility', 'hidden');
        } else{
            $("#revEmail" + suffix).css('visibility', 'visible');
            result = false;
        }
    }
    if (pswd == ''){
        result = false;
        $("#passwordRequired" + suffix).css('visibility', 'visible');
    } else{
        $("#passwordRequired" + suffix).css('visibility', 'hidden');
    }
    if (pswdAgain == ''){
        result = false;
        $("#passwordAgainRequired" + suffix).css('visibility', 'visible');
    } else{
        $("#passwordAgainRequired" + suffix).css('visibility', 'hidden');
        if (pswd == pswdAgain){
            $("#revPasswordAgain" + suffix).css('visibility', 'hidden');
        } else{
            result = false;
            $("#revPasswordAgain" + suffix).css('visibility', 'visible');
        }
    }

    return result;
}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function showLoading(suffix) {
	$('#regFormContainer' + suffix).showLoading();
}

function hideLoading(suffix) {
	$('#regFormContainer' + suffix).hideLoading();
}