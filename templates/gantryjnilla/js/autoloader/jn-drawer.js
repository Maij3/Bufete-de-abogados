//--------------------------------------
// Jnilla Drawer v1.0.1
//--------------------------------------

(function($)
{
	$(document).ready(function()
	{
		if(!$('.jn-drawer').length) return;
		
		// toggle button
		$('.jn-drawer-toggle').click(function(){
			if($('.jn-drawer-open').length){
				reset();
				return;
			} 
			reset();
			var drawer = $(this).data('drawer');
			$('html, body, .jn-drawer-'+drawer).addClass('jn-drawer-open');
			$('.jn-drawer-body').addClass('jn-drawer-open jn-drawer-body-'+drawer);
		});
		
		// toggle on drawer body click
		$('.jn-drawer-body').click(function(event){
			if($(event.target).hasClass('jn-drawer-toggle')) return;
			reset();
		});
		
		// close button
		$('.jn-drawer-close').click(function(event){
			reset();
		});
		
		function reset(){
			$('html, body, .jn-drawer-open').removeClass('jn-drawer-open');
			$('.jn-drawer-body').removeClass('jn-drawer-body-left jn-drawer-body-right');
		}

	});
	
})(jQuery);