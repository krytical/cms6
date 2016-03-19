$(document).ready(function(){
	
	$(document).on('click', '#delete_conf', (function(){
		$($(this).attr("data-target")).appendTo("body");
	}));

});