//--------------------------------------
// Jnilla Responsive v1.0.0
//--------------------------------------
(function($){
	$(document).ready(function(){
		//--------------------------------------
		// init
		//--------------------------------------
		var els = $('.jn-responsive');
		if(!els.length) return;
		
		// calc ratio and store original size
		els.each(function() {
			var el = $(this);
			var elWidth;
			var elHeight;
			
			// define best original width
			elWidth = el.attr('width');
			if (typeof elWidth === 'undefined' || elWidth === false) {
				elWidth = el.width();
			}
			
			// define best original height
			elHeight = el.attr('height');
			if (typeof elHeight === 'undefined' || elHeight === false) {
				elHeight = el.height();
			}
			
			// store original size and calc ratio
			el
				.data({
					'width':elWidth,
					'height':elHeight,
					'ratio':(elHeight/elWidth)
				})
				.removeAttr('height')
				.removeAttr('width');
			
		});
		
		// first run
		$(window).trigger('resize');
		
		
		//--------------------------------------
		// events
		//--------------------------------------
		
		// window resize
		$(window).resize(function(){
			
			els.each(function(){
				var el = $(this);
				var paretWidth = el.parent().width();
				var elOriginalWidth = el.data('width');
				var elOriginalHeight = el.data('height');
				var elRatio = el.data('ratio');
				var elOldParentWidth = el.data('old-parent-width');
				var elWidth = el.width();
				
				// update if parent width changed
				if(paretWidth !== elOldParentWidth){
					if(el.hasClass('jn-responsive-block') || (paretWidth < elOriginalWidth)){
						// adjust element to parent 
						el
							.width(paretWidth)
							.height(paretWidth*elRatio);
					}else{
						// set original element size
						el
							.width(elOriginalWidth)
							.height(elOriginalHeight);
					}
				}
				
				// update old parent width
				el.data('old-parent-width', paretWidth);
				
			});
			
		}).resize();
		
		
	});
})(jQuery);




