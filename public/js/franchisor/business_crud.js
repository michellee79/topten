$(document).ready(function(){

    var elMyFormInput = $("#my_form input");
	tinymce.init({
        selector: "#topRightEditor",
        resize:"both",
        relative_urls: false,
        plugins: ["autoresize", "image", "code", "lists", "code","example", "link", "textcolor"],
        indentation : '20pt',
        file_browser_callback: function(field_name, url, type, win) {
            if (type == 'image') elMyFormInput.click();
        },
        image_list: "/imglist",
        toolbar: [
            "undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright | preview | spellchecker | forecolor | backcolor"
        ],
        content_css: "/styles/Page.css, /styles/master.css, /styles/bootstrap.css"
    });

    tinymce.init({
        selector: "#bottomLeftEditor",
        resize:"both",
        relative_urls: false,
        plugins: ["autoresize", "image", "code", "lists", "code","example", "link", "textcolor"],
        indentation : '20pt',
        file_browser_callback: function(field_name, url, type, win) {
            if (type == 'image') elMyFormInput.click();
        },
        image_list: "/imglist",
        toolbar: [
            "undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright | preview | spellchecker | forecolor | backcolor"
        ],
        content_css: "/styles/Page.css, /styles/master.css, /styles/bootstrap.css"
    });

    $(".datepicker").datepicker({
    	changeMonth:true,
    	changeYear:true,
    	defaultDate: "+0"
    });

    $("#imagePicker").change(function(){
        readURL(this);
    });
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgBusinessLogo').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function upload(){
    var xhr, formData;

    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', "/fupload");
    file = $("#uploadname").get(0).files[0];

    xhr.onload = function() {
        var json;

        if (xhr.status != 200) {
            console.log("HTTP Error: " + xhr.status);
            return;
        }

        json = JSON.parse(xhr.responseText);

        if (!json || typeof json.location != "string") {
            console.log("Invalid JSON: " + xhr.responseText);
            return;
        }

        top.$('.mce-btn.mce-open').parent().find('.mce-textbox').val('/Images/upload/' + file.name).closest('.mce-window').find('.mce-primary').click();

//                success(json.location);
    };

    formData = new FormData();
    formData.append('image', file, file.name);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    xhr.send(formData);
}

function validate(){
    if ($("#status").attr('checked') == undefined){
        return true;
    }
	var flag = true;
	$(".requiredInput").each(function(index){
		var idStr = $(this).attr('name');
		if ($(this).val() == ""){
			$("#" + idStr + "Required").css('visibility', 'visible');
			flag = false;
		} else{
			$("#" + idStr + "Required").css('visibility', 'hidden');
		}
	});
	return flag;
}

function showContract(){
    if (validate()){
        submit(2);
        return true;
    } else{
        alert('Please insert all values');
        return false;
    }
}

function refreshCategory(suffix) {
    if(typeof(suffix) === "undefined")
        suffix = '';
    var selIndex = $("#ddlGroup" + suffix)[0].selectedIndex - 1;

    var elDDLCategory = $( "#ddlCategory" + suffix );
	elDDLCategory.empty();
    addItemTo("ddlCategory" + suffix, "", "Select a category");
    if (categories[selIndex].length == 0){
        elDDLCategory.attr('disabled', 'disabled');
    } else{
        elDDLCategory.removeAttr('disabled');
        $.each(categories[selIndex].categories, function (i, item) {
            addItemTo('ddlCategory' + suffix, item.value, item.name);
        });
    }
}

function refreshSubCategory(suffix) {
    if(typeof(suffix) === "undefined")
        suffix = '';

	var selGroupIndex = $("#ddlGroup" + suffix)[0].selectedIndex - 1;
	var selIndex = $("#ddlCategory" + suffix)[0].selectedIndex - 1;

	var elDDLSubCategory = $( "#ddlSubCategory" + suffix ).empty();
    if (categories[selGroupIndex].categories.length == 0){
        elDDLSubCategory.attr('disabled', 'disabled');
    } else{
        elDDLSubCategory.removeAttr('disabled');
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

function submit(mode){
    if(typeof(mode) === "undefined")
        mode = 1;

    // if (validate()){
    showLoading();
    fdata = new FormData();
    fdata.append('bid', bId);
    fdata.append('franchise', $("#ddlFranchise").val());
    fdata.append('catId', $("#ddlSubCategory").val());
    fdata.append('catId2', $("#ddlSubCategory2").val());
    fdata.append('bname', $("#txtBusiness").val());
    fdata.append('address', $("#txtAddress").val());
    fdata.append('city', $("#txtCity").val());
    fdata.append('state', $("#ddlState").val());
    fdata.append('zipcode', $("#txtZipcode").val());
    fdata.append('cfname', $("#txtFirstName").val());
    fdata.append('clname', $("#txtLastName").val());
    fdata.append('cemail', $("#txtEmail").val());
    fdata.append('cwebsite', $("#txtURL").val());
    fdata.append('cphone', $("#txtPhone").val());
    fdata.append('ccphone', $("#txtCellphone").val());
    fdata.append('sdate', $("#txtStartDate").val());
    if ($("#status").attr('checked') == undefined)
        fdata.append('active', "0");
    else
        fdata.append('active', "1");

    var elImagePicker = $("#imagePicker").get(0);
    if (elImagePicker.files.length > 0){
        file = elImagePicker.files[0];
        fdata.append('image', file, file.name);
    }
    fdata.append('trtext', tinymce.get("topRightEditor").getContent());
    fdata.append('bltext', tinymce.get("bottomLeftEditor").getContent());
    fdata.append('summary', $("#txtSummary").val());
    $.ajax({
        url : '/fajax/savebusiness/' + bId,
        type : 'post',
        dataType : 'json',
        contentType: false,
        processData: false,
        success: function(data){
            hideLoading();
            if (data.success == 'true'){
                if (mode == 1){
                    window.location = '/franchise_businesses';
                } else {
                    window.location = '/franchise_contract/' + bId;
                }
            } else{
                showErrorToast(data.message);
            }
        },
        data : fdata
    });
    // } else{
    //     showErrorToast('Please fill up all informations');
    // }
}
