$(document).ready(function(){
	
});

function navigateToEditor(){
    id = $("#ddlEditPage").val();
    if (id > 0){
        location.replace("/admin_cms/" + id);
    }
}

function navigateToEmailEditor(){
    id = $("#ddlEditEmail").val();
    if (id > 0){
        location.replace("/admin_cms_email/" + id);
    }
}