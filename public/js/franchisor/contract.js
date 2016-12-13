$(document).ready(function () {            
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        //maxDate: "+0",
        defaultDate: "+0",
        readOnly: true
    });

    $('.Box :first-child').click(function () {
        $('.Box :first-child').prop('checked', '');
        this.checked = true;
    });

    $('.Box2 :first-child').click(function () {
        $('.Box2 :first-child').prop('checked', '');
        this.checked = true;
    });

    $('.Box3 :first-child').click(function () {
        $('.Box3 :first-child').prop('checked', '');
        this.checked = true;
    });
});

function refreshCategory(suffix){
    if(typeof suffix == "undefined")
        suffix = '';

	var selIndex = $("#ddlGroup" + suffix)[0].selectedIndex - 1;
	$("#ddlCategory" + suffix).empty();
    addItemTo("ddlCategory" + suffix, "", "Select a category");
    if (categories[selIndex].length == 0){
        $("#ddlCategory" + suffix).attr('disabled', 'disabled');
    } else{
        $("#ddlCategory" + suffix).removeAttr('disabled');
        $.each(categories[selIndex].categories, function (i, item) {
            addItemTo('ddlCategory' + suffix, item.value, item.name);
        });
    }
}

function refreshSubCategory(suffix){
    if(typeof suffix == "undefined")
        suffix = '';

	var selGroupIndex = $("#ddlGroup" + suffix)[0].selectedIndex - 1;
	var selIndex = $("#ddlCategory" + suffix)[0].selectedIndex - 1;
	$("#ddlSubCategory" + suffix).empty();
    if (categories[selGroupIndex].categories.length == 0){
        $("#ddlSubCategory" + suffix).attr('disabled', 'disabled');
    } else{
        $("#ddlSubCategory" + suffix).removeAttr('disabled');
        if (categories[selGroupIndex].categories[selIndex].subCategories == undefined){
            return;
        }
        $.each(categories[selGroupIndex].categories[selIndex].subCategories, function (i, item) {
            addItemTo('ddlSubCategory' + suffix, item.value, item.name);
        });
    }
}

function addItemTo(targetId, val, txt){
    $('#' + targetId).append($('<option>', {
        value: val,
        text: txt
    }));
}

function submit(){
	var params = validate();
	if (params === false){
		return;
	}
	$.ajax({
            url : '/fajax/savecontract/' + bId,
            type : 'post',
	        dataType : 'json',
	        success: function(data){
                if (data.success == 'true'){
                    location.replace('/franchise_contract/' + bId);
                } else{
                    showErrorToast(data.message);
                }
            },
            data : params
        });
}

function sendEmail(){
	$.ajax({
            url : '/fajax/emailcontract/' + bId,
            type : 'get',
	        dataType : 'json',
	        success: function(data){
                if (data.success == 'true'){
                    showSuccessToast(data.message);
                } else{
                    showErrorToast(data.message);
                }
            }
        });
}

function validate(){
    var elVip = $("#vip");
    var elPromo = $("#promo");
	if (elVip.attr('checked') == undefined && elPromo.attr('checked') == undefined){
        showErrorToast("Promo or VIP needs to be selected.");
        return false;
    }
    if (elVip.attr('checked') == 'checked' && elPromo.attr('checked') == 'checked'){
        showErrorToast("You can't select both VIP or Promo.");
        return false;
    }

	var param = {};
	param.businessId = bId;
	param.name = $("#txt_BusinessName").val();
	param.email = $("#txt_Email").val();
	param.website = $("#txt_Website").val();
	param.effectiveDate = $("#txt_EffectiveDate").val();
	param.address = $("#txt_Address").val();
	param.city = $("#txt_City").val();
	param.state = $("#ddlState").val();
	param.zip = $("#txt_Zip").val();
	param.phone = $("#txt_Phone").val();
	param.fax = $("#txt_Fax").val();
	param.authorizedRep = $("#txt_AuthorizedRep").val();
	param.repTitle = $("#txt_Title").val();
    param.subCatId = $("#ddlSubCategory").val();
	param.subCatId2 = $("#ddlSubCategory2").val();
	param.additionalInstructions = $("#txt_AdditionalInstructions").val();
	param.initialCoupon = $("#txt_InitialDiscount").val();
	param.averageTransaction = $("#txt_AvgTransaction").val();
	param.averageDeterminedValue = $("#txt_AvgValue").val();
	param.visibleOnWebsite = $("#txt_StartDate").val();
	param.paymentDueDate = $("#txt_NextPaymentDate").val();
	param.vip = elVip.attr('checked') == 'checked' ? 1 : 0;
	param.promo = elPromo.attr('checked') == 'checked' ? 1 : 0;
	if ($("#ch_AutoCard").attr('checked') != undefined)
		param.paymentType = 'Auto Draft Credit/Debt Card';
	else if ($("#ch_AutoDraft").attr('checked') != undefined)
		param.paymentType = 'Auto Bank Draft';
	else if ($("#ch_FullCash").attr('checked') != undefined)
		param.paymentType = 'Paid in Full Cash basis';
	param.businessMemberSignature = $("#hf_EncodedSig1").val();
	param.topTenRepSignature = $("#hf_EncodedSig2").val();
	if ($("#cbxMonthly").attr('checked') != undefined)
		param.membershipType = 'Monthly';
	else if ($("#cbxAnnualy").attr('checked') != undefined)
		param.membershipType = 'Annualy';
	param.membershipFee = $("#txt_MemberFee").val();
	param.initialFeeType = "Activation";
	param.fee = $("#txt_ActivationFee").val();
	param.other1 = $("#txt_Other").val();
	param.other2 = $("#txt_Other2").val();
	param.note = $("#txt_Note").val();
	param.totalDueNow = $("#txt_DueNow").val();
	param.onGoingMonthlyFee = $("#txt_MonthlyFee").val();
	return param;
}