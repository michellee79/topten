
$(document).ready(function(){
	tinymce.init({
        selector: "#content",
        resize: "both",
        relative_urls: false,
        plugins: ["autoresize", "image", "code", "lists", "code","example", "link"],
        indentation : '20pt',
        file_browser_callback: function(field_name, url, type, win) {
            if (type == 'image') $('#my_form input').click();
        },
        image_list: "/imglist",
        toolbar: [
            "undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright | preview | spellchecker"
        ],
        content_css: "/styles/Page.css, /styles/master.css, /styles/bootstrap.css"
    });

});

function validate(){
	flag = true;
	$(".requiredInput").each(function(index){
		idStr = $(this).attr('name');
		if ($(this).val() == ""){
			$("#" + idStr + "Required").css('visibility', 'visible');
			flag = false;
		} else{
			$("#" + idStr + "Required").css('visibility', 'hidden');
		}
	});
	return flag;
}

function save(){
    if (validate()){
        showLoading();
        fdata = new FormData();
        fdata.append('title', $("#txtTitle").val());
        fdata.append('content', tinymce.get("content").getContent());
        fdata.append('isActive', $("#ddlStatus").val());

        data = {};
        data.title = $("#txtTitle").val();
        data.content = tinymce.get("content").getContent();
        data.isActive = $("#ddlStatus").val();

        $.ajax({
            url : '/aajax/cms/savecontract',
            type : 'post',
            dataType : 'json',
            contentType: false,
            processData: false,
            success: function(data){
                //window.location = '/admin_cms';
                hideLoading();
            },
            data : fdata
        });
    } else{
        showErrorToast('Please complete all information.');
    }
}


function upload(){
    var xhr, formData;

    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', "/upload");
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

        top.$('.mce-btn.mce-open').parent().find('.mce-textbox').val('/Images/CMS/' + file.name).closest('.mce-window').find('.mce-primary').click();

//                success(json.location);
    };

    formData = new FormData();
    formData.append('image', file, file.name);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    xhr.send(formData);
}

function returnToMenu(){
    location.replace('/admin_cms');
}



function showLoading() {
    $('.pgContainer').showLoading();                        
}

function hideLoading() {
    $('.pgContainer').hideLoading();            
}