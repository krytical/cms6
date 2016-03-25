$(document).ready(function(){
	
	$(document).on('click', '#delete_modal', (function(){
		$($(this).attr("data-target")).appendTo("body");
	}));
	
	$(document).on('click', '#conf_expand', (function(){
		x=document.getElementById('expand_button');
		if (x.innerText == 'expand_more'){
			x.innerText='expand_less';
		}
		else {
			x.innerText='expand_more';
		}
		
	}));

});