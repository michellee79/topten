var bsid;

$(document).ready(function () {
	calculate();
    loadSliders();
});

function showLoading() {
    $('.pgContainer').showLoading();
}

function hideLoading() {
    $('.pgContainer').hideLoading();
}

function openScoreModal() {
    $("#scoreModal").overlay({ mask: '#999', closeOnEsc: false, closeOnClick: false });
    $("#scoreModal").overlay().load();
}

function closeScoreModal() {
    $("#scoreModal").overlay().close();
}

function calculate() {
    $('#lblTotalResult').text(parseInt($('#lbl_Inspection').text()) + parseInt($('#lbl_Interview').text())
        + parseInt($('#lbl_Mission').text()) + parseInt($('#lbl_Community').text())
        + parseInt($('#lbl_Achievement').text()) + parseInt($('#lbl_Years').text())
        + parseInt($('#lbl_BBB').text()) + parseInt($('#lbl_Review').text())
       + parseInt($('#lbl_Chamber').text())
        );
}

function loadSliders() {                        
    $('#close').click(function () {
        $('.tHide').hide();
    }
    );
    $('.tt').click(function () {
        $('.tHide').show();
        $('#ttTitle').text(this.getAttribute('data-title'));
        $('#ttContent').text(this.getAttribute('data-content'));
    });
                

    $("#slider_Inspection").slider(
    {
        min: -10,
        max: 25,
        step: 1,
        value: $("#lbl_Inspection").html(),
        slide: function (event, ui) {
            $("#lbl_Inspection").html(ui.value);
            $("#hf_lbl_Inspection").val(ui.value);
        }
    });


    $("#slider_Interview").slider(
    {
        min: -10,
        max: 25,
        step: 1,
        value: $("#lbl_Interview").html(),
        slide: function (event, ui) {
            $("#lbl_Interview").html(ui.value);
            $("#hf_lbl_Interview").val(ui.value);
        }
    });


    $("#slider_Mission").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: $("#lbl_Mission").html(),
        slide: function (event, ui) {
            $("#lbl_Mission").html(ui.value);
            $("#hf_lbl_Mission").val(ui.value);
        }
    });

    $("#slider_Community").slider(
    {
        min: 0,
        max: 10,
        step: 1,
        value: $("#lbl_Community").html(),
        slide: function (event, ui) {
            $("#lbl_Community").html(ui.value);
            $("#hf_lbl_Community").val(ui.value);
        }
    });

    $("#slider_Achievement").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: $("#lbl_Achievement").html(),
        slide: function (event, ui) {
            $("#lbl_Achievement").html(ui.value);
            $("#hf_lbl_Achievement").val(ui.value);
        }
    });

    $("#slider_Years").slider(
    {
        min: -10,
        max: 10,
        step: 1,
        value: $("#lbl_Years").html(),
        slide: function (event, ui) {
            $("#lbl_Years").html(ui.value);
            $("#hf_lbl_Years").val(ui.value);
        }
    });

    $("#slider_BBB").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: $("#lbl_BBB").html(),
        slide: function (event, ui) {
            $("#lbl_BBB").html(ui.value);
            $("#hf_lbl_BBB").val(ui.value);
        }
    });

    $("#slider_Review").slider(
    {
        min: -10,
        max: 10,
        step: 1,
        value: $("#lbl_Review").html(),
        slide: function (event, ui) {
            $("#lbl_Review").html(ui.value);
            $("#hf_lbl_Review").val(ui.value);
        }
    });

    $("#slider_Chamber").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: $("#lbl_Chamber").html(),
        slide: function (event, ui) {
            $("#lbl_Chamber").html(ui.value);
            $("#hf_lbl_Chamber").val(ui.value);                    
        }
    });

}

function setSliderVal(s1, s2, s3, s4, s5, s6, s7, s8, s9) {            
    $("#slider_Inspection").slider(
    {
        min: -10,
        max: 25,
        step: 1,
        value: s1,
        slide: function (event, ui) {
            $("#lbl_Inspection").html(ui.value);
            $("#hf_lbl_Inspection").val(ui.value);
        }
    });


    $("#slider_Interview").slider(
    {
        min: -10,
        max: 25,
        step: 1,
        value: s2,
        slide: function (event, ui) {
            $("#lbl_Interview").html(ui.value);
            $("#hf_lbl_Interview").val(ui.value);
        }
    });


    $("#slider_Mission").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: s3,
        slide: function (event, ui) {
            $("#lbl_Mission").html(ui.value);
            $("#hf_lbl_Mission").val(ui.value);
        }
    });

    $("#slider_Community").slider(
    {
        min: 0,
        max: 10,
        step: 1,
        value: s4,
        slide: function (event, ui) {
            $("#lbl_Community").html(ui.value);
            $("#hf_lbl_Community").val(ui.value);
        }
    });

    $("#slider_Achievement").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: s5,
        slide: function (event, ui) {
            $("#lbl_Achievement").html(ui.value);
            $("#hf_lbl_Achievement").val(ui.value);
        }
    });

    $("#slider_Years").slider(
    {
        min: -10,
        max: 10,
        step: 1,
        value: s6,
        slide: function (event, ui) {
            $("#lbl_Years").html(ui.value);
            $("#hf_lbl_Years").val(ui.value);
        }
    });

    $("#slider_BBB").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: s7,
        slide: function (event, ui) {
            $("#lbl_BBB").html(ui.value);
            $("#hf_lbl_BBB").val(ui.value);
        }
    });

    $("#slider_Review").slider(
    {
        min: -10,
        max: 10,
        step: 1,
        value: s8,
        slide: function (event, ui) {
            $("#lbl_Review").html(ui.value);
            $("#hf_lbl_Review").val(ui.value);
        }
    });

    $("#slider_Chamber").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: s9,
        slide: function (event, ui) {
            $("#lbl_Chamber").html(ui.value);
            $("#hf_lbl_Chamber").val(ui.value);
        }
    });

}


function setSliderValClose(s1, s2, s3, s4, s5, s6, s7, s8, s9) {
    $("#slider_Inspection").slider(
    {
        min: -10,
        max: 25,
        step: 1,
        value: s1,
        slide: function (event, ui) {
            $("#lbl_Inspection").html(ui.value);
            $("#hf_lbl_Inspection").val(ui.value);
        }
    });
    $("#lbl_Inspection").html(s1);


    $("#slider_Interview").slider(
    {
        min: -10,
        max: 25,
        step: 1,
        value: s2,
        slide: function (event, ui) {
            $("#lbl_Interview").html(ui.value);
            $("#hf_lbl_Interview").val(ui.value);
        }
    });
    $("#lbl_Interview").html(s2);


    $("#slider_Mission").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: s3,
        slide: function (event, ui) {
            $("#lbl_Mission").html(ui.value);
            $("#hf_lbl_Mission").val(ui.value);
        }
    });
    $("#lbl_Mission").html(s3);

    $("#slider_Community").slider(
    {
        min: 0,
        max: 10,
        step: 1,
        value: s4,
        slide: function (event, ui) {
            $("#lbl_Community").html(ui.value);
            $("#hf_lbl_Community").val(ui.value);
        }
    });
    $("#lbl_Community").html(s4);

    $("#slider_Achievement").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: s5,
        slide: function (event, ui) {
            $("#lbl_Achievement").html(ui.value);
            $("#hf_lbl_Achievement").val(ui.value);
        }
    });
    $("#lbl_Achievement").html(s5);

    $("#slider_Years").slider(
    {
        min: -10,
        max: 10,
        step: 1,
        value: s6,
        slide: function (event, ui) {
            $("#lbl_Years").html(ui.value);
            $("#hf_lbl_Years").val(ui.value);
        }
    });
    $("#lbl_Years").html(s6);

    $("#slider_BBB").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: s7,
        slide: function (event, ui) {
            $("#lbl_BBB").html(ui.value);
            $("#hf_lbl_BBB").val(ui.value);
        }
    });
    $("#lbl_BBB").html(s7);

    $("#slider_Review").slider(
    {
        min: -10,
        max: 10,
        step: 1,
        value: s8,
        slide: function (event, ui) {
            $("#lbl_Review").html(ui.value);
            $("#hf_lbl_Review").val(ui.value);
        }
    });
    $("#lbl_Review").html(s8);

    $("#slider_Chamber").slider(
    {
        min: 0,
        max: 5,
        step: 1,
        value: s9,
        slide: function (event, ui) {
            $("#lbl_Chamber").html(ui.value);
            $("#hf_lbl_Chamber").val(ui.value);
        }
    });
    $("#lbl_Chamber").html(s9);


    $('#scoreModal').hide();
    $('#exposeMask').hide();
    hideLoading();
}

function refreshProceedButton(){
	if ($("#cbxNomination").attr('checked') == 'checked' && $("#cbxInsurance").attr('checked') == 'checked'){
		$("#btnProceed").removeAttr('disabled');
	} else{
		$("#btnProceed").attr('disabled', 'disabled');
	}
}

function validate(){
	params = {};
	flag = true;
	$(".param").each(function(index){
		idStr = $(this).attr('name');
		if ($(this).val() == ""){
			$("#" + idStr + "Required").css('visibility', 'visible');
			flag = false;
		} else{
			$("#" + idStr + "Required").css('visibility', 'hidden');
			params[idStr] = $(this).val();
		}
	});
    if ($("#tbBusinessContactName2").val() == '' || $("#tbBusinessContactName").val() == ''){
        flag = false;
        $("#businessContactNameRequired").css('visibility', 'visible');
    } else {
        params['businessContactName2'] = $("#tbBusinessContactName2").val();
        $("#businessContactNameRequired").css('visibility', 'hidden');
    }
	if (flag){
		return params;
	}
	return false;
}

function proceed(){
	params = validate();
	if (params === false)
		return;
	showLoading();
	$.ajax({
            url : '/business-criteria/' + bId,
            type : 'post',
	        dataType : 'json',
	        success: function(data){
                if (data.success == 'true'){
                	bId = data.id;
                    location.replace('/business-criteria/' + bId);
                }
            },
            data : params
        });
}

function submit(){
	params = validate();
	$.ajax({
            url : '/business-criteria/' + bId,
            type : 'post',
	        dataType : 'json',
	        success: function(data){
                if (data.success == 'true'){
                	if (data.sum >= 75){
                		$("#lblTitle").text('Congratulations');
                		$("#lblDescription").text('Your company meets or exceeds the required selection criteria of Top Tep Percent.');
                        $("#lbAdd").css('display', 'inline');
                	} else{
                		$("#lblTitle").text('Sorry');
                		$("#lblDescription").text('Your company does not qualify or meet the required selection criteria of Top Tep Percent.');
                        $("#lbAdd").css('display', 'none');
                	}
                	$("#lblScore").text(data.sum);
                	$("#lblTotalResult").text("Total " + data.sum + " points");
                	openScoreModal();
                }
            },
            data : params
        });
}

function create(){
    $.ajax({
        url: '/fajax/business/create-from-selection/' + bId,
            type: 'get',
            dataType: 'json',
            success: function(data){
                if (data.success == 'true'){
                    location.replace('/franchise_edit_business/' + data.bId);
                } else{
                    showErrorToast(data.message);
                }
            }
        });
}