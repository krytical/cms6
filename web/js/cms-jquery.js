$(document).ready(function(){
	
	$(document).on('click', '#delete_modal', (function(){
		$($(this).attr("data-target")).appendTo("body");
	}));

});