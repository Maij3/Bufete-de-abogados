//--------------------------------------
// Jnilla Play v1.0.0
//--------------------------------------
(function($){
	$(document).ready(function(){
		// -------------------------
		// Init
		// -------------------------
		if(!$('.jn-play').length) return;
		
		
		// -------------------------
		// Events
		// -------------------------
		
		// click
		$('.jn-play').click(function(){
			var video = $(this).find('iframe').eq(0);
			video.attr('src', video.data('src'));
			video.fadeIn('slow');
		});
				
		
	});
})(jQuery);




