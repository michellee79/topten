var selGroup = 0, selCat = 0, selSub = 0;
var selType;

function showEdit(ctype){
	if (ctype == 1){
		if (selGroup == 0){
			alert('Please select group first');
    		return;
		}
		id = selGroup;
	} else if (ctype == 2){
		if (selCat == 0){
			alert('Please select parent category first');
    		return;
		}
		id = selCat;
	} else if (ctype == 3){
		if (selSub == 0){
			alert('Please select parent sub-category first');
    		return;
		}
		id = selSub;
	}
	showLoading();
	$.ajax({
            url : '/aajax/cms/getcategoryname/' + ctype + '/' + id,
            type : 'get',
	        dataType : 'json',
	        success: function(data){
	        	hideLoading();
                if (data.success == 'true'){
                	if (ctype == 1){
                		$(".titleText").text('Edit Group');
                	} else if (ctype == 2){
                		$(".titleText").text('Edit Category');
                	} else if (ctype == 3){
                		$(".titleText").text('Edit Sub Category');
                	}
                    $("#name").val(data.name);
                    showFields();
                } else{
                    showErrorToast(data.message);
                }
            }
        });
}

function showAdd(ctype){
    $("#name").val('');
    selType = ctype;
    if (ctype == 1){
    	selGroup = 0;
    	$(".titleText").text('Add New Group');
    } else if (ctype == 2){
    	if (selGroup == 0){
    		alert('Please select group first');
    		return;
    	}
    	selCat = 0;
    	$(".titleText").text('Add New Category');
    } else if (ctype == 3){
    	if (selCat == 0){
    		alert('Please select parent category first');
    		return;
    	}
    	selSub = 0;
    	$(".titleText").text('Add New Sub Category');
    }
    showFields();
}

function saveCategory(){
	ctype = selType;
	params = validate();
	parent = 0;
	if (params === false)
		return;
	if (ctype == 1){
		iid = selGroup;
	} else if (ctype == 2){
		iid = selCat;
		params.parent = selGroup;
	} else if (ctype == 3){
		params.parent = selCat;
		iid = selSub;
	}
	showLoading();
	$.ajax({
            url : '/aajax/cms/savecategory/' + ctype + '/' + iid,
            type : 'post',
	        dataType : 'json',
	        success: function(data){
	        	hideLoading();
                if (data.success == 'true'){
                    if (ctype == 1){
                    	$("#group_box").html(data.html);
                    } else if (ctype == 2){
                    	$("#cat_box").html(data.html);
                    } else if (ctype == 3){
                    	$("#subcat_box").html(data.html);
                    }
                    hideFields();
                } else{
                    showErrorToast(data.message);
                }
            },
            data : params
        });
}

function validate(){
	params = {};
	name = $("#name").val();
	if (name == ''){
		$("#nameRequired").css('visibility','visible');
		return false;
	} else{
		params.name = name;
		$("#nameRequired").css('visibility','hidden');
	}
	return params;
}

function deleteCategory(){
	ctype = selType;
	if (ctype == 1){
		id = selGroup;
	} else if (ctype == 2){
		id = selCat;
	} else if (ctype == 3){
		id = selSub;
	}
	if (confirm('Are you sure to delete?') == false)
		return;
	showLoading();
	$.ajax({
        url : '/aajax/cms/deletecategory/' + ctype + '/' + id,
        type : 'get',
        dataType : 'json',
        success: function(data){
        	hideLoading();
            if (data.success == 'true'){
                if (ctype == 1){
                	$("#group_box").html(data.html);
                } else if (ctype == 2){
                	$("#cat_box").html(data.html);
                } else if (ctype == 3){
                	$("#subcat_box").html(data.html);
                }
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

function catSelChange(ctype, id){
	selType = ctype;
	if (ctype == 1){
		selGroup = id;
		$("#group_" + id).attr('checked', 'checked');
		refreshCategory(2, id);
	} else if (ctype == 2){
		selCat = id;
		$("#cat_" + id).attr('checked', 'checked');
		refreshCategory(3, id);
	} else if (ctype == 3){
		selSub = id;
		$("#sub_" + id).attr('checked', 'checked');
	}
}

function refreshCategory(ctype, parent){
	$.ajax({
        url : '/aajax/cms/getcategory/' + ctype + '/' + parent,
        type : 'get',
        dataType : 'json',
        success: function(data){
        	hideLoading();
            if (data.success == 'true'){
                if (ctype == 1){
                	$("#group_box").html(data.html);
                } else if (ctype == 2){
                	$("#cat_box").html(data.html);
                } else if (ctype == 3){
                	$("#subcat_box").html(data.html);
                }
            } else{
                showErrorToast(data.message);
            }
        }
    });
}