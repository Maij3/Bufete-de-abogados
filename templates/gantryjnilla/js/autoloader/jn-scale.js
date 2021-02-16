(function($){
	$(document).ready(function(){
		//--------------------------------------
		// Init
		//--------------------------------------
		if(!$('.jn-scale').length) return;
		
		// First run
		scaleElements();
		
		
		//--------------------------------------
		// Events
		//--------------------------------------
		
		// Window resize
		$(window).resize(function(){
			scaleElements();
		});
		
		
		//--------------------------------------
		// Functions
		//--------------------------------------
		
		// Scale elements
		function scaleElements(){
			$('.jn-scale').each(function(){
				var el = $(this);
				
				var referenceWidth;
				if(typeof el.data('reference-width') === 'undefined'){
					return true;
				}else{
					referenceWidth = parseInt(el.data('reference-width'));
				}
				
				var parentWidth = el.parent().width();
				var scale = parentWidth/referenceWidth;
				
				el.css('transform', 'scale('+scale+')');
			});
		}
		
		
	});
})(jQuery);





