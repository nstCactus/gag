function checkLength(){
	return true;
}

var boTools = {
	/**
	 * init
	 */
	init: function(){
		boTools.hiddenActionAjaxLinkHandler();
		boTools.cakeLog();
	},
		
	/**
	 * hiddenActionAjaxLink
	 * ====================
	 * Remplace les lien ayant la class hiddenActionAjaxLink par des 
	 * requetes AJAX.
	 * Utilisé pour les liens de suppression par exemple
	 * 
	 * Callback: ajaxCallback
	 * 
	 * Exemple:
	 * -------
	 * <a href="LIEN" ajaxCallback="linkAjaxCallback" class="hiddenActionAjaxLink">Texte</a>
	 */
	hiddenActionAjaxLinkHandler: function(){
		$$('a.hiddenActionAjaxLink').each(function(element){
			element.observe('click', boTools.hiddenActionAjaxLinkAction);
		});
	},

	/**
	 * hiddenActionAjaxLinkAction
	 * @param event
	 */
	hiddenActionAjaxLinkAction: function(event){
		event.stop();
		new Ajax.Request(event.element().readAttribute('href'), {
			onSuccess: function(response) {
				var callback = event.element().readAttribute('ajaxCallback');
				if(Object.isFunction(window[callback])){
					window[callback]();
				}
			}
		});
		
		
	},
	
	cakeLog: function(){
		if($('bo_footer') != null){
			$$('.cake-sql-log').each(function(element){
				var elem = element.remove();
				$('bo_footer').insert({bottom: elem });
				
				$$('.cake-sql-log tr').each(function(elem){
					var td = elem.childElements();
					var last = td[td.length-1].innerHTML;
					if(last>50){
						elem.addClassName('cakeLogNotice');
					} else if(last > 200){
						elem.addClassName('cakeLogWarning');
					}
					var error = td[2].innerHTML;
					if(error != ''){
						elem.addClassName('cakeLogError');
					}
				});
				elem = null;
			});
		}
	},
	
	/**
	 * downFooter
	 */
	downFooter: function(){
		var height = document.viewport.getHeight();
		var footerTop = parseInt(boTools.footer.getStyle('top'), 10);
		var bodyHeight = boTools.body.getHeight();
		
		if(boTools.lastDocumentHeight != height ||
		   boTools.lastFooterTop != footerTop ||
		   boTools.lastBodyHeight != bodyHeight
		){
			if(bodyHeight < height-boTools.footerHeight){
				boTools.footer.setStyle({top: (height-boTools.footerHeight) + 'px', width: '100%'});
			} else {
				boTools.footer.setStyle({top: (bodyHeight-boTools.footerHeight) + 'px', width: '100%'});
			}
			
			boTools.lastDocumentHeight = height;
			boTools.lastFooterTop = footerTop;
			boTools.lastBodyHeight = bodyHeight;
		}
	},
	
	
	/**
	 * Recherche le parent avec la classe Line
	 */
	findElement: function(event, className){
		var eventElement;
		if (event.element == undefined)
			eventElement = event;
		else	
			eventElement = event.element();
		var lineElement = false;
		
		if(eventElement.hasClassName(className)){
			lineElement = eventElement;
		} else {
			var found = false;
			eventElement.ancestors().each(function(e, i){
				if(!found){
					if(e.hasClassName(className)){
						lineElement = e;
						found = true;
					}
				}
			});
		}
		return lineElement;
	}
		
};

Event.observe(window, 'load', boTools.init);