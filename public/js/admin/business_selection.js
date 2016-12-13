function refreshFilter(){
	code = $("#ddlFranchiseCode").val();
	$.ajax({
		url: '/aajax/business/setfranchisefilter/' + code,
		type: 'get',
		dataType: 'json',
		success: function(data){
			location.reload();
		}
	});
}