var iid;

function showEdit(id){
	showLoading();
	$.ajax({
            url : '/aajax/cms/getindustry/' + id,
            type : 'get',
	        dataType : 'json',
	        success: function(data){
	        	hideLoading();
	        	iid = id;
                if (data.success == 'true'){
                	$("#AddOrEdit").text('Edit');
                    $("#industry").val(data.industry.industry);
                    $("#percentage").val(data.industry.percentage);
                    showFields();
                } else{
                    showErrorToast(data.message);
                }
            }
        });
}

function showAdd(){
	$("#AddOrEdit").text('Add New');
    $("#industry").val('');
    $("#percentage").val('0');
    iid = 0;
    showFields();
}

function saveIndustry(){
	params = validate();
	if (params === false)
		return;
	showLoading();
	$.ajax({
            url : '/aajax/cms/saveindustry/' + iid,
            type : 'post',
	        dataType : 'json',
	        success: function(data){
	        	hideLoading();
                if (data.success == 'true'){
                    location.reload();
                } else{
                    showErrorToast(data.message);
                }
            },
            data : params
        });
}

function validate(){
	params = {};
	industry = $("#industry").val();
	if (industry == ''){
		$("#industryRequired").css('visibility','visible');
		return false;
	} else{
		params.industry = industry;
		$("#industryRequired").css('visibility','hidden');
	}
	percentage = $("#percentage").val();
	if (percentage == ''){
		$("#percentageRequired").css('visibility', 'visible');
		return false;
	} else{
		params.percentage = percentage;
		$("#percentageRequired").css('visibility', 'hidden');
	}
	return params;
}

function deleteIndustry(id){
	if (confirm('Are you sure to delete this industry?') == false)
		return;
	showLoading();
	$.ajax({
        url : '/aajax/cms/deleteindustry/' + id,
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