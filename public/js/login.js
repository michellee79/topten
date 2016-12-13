
function login(mobile){
	name = $("#userName" + mobile).val();
	pswd = $("#password" + mobile).val();
	_submit(name, pswd, mobile);
}

function _submit(username, pswd, mobile){
	if (validate(username, pswd, mobile)){
		$.ajax({
			url: '/auth/login',
			type: 'post',
			dataType: 'json',
			success: function(data){
				if (data.success == 'true'){
					if (redirect != '')
						window.location = redirect;
					else
						window.location = '/';
				} else{
					$('.loginErrorText').html(data.message);
				}
			},
			data:{
				name: username,
				password: pswd
			}
		});
	}
}

function validate(name, password, mobile){
	f = true;
	if (name == ''){
		f = false;
		$("#rfvUserName" + mobile).css('visibility', 'visible');
	} else{
		$("#rfvUserName" + mobile).css('visibility', 'hidden');
	}
	if (password == ''){
		f = false;
		$("#rfvPassword" + mobile).css('visibility', 'visible');
	} else{
		$("#rfvPassword" + mobile).css('visibility', 'hidden');
	}
	return f;
}

function verifyUsername(mobile){
	username = $("#userName" + mobile).val();
	if (username == ''){
		$("#userNameRequired" + mobile).css('visibility', 'hidden');
		return;
	}
	$.ajax({
			url: '/auth/verifyusername',
			type: 'post',
			dataType: 'json',
			success: function(data){
				if (data.success == 'true'){
					question = data.question;
					$("#question" + mobile).val(question);
					showStep2(mobile);
				} else{
					$('#lblVerifyMessage' + mobile).text('No such user');
				}
			},
			data:{
				email: username,
			}
		});
}

function verifyAnswer(mobile){
	answer = $("#answer" + mobile).val();
	$.ajax({
			url: '/auth/verifyanswer',
			type: 'post',
			dataType: 'json',
			success: function(data){
				if (data.success == 'true'){
					showStep3(mobile);
				} else{
					$('#lblMessage' + mobile).text('Wrong Answer');
				}
			},
			data:{
				email: $("#userName" + mobile).val(),
				question: $("#question" + mobile).val(),
				answer: $("#answer" + mobile).val()
			}
		});
}

function showStep2(mobile){
	$("#step1" + mobile).slideUp();
	$("#step2" + mobile).slideDown();
}

function showStep3(mobile){
	$("#step2" + mobile).slideUp();
	$("#step3" + mobile).slideDown();
}

