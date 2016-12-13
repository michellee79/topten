$(document).ready(function () {                        
	$(".sideTabHover").hover(function () {
		//Hover Over
		//$(this).parent().animate({marginLeft: 0}, 200);
		$(this).animate({marginLeft: 0}, 200);
	}, function () {
		//Hover Out
		//$(this).parent().animate({ marginLeft: -7 }, 200);
		$(this).animate({ marginLeft: -10 }, 200);
	});
});

function openDefineUserLocation() {
	$(document).ready(function () {
		$("#DefineUserLocationModal").overlay({ mask: '#999', closeOnEsc: false, closeOnClick: false });
		$("#DefineUserLocationModal").overlay().load();
	});
}

function closeDefineUserLocation() {
	$('#DefineUserLocationModal').overlay().close();
}

function showLoading() {
	$('#DefineUserLocationModal').showLoading();
}

function hideLoading() {
	$('#DefineUserLocationModal').hideLoading();
}

$(document).ready(function () {

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	
	$(".txtLocation").autocomplete("/ajax/getlocations", {
		delay: 10,
		minChars: 3,
		matchSubset: 1,
		matchContains: 1
	});
});

function login(){
	username = $('#UserName').val();
	pswd = $('#Password').val();
	f = false;
	if (username == '')
	{
		$("#nameRequired").css('visibility', 'visible');
		f = true;
	} else{
		$("#nameRequired").css('visibility', 'hidden');
	}
	if (pswd == ''){
		$("#passwordRequired").css('visibility', 'visible');
		f = true;
	} else{
		$("#passwordRequired").css('visibility', 'hidden');
	}

	if (f)
		return false;

	showLoading();
	$.ajax({
		url: '/auth/login',
		type: 'post',
		dataType: 'json',
		success: function(data){
			hideLoading();
			if (data.success == 'true'){
				closeDefineUserLocation();
			} else{
				$('.loginErrorText').html('Username or Password was incorrect!');
			}
		},
		data:{
			name: username,
			password: pswd
		}
	});
}

function nonMemberLogin(){
	l = $("#txtLocation").val();
	if (l == ''){
		$("#rqrdLocation").css('visibility', 'visible');
		return false;
	} else{
		$("#rqrdLocation").css('visibility', 'hidden');
		showLoading();
		$.ajax({
			url : '/auth/setLocationNonmember',
			type: 'post',
			dataType: 'json',
			success: function(data){
				hideLoading();
				closeDefineUserLocation();
			},
			data: {
				location: l
			}
		});
	}
}