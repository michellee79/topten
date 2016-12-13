var cId;
var bId;

$(document).ready(function () {            
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        //maxDate: "+0",
        defaultDate: "+0",
        readOnly: true
    });

});

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}

function showEdit(cid){
	showLoading();
	$.ajax({
		url: '/fajax/getcoupon/' + cid,
		type: 'get',
		dataType: 'json',
		success: function(data){
			cId = cid;
			$("#lblAddOrEdit").text('Edit');
			$("#txtTitle").val(data.coupon.title);
			$("#txtDescription").val(data.coupon.description);
			$("#txtPercent").val(data.coupon.discount);
			$("#txtAverageValue").val(data.coupon.averageValue);
			$("#txtDisclaimer").val(data.coupon.disclaimer);
			hideLoading();
			showFields();
			rId = data.id;
		}
	});
}

function showCreate(){
	cId = 0;
	$("#txtTitle").val('');
	$("#txtDescription").val('');
	$("#txtPercent").val('');
	$("#txtAverageValue").val('');
	$("#txtDisclaimer").val('Not to be combined with any other offer.  One coupon per visit.  No cash redemption value. State and local laws may require sales tax to be charged on the pre-discounted price if the product is subject to sales tax.');
	$("#lblAddOrEdit").text('Add');
	showFields();
}

function showFields(){
	$('.grid').slideUp();
	$(".fields").slideDown();
}

function hideFields(){
	$(".fields").slideUp();
	$('.grid').slideDown();
}

function submit(){
	params = validate();
	if (params != false){
		showLoading();
		$.ajax({
			url: '/fajax/savecoupon/' + cId,
			type: 'post',
			dataType: 'json',
			success: function(data){
				$("#coupons").html(data.html);
				hideLoading();
				hideFields();
			},
			data: params
		});
	}
}

function validate(){
	params = {};
	flag = true;
	$(".required").each(function(index){
		idStr = $(this).attr('name');
		if ($(this).val() == ""){
			$("#" + idStr + "Required").css('visibility', 'visible');
			flag = false;
		} else{
			$("#" + idStr + "Required").css('visibility', 'hidden');
		}
	});
	params.bid = bId;
	params.id = cId;
	if (flag){
		$(".param").each(function(index){
			paramName = $(this).attr('name');
			params[paramName] = $(this).val();
		});
		return params;
	}
	return false;
}

function activateCoupon(cid){
	showLoading();
	$.ajax({
		url: '/fajax/activatecoupon/' + cid,
		type: 'get',
		dataType: 'json',
		success: function(data){
			$("#coupons").html(data.html);
			hideLoading();
		}
	});
}

function deleteCoupon(cid){
	r = confirm('Do you really want to delete this coupon?');
	if (r){
		showLoading();
		$.ajax({
			url: '/fajax/deletecoupon/' + cid,
			type: 'get',
			dataType: 'json',
			success: function(data){
				$("#coupons").html(data.html);
				hideLoading();
			}
		});
	}
}