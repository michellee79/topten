var selPromoId;
var editing = false;

$(document).ready(function(){
	
});

$(document).keyup(function(e){
	if (e.keyCode == 27 && editing)
		hideEdit();
});

function showEdit(sender){
	$(sender).css('display', 'none');
	pElem = $(sender).parent('td');
	selPromoId = sender.id;
	w = pElem.outerWidth(); h=pElem.outerHeight();
	pElem.append('<input class="promoEditor" type="text" />');
	$(".promoEditor").val($(sender).text());
	$(".promoEditor").css('width', w - 4);
	$(".promoEditor").css('height', h - 2);
	$(".promoEditor").focus();
	editing = true;
	$(".promoEditor").blur(function(){
		submitEdit();
	});
	$(".promoEditor").bind('keypress', function(e){
		var code = e.keyCode || e.which;
		if (code == 13){
			submitEdit();
		}
	});
}

function submitEdit(){
	pid = selPromoId.substring(6);
	showLoading();
	$.ajax({
            url : '/fajax/savepromo/' + pid,
            type : 'post',
	        dataType : 'json',
	        success: function(data){
	        	hideLoading();
                if (data.success == 'true'){
                    showSuccessToast('Changed Successfully');
                    $(".promoEditor").parent('td').find('a').text(data.name);
                } else{
                    showErrorToast(data.message);
                }
                hideEdit();
            },
            data : {
            	name: $(".promoEditor").val()
            }
        });
}

function submitCreate(){
	params = validate();
	$.ajax({
            url : '/fajax/addpromo',
            type : 'post',
	        dataType : 'json',
	        success: function(data){
	        	hideLoading();
                if (data.success == 'true'){
                    location.reload();
                } else{
                    showErrorToast(data.message);
                }
                hideEdit();
            },
            data : params
        });
}

function validate(){
	params = {};
	code = $("#txtCode").val();
	if (code == ''){
		$("#rqrdCode").css('visibility','visible');
		return false;
	} else{
		params.code = code;
		$("#rqrdCode").css('visibility','hidden');
	}
	assignedTo = $("#txtAssignedTo").val();
	if (assignedTo == ''){
		$("#rqrdAssignedTo").css('visibility', 'visible');
		return false;
	} else{
		params.assignedTo = assignedTo;
		$("#rqrdAssignedTo").css('visibility', 'hidden');
	}
	if ($("#cbxRequireActivationEmail").attr('checked') == undefined)
		params.requireActivation = 0;
	else 
		params.requireActivation = 1;
	return params;
}

function togglePromoNeedActivation(sender, pid){
	showLoading();
	$.ajax({
        url : '/fajax/promo/toggleneedactivation/' + pid,
        type : 'get',
        dataType : 'json',
        success: function(data){
        	hideLoading();
            if (data.success == 'true'){
                $(sender).html(data.requireActivation);
            } else{
                showErrorToast(data.message);
            }
        }
    });
}

function togglePromoActivation(sender, pid){
	showLoading();
	$.ajax({
        url : '/fajax/promo/toggleactivation/' + pid,
        type : 'get',
        dataType : 'json',
        success: function(data){
        	hideLoading();
            if (data.success == 'true'){
                $(sender).html(data.isActive);
            } else{
                showErrorToast(data.message);
            }
        }
    });
}

function deletePromo(sender, pid){
	if (confirm('Are you sure to delete this coupon?') == false)
		return;
	showLoading();
	$.ajax({
        url : '/fajax/promo/delete/' + pid,
        type : 'get',
        dataType : 'json',
        success: function(data){
        	hideLoading();
            if (data.success == 'true'){
                $(sender).closest('tr').remove();
            } else{
                showErrorToast(data.message);
            }
        }
    });
}

function hideEdit(){
	$(".promoEditor").parent('td').find('a').css('display', 'block');
	$(".promoEditor").remove();
	editing = false;
}

function showFields(){
	$(".grid").slideUp();
	$(".fields").slideDown();
}

function hideFields(){
	$(".fields").slideUp();
	$(".grid").slideDown();
}

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}