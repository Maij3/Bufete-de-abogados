// v2.0.0
(function($){
	$.fn.jnHolder = function() {
		// holders
		var box = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+gAAAPoAQMAAAEAanYxAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB98MBQYGOz5OK3kAAAAZdEVYdENvbW1lbnQAQ3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAAAk0lEQVR42u3BAQ0AAADCoPdPbQ43oAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAODIAPKYAAEZWDw9AAAAAElFTkSuQmCC";
		var tv = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+gAAALuAQMAAAFwRJ6YAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB98MBQYGLcqanigAAAAZdEVYdENvbW1lbnQAQ3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAAAcUlEQVR42u3BAQEAAACAkP6v7ggKAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYdfcAATFnYvIAAAAASUVORK5CYII=";
		var wide = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+gAAAIzAQMAAAHe5JFpAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB98MBQYFGLcECcgAAAAZdEVYdENvbW1lbnQAQ3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAAAXElEQVR42u3BMQEAAADCoPVPbQwfoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOBuGL4AAdpWCJkAAAAASUVORK5CYII=";
		var cinema = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+gAAAGtAQMAAAHIYPzHAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB98MBQcQJdkbyfoAAAAZdEVYdENvbW1lbnQAQ3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAAATElEQVR42u3BMQEAAADCoPVPbQdvoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAXgPV4gABVUxt5QAAAABJRU5ErkJggg==";
		
		// process
		return this.each(function() {
			if($(this).data('jn-holder-initialized') === true) return true;
			$(this).data('jn-holder-initialized', true);
			
			var src = $(this).attr('src');
			
			var holder = $(this).data('holder');
			if((holder === "") || (typeof holder === "undefined")){
				return true;
			}
			
			// Set image background with actual src
			$(this).css('background-image', "url('"+src+"')");
			
			// Set src to holder
			switch (holder) {
				case 'box': // 1:1
					src = box;
					break;
				case 'tv': // 4:3
					src = tv;
					break;
				case 'wide': // 16:9
					src = wide;
					break;
				case 'cinema': // 21:9
					src = cinema;
					break;
				case 'custom':
					src = $(this).data('holder-src');
					if((src === "") || (typeof src === "undefined")){
						return true;
					}
					
					var baseUrlPath = $('body').data('base-url-path');
					if(baseUrlPath !== "") baseUrlPath = baseUrlPath+"/";
					src = baseUrlPath+src;
					break;
			}
			
			// Set new src
			$(this).attr('src', src);
			
		});
	}

	// Self initialization
	$(document).ready(function(){
		$('.jn-holder').jnHolder();
	});
})(jQuery);
