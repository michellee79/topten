
$(document).ready(function(){
	$('#help_search_key').keypress(function(e){
		if (e.keyCode == 13){
			searchHelp();
		}
	});
})

function refreshApproval(){
	code = $("#ddlApprovalStatus").val();
	$.ajax({
		url: '/fvajax/dashboard/setApproval/' + code,
		type: 'get',
		dataType: 'json',
		success: function(data){
			location.reload();
		}
	});
}

function toggleApproval(id){
	showLoadingD();
	$.ajax({
		url: '/fajax/dashboard/setapproval/' + id,
		type: 'get',
		dataType: 'json',
		success: function(data){
			location.reload();
		}
	});
}

function refreshSort(column){
	showLoadingD();
	$.ajax({
		url: '/fajax/setsortcolumn/' + column,
		type: 'get',
		dataType: 'json',
		success: function(data){
			location.reload();
		}
	});
}

function deleteNomination(id){
	r = confirm("Do you really want to delete this nomination?");
	if (r == false)
		return;
	showLoadingD();
	$.ajax({
		url: '/fajax/dashboard/delete/' + id,
		type: 'get',
		dataType: 'json',
		success: function(data){
			if (data.success == 'true'){
				$("#row_" + id).remove();
			}
			hideLoadingD();
		}
	});
}

function showLoadingD() {
    $('.pgContainer').showLoading();
}

function hideLoadingD() {
    $('.pgContainer').hideLoading();
}

var search_result;

function showHelpContent(idx){
	$("#help_container").slideUp();
	showLoadingD();
	$.ajax({
		url: '/fajax/oopdoc/' + idx,
		type: 'get',
		dataType: 'json',
		success: function(data){
			$('#help_content').html(data.post.content);
			$('#help_container').slideDown();
			hideLoadingD();
		}
	});
}

function searchHelp(){
	key = $('#help_search_key').val();
	if (key.length > 0) {
		showLoadingD();
		$("#search_container").slideUp();
		$.ajax({
			url: '/fajax/oopdoc/search/' + key,
			type: 'get',
			dataType: 'json',
			success: function(data){
				html = '';
				if (data.count > 0) {
					search_result = data.posts;

					html = '<ul>';

					for (i = 0; i < data.count; i++){
						html += '<li onclick="showHelpContent(' + data.posts[i].id + ')">';
						html += data.posts[i].title;
						html += '</li>';
					}
					html += '</ul>'
				} else {
					html = 'No content found';
				}
				$("#search_result").html(html);
				$("#search_container").slideDown();
				hideLoadingD();
			}
		});
	}
}

function closeHelp(){
	$('#help_container').slideUp();
}

function closeSearch(){
	$('#search_container').slideUp();
}