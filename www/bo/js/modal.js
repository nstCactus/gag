var modal = {
    
	init: function(){
		
		if(!$('m_modalContainer') || !$('m_modalFade')) return;
			
		$('m_modalContainer').hide();
		
		// Modal : link ajax
		$$('.m_toModal').each(function(element){
			element.observe('click', function(event) {
				event.stop();
				var element = modal.findElement(event, 'm_toModal');
				link = element.readAttribute('href');
				modal.showModal('');
				new Ajax.Request(link, {
					onSuccess: function(response) {
						$('m_modalContainer').update(response.responseText);
					    modal.centerModal();
						Cufon.refresh('.replace');
					  }
				});
			});
		});
		
		// Modal : Content
		$$('.m_toModalContent').each(function(element){
			element.observe('click', function(event) {
				event.stop();
				var element = modal.findElement(event, 'm_toModalContent');
				content = element.readAttribute('content');
				modal.showModal(content);
				modal.centerModal();
			});
		});
		
		$('m_modalFade').observe('click', function(event) {
			modal.hideModal();
		});
	},

	showModal: function(content){
		modal.posFade($('m_modalFade'));
		$('m_modalFade').show();
		$('m_modalContainer').update();
		$('m_modalContainer').show();
		$('m_modalContainer').update(content);
		
		document.fire('modal:loaded');
	},

	posFade: function(e){
		e.style.height = document.documentElement.clientHeight+'px';
		e.style.width = document.documentElement.clientWidth+'px';
	},
	
	hideModal: function(){
		$('m_modalContainer').hide();
		$('m_modalFade').hide();
	},
	
	centerModal: function(){
		var modal = $('m_modalContainer');
		var top = 0;
		var left = 0;
		
		left = (document.documentElement.clientWidth-modal.getDimensions().width)/2;
		if(left<0){left=0; }
		modal.style.left = left+"px";
		top = document.documentElement.clientHeight;
		top = (document.documentElement.clientHeight-modal.getDimensions().height)/2;
		if(top<0){top=0; }
		modal.style.left = left+"px";
		modal.style.top = top+"px";
	},
	
	// Recherche le parent avec la classe Line
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
			eventElement.ancestors().each(function(e, i){
				if(e.hasClassName(className)){
					lineElement = e;
				}
			});
		}
		return lineElement;
	}
	
};



Event.observe(window, 'load', modal.init);