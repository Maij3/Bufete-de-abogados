/**
 * @copyright	 Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license		 GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */



//--------------------------------------
// jnilla contact form behavior
//--------------------------------------
(function($)
{
	$(document).ready(function()
	{
		$('.jnilla-contact-form .display-on-click').hide();
		$('.jnilla-contact-form').click(function(){
			$(this).find('.display-on-click').slideDown();
		});
	});
})(jQuery);


//--------------------------------------
// render reCaptcha widgets
//--------------------------------------
var CaptchaCallback = function(){
	(function($)
	{
		$('.jnilla-contact-form').each(function() {
			var grc = $(this).find('.g-recaptcha').eq(0);
			var id = grc.attr('id');
			var sitekey = grc.data('sitekey');
			// render widgets automatically
			if(!grc.parents('.display-on-click').length) 
			{
				grecaptcha.render(id, {'sitekey' : sitekey});
			}
			// render widget on demand
			else
			{
				grc.closest('.jnilla-contact-form').click(function() {
					$(this).unbind('click');
					var grc = $(this).find('.g-recaptcha').eq(0);
					var id = grc.attr('id');
					var sitekey = grc.data('sitekey');
					grecaptcha.render(id, {'sitekey' : sitekey});
				});
			}
		});
	})(jQuery);
};



