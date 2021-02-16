(function($){
	$(document).ready(function(){
		// ---------------------------------------------
		// Init
		// ---------------------------------------------
		if(!$('.jn-slick').length) return;
		
		$('.jn-slick').each(function(){
			var jnSlick = $(this);
			var interval = jnSlick.data('interval');
			var duration = jnSlick.data('duration');
			var autoplayFlag = false;
			
			if(typeof interval !== "undefined"){
				autoplayFlag = true;
			}
			
			if(typeof duration == "undefined"){
				duration = 600;
			}
			
			jnSlick.slick({
				infinite: true,
				speed: duration,
				slidesToShow: 1,
				centerMode: true,
				variableWidth: true,
				autoplay: autoplayFlag,
				autoplaySpeed: interval,
				arrows: false,
			});
			
		});
		

	});	
})(jQuery);
