(function($){
	$(document).ready(function(){
		//--------------------------------------
		// Init
		//--------------------------------------
		if(!$('body.development-mode').length) return;
		
		var baseUrl = $('body').data('base-url');
		var jnHudAction = $('<a class="jn-hud jn-hud-action">');
		var jnHudMain;
		var btnSize;
		var btnCss;
		var jnHudMod;
		var clone;
		var itemId;
		var articleId;
		var editUrl;
		var actionText;
		var blockClass;
		var bodyClass;
		var moduleId;
		var flags = [];
		var winW;
		var winH;
		var jnHudTools;
		var jnHudToolsToggle;
		var jnHudToolsH;
		var jnHudWindowSize;
		
		// Hide wireframe
		$('body').addClass('jn-hud-wireframe-hide');
		
		// Set default toggle value
		if(typeof $.cookie('jn-hud-wireframe-toggle') === 'undefined'){
			$.cookie('jn-hud-wireframe-toggle', '0');
		};
		if($.cookie('jn-hud-wireframe-toggle') === "1") wireframeToggle();
		
		// Add hud tools
		jnHudTools = $(
			'<div class="jn-hud jn-hud-tools" title="Jn HUD">'+
			'	<div class="jn-hud-tools-container" title="Jn HUD">'+
			'		<div class="jn-hud jn-hud-action jn-hud-action-hide" title="Hide until next page reload"><i class="fas fa-times"></i></div> '+
			'		<span class="jn-hud-window-size" title="Window Size">0 x 0</span> '+
			'		<div class="jn-hud jn-hud-action jn-hud-action-wireframe" title="Toggle Wireframe (ctrl+enter)"><i class="fas fa-eye-slash"></i></div>'+
			'		<div class="jn-hud jn-hud-action jn-hud-action-reload-css" title="Reload CSS (shift+enter)"><i class="fas fa-sync"></i></div>'+
			'		<span class="jn-hud-working"><i class="fas fa-spinner fa-spin" title="Wait..."></i></span>'+
			'	</div>'+
			'</div>'
		);
		$('body').prepend(jnHudTools);
		
		jnHudWindowSize = jnHudTools.find('.jn-hud-window-size');
		
		// Add group row label
		$('.jn-group-row').each(function() {
			$(this).prepend($('<span class="jn-hud jn-hud-wireframe jn-hud-label jn-hud-block">#'+$(this).attr('id')+'</span>'));
		});
		
		// Add jn-main label
		$('#jn-main').prepend($('<span class="jn-hud jn-hud-wireframe jn-hud-label jn-hud-block">#jn-main</span>'));
		
		// Add menu item action
		itemId = $('body').data('item-id');
		editUrl = baseUrl+"administrator/index.php?option=com_menus&view=item&client_id=0&layout=edit&id="+itemId;

		bodyClass = $('body').data('body-class');
		bodyClass = bodyClass.split(/\s/);
		bodyClass = bodyClass[0];
		
		if(bodyClass){
			actionText = ' Item | id '+itemId+" | ."+bodyClass;
		}else{
			actionText = ' Item | id '+itemId;
		}

		clone = jnHudAction.clone()
		clone
			.addClass('')
			.attr('href', editUrl)
			.attr('target', '_blank')
			.attr('title', 'Edit Menu Item')
			.text(actionText)
			.prepend($('<i class="fas fa-cog"></i>'));
		jnHudTools.find('.jn-hud-tools-container').append(clone);
		
		// Add component action
		clone = jnHudAction.clone()
		
		if($('.component-content > .article').length){
			articleId = $('.component-content > .article').data('article-id');
			editUrl = baseUrl+"administrator/index.php?option=com_content&task=article.edit&id="+articleId;
			
			clone
				.addClass('jn-hud-wireframe jn-hud-absolute-top-left')
				.attr('href', editUrl)
				.attr('target', '_blank')
				.attr('title', 'Edit Article')
				.text(' Article | id '+articleId)
				.prepend($('<i class="fas fa-cog"></i>'));
			$('.component-content').prepend(clone);
		}
		
		// Add module action
		$('.jn-hud-module-data').each(function() {
			moduleId = $(this).data('id');
			editUrl = baseUrl+"administrator/index.php?option=com_modules&task=module.edit&id="+moduleId;
			
			blockClass = $(this).data('block-class');
			blockClass = blockClass.split(/\s/);
			blockClass = blockClass[0];
			
			if(blockClass){
				actionText = ' Module | id '+moduleId+" | ."+blockClass;
			}else{
				actionText = ' Module | id '+moduleId;
			}
			
			clone = jnHudAction.clone()
			clone
				.addClass('jn-hud-wireframe jn-hud-absolute-top-left')
				.attr('href', editUrl)
				.attr('target', '_blank')
				.attr('title', 'Edit Module')
				.text(actionText)
				.prepend($('<i class="fas fa-cog"></i>'));
			$(this).parent().prepend(clone);
			
			$(this).remove();
		});
		
		//--------------------------------------
		// Events
		//--------------------------------------
		
		// Window resize
		$(window).resize(function(){
			if(flags["windows-resize"]) return;
			flags["windows-resize"] = true;
			
			setTimeout(function (){
				flags["windows-resize"] = false;
				winW = $(window).width();
				winH = $(window).height();
				jnHudWindowSize.text(winW+' x '+winH);
			}, 500);
		});
		$(window).trigger('resize');
		
		// Wireframe toggle click
		jnHudTools.find('.jn-hud-action-wireframe').click(function() {
			wireframeToggle();
			wireframeToggleCookie();
		});
		
		// Tools hide click
		jnHudTools.find('.jn-hud-action-hide').click(function() {
			jnHudTools.hide();
		});
		
		// Reload css click
		jnHudTools.find('.jn-hud-action-reload-css').click(function() {
			reloadCSS();
		});
		
		// Hotkeys
		$( document ).keypress(function( keyCode ) {
			// ctrl+enter | Toggle wireframe
			if (keyCode.ctrlKey && (keyCode.keyCode == 10 || keyCode.keyCode == 13)) {
				jnHudTools.find('.jn-hud-action-wireframe').trigger('click');
			}
			
			// shift+enter | Reload css
			if (keyCode.shiftKey && (keyCode.keyCode == 10 || keyCode.keyCode == 13)) {
				jnHudTools.find('.jn-hud-action-reload-css').trigger('click');
			}
		});
		
		//--------------------------------------
		// Functions
		//--------------------------------------
		
		// Reload CSS
		function reloadCSS(){
			if (flags['reload-css']) return;
			flags['reload-css'] = true;
			
			var el = $('head link[href*="/autoloader.css"]');
			
			if(!el.data('href')) el.data('href', el.attr('href'))
			var href = el.data('href');
			var href2 = href + "&time=" + new Date().getTime();
			
			jnHudTools.find('.jn-hud-working').addClass('active');
			
			// Reload css
			$.get(document.location.origin+document.location.pathname)
				.always(function() {
					flags['reload-css'] = false;
					el.attr('href', href2);
					jnHudTools.find('.jn-hud-working').removeClass('active');
				});
		}
		
		// Wireframe toggle
		function wireframeToggle(){
			$('body')
				.toggleClass('jn-hud-wireframe-hide')
				.toggleClass('jn-hud-wireframe');
		}
		
		// Toggle hud cookie state
		function wireframeToggleCookie(){
			if ($.cookie('jn-hud-wireframe-toggle') === "0" )
			{
				$.cookie('jn-hud-wireframe-toggle', '1');
			}else
			{
				$.cookie('jn-hud-wireframe-toggle', '0');
			}
		}
		
		// Append heading tag to all headings
		$(':header').each(function() {
			var tag = $(this).prop("tagName");
			$(this).prepend($('<span class="jn-hud-wireframe">['+tag+']</span>'));
		});

	});
})(jQuery);





