var pId;

$(document).ready(function(){
	tinymce.init({
        selector: "#content",
        resize: "both",
        relative_urls: false,
        plugins: ["autoresize", "image", "code", "lists", "example", "link", "textcolor"],
        indentation : '20pt',
        file_browser_callback: function(field_name, url, type, win) {
            if (type == 'image') $('#my_form input').click();
        },
        image_list: "/imglist",
        toolbar: [
            "undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright | preview | spellchecker | forecolor | backcolor"
        ],
        entity_encoding : "raw",
        valid_children : "+body[style]",
        extended_valid_elements : "script[src|type|language|href],style[type]",
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
        fdata.append('pageTitle', $("#txtPageTitle").val());
        fdata.append('metaKeyword', $("#txtMetaKeyword").val());
        fdata.append('metaDescritpion', $("#txtMetaDescritpion").val());
        fdata.append('content', tinymce.get("content").getContent());
        fdata.append('isActive', $("#ddlStatus").val());

        $.ajax({
            url : '/aajax/cms/savepage/' + pId,
            type : 'post',
            dataType : 'json',
            contentType: false,
            processData: false,
            success: function(data){
                window.location = '/admin_cms';
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
    location.replace('admin_cms');
}

function deletePage(){
    r = confirm('Are you sure to delete this page?');
    if (r == false)
        return;
    $.ajax({
            url : '/aajax/cms/deletepage/' + pId,
            type : 'get',
            dataType : 'json',
            success: function(data){
                location.replace('/admin_cms');
            }
        });
}


function showLoading() {
    $('.pgContainer').showLoading();                        
}

function hideLoading() {
    $('.pgContainer').hideLoading();            
}