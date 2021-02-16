(function($){
	$(document).ready(function(){
		// make iframe based video players responsive
		var els = $("iframe[src*='vimeo'], iframe[src*='youtube']");
		els.addClass('jn-responsive');
	});
})(jQuery);