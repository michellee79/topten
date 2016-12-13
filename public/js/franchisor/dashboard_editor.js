$(document).ready(function(){
	tinymce.init({
        selector: "#NewsEditor",
        resize:"both",
        relative_urls: false,
        plugins: ["autoresize", "image", "code", "lists", "code","example", "link", "textcolor"],
        indentation : '20pt',
        toolbar: [
            "undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright | preview | spellchecker | forecolor | backcolor"
        ],
        content_css: "/styles/Page.css, /styles/master.css, /styles/bootstrap.css"
    });

});


function submitNews(){
    showLoading();
    
    $.ajax({
        url : '/aajax/savenews',
        type : 'post',
        dataType : 'json',
        success: function(data){
            hideLoading();
            location.reload();
        },
        data : {
            content: tinymce.get("NewsEditor").getContent()
        }
    });
}

function showEditor(){
    $("#NewsEditorBox").slideDown();
}

function hideEditor(){
    $("#NewsEditorBox").slideUp();
}

function showLoading() {
    $('#NewsEditorBox').showLoading();
}

function hideLoading() {
    $('#NewsEditorBox').hideLoading();
}