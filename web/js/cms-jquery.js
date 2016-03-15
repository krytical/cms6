$(document).ready(function(){
	
	$('#delete_conf').click(function(){
		$($(this).attr("data-target")).appendTo("body");
	});

});