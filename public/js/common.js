function logout(){
	$.post('/auth/logout', {}, 
		function(result){
			location.reload();
		});
}

function login(){
	username = $('#UserName').val();
	pswd = $('#Password').val();

	if (pswd == ''){
		$('#passwordRequired').css('visibility', 'visible');
	}
	if (username == ''){
		$('#nameRequired').css('visibility', 'visible');
		return;
	}

	$.ajax({
		url: '/auth/login',
		type: 'post',
		dataType: 'json',
		success: function(data){
			if (data.success == 'true'){
				location.reload();
			} else{
				$('.loginErrorText').html(data.message);
				$('#passwordRequired').css('visibility', 'hidden');
				$('#nameRequired').css('visibility', 'hidden');
			}
		},
		data:{
			name: username,
			password: pswd
		}
	});
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        //maxDate: "+0",
        defaultDate: "+0",
        readOnly: true
    });
});

function showSuccessToast(message) {
    $().toastmessage('showToast', {
        text: message,
        sticky: false,
        type: 'success',
        position: 'top-right',
        stayTime: 8000
    });
}

function showErrorToast(message) {
    $().toastmessage('showToast', {
        text: message,
        sticky: false,
        type: 'error',
        position: 'top-right',
        stayTime: 8000
    });
}

function showInfoToast(message) {
    $().toastmessage('showToast', {
        text: message,
        sticky: false,
        type: 'info',
        position: 'top-right',
        stayTime: 8000
    });
}

function setSortColumn(scope, column){
	$.ajax({
		url: '/fajax/setsortcolumn/' + scope + '/' + column,
		type: 'get',
		dataType: 'json',
		success: function(data){
			location.reload();
		}
	});
}

function toggleFilter(){
	if ($("#filter_body").css('display') == 'none'){
		$("#filter_body").slideDown();
	} else{
		$("#filter_body").slideUp();
	}
}

function setFilter(scope){
	f = document.getElementById('filter_form');
	fd = new FormData(f);
	$.ajax({
		url: '/fajax/setfilter/' + scope,
		type: 'post',
		dataType: 'json',
		processData: false,
  		contentType: false,
		success: function(data){
			location.reload();
		},
		data: fd
	});
}

function resetFilter(scope){
	$("#filter_form input[type=text]").val('');
	setFilter(scope);
}