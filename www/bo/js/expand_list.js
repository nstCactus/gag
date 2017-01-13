var ExpandList = {
		
    init: function(listElement, onClickListener){
		$$('#'+listElement+' .itemInner').each(function (element){
			element.observe('click', function(event){
				var e = event.element();
				
				// Style
				var alr = e.hasClassName('current');
				var id;
				
				$$('#'+listElement+' .itemInner').invoke('removeClassName', 'current');
				if(!alr){
					e.addClassName('current');
					id = e.id.split('_')[1];
				} else {
					id = false;
				}
				
				onClickListener(event, id);
			});
		});
	}
}


/**
 * 
 */
var currentAroId = false;
var currentAcoId = false;
function aclExpandListInit(){
	ExpandList.init(
		'aclAroListContainer',
		function(event, id){
			currentAroId = id;
			aclAroLoader();
		}
	);
	
	ExpandList.init(
		'aclAcoListContainer',
		function(event, id){
			currentAcoId = id;
			aclAcoLoader();
		}
	);
	
	// Listener btn autorisé
	$('aclAllowNode').observe('click', function(event){
		if(currentAroId && currentAcoId){
			new Ajax.Request('acls/create/aroId:'+currentAroId+'/acoId:'+currentAcoId, {
				onSuccess: function(response) {
					aclAroLoader();
					aclAcoLoader();
				}
			});
		}
	});
		
	// Cacher 3eme niveau aco
	$$('#aclAcoListContainer > ul.expandList > li > ul > li > ul').invoke('hide');
	
	// Afficher 3eme niveau au clic
	$$('#aclAcoListContainer > ul.expandList > li > ul > li').each(function(element){
		element.observe('click', function(event){
			var level3 = boTools.findElement(event, 'expandListLevel_3');
			if(!level3){
				var element = boTools.findElement(event, 'expandListItem');
				element = element.down('.expandList');
				if(element){
					var isVisible = element.hasClassName('visible');
					$$('#aclAcoListContainer > ul.expandList > li > ul > li > ul').invoke('hide');
					$$('#aclAcoListContainer > ul.expandList > li > ul > li > ul').invoke('removeClassName','visible');
					$$('#aclAcoListContainer .expandListLevel_2 > .expandListItemHasChildren').invoke('removeClassName','childVisible');
					if(isVisible){
						element.hide();
						element.removeClassName('visible');
						element.up('.expandListItem').removeClassName('childVisible');
					} else {
						element.show();
						element.addClassName('visible');
						element.up('.expandListItem').addClassName('childVisible');
					}
				} else {
					$$('#aclAcoListContainer > ul.expandList > li > ul > li > ul').invoke('hide');
					$$('#aclAcoListContainer > ul.expandList > li > ul > li > ul').invoke('removeClassName','visible');
					$$('#aclAcoListContainer > ul.expandList > li > ul > li').invoke('removeClassName','childVisible');
				}
			}
		});
	});
	
	
	
}

/**
 * 
 */
function aclAroLoader(){
	var resultContainerId = 'aroGrantsList';
	var ajaxLink = 'acls/acoByAro/'+currentAroId;
	
	if(currentAroId){
		new Ajax.Request(ajaxLink, {
			onSuccess: function(response) {
				$(resultContainerId).update(response.responseText);
				boTools.hiddenActionAjaxLinkHandler();
				updateAllowIcons();
			  }
		});
	} else {
		$(resultContainerId).update('');
		updateAllowIcons();
	}
}

/**
 * 
 */
function aclAcoLoader(){
	var resultContainerId = 'acoGrantsList';
	var ajaxLink = 'acls/aroByAco/'+currentAcoId;
	
	if(currentAcoId){
		new Ajax.Request(ajaxLink, {
			onSuccess: function(response) {
				$(resultContainerId).update(response.responseText);
				boTools.hiddenActionAjaxLinkHandler();
			}
		});
	} else {
		$(resultContainerId).update('');
	}
}

/**
 * 
 */
function aclDeleteCallback(){
	aclAroLoader();
	aclAcoLoader();
}

/**
 * 
 */
function updateAllowIcons(){
	var allowedItems = $$('.allowedAco');
	$$('.itemInner').invoke('removeClassName', 'allowFlagAll');
	$$('.itemInner').invoke('removeClassName', 'allowFlagNone');
	$$('.itemInner').invoke('removeClassName', 'allowFlagSome');
	$$('.itemInner').invoke('removeClassName', 'allowFlagParent');
	
	allowedItems.each(function(element){
		var id = element.id.split('_')[1];
		var target = $('aclAcoItemInner_'+id);
		target.addClassName('allowFlagAll');
		
		target.ancestors().each(function(a){
			if(a != $('aclAcoItem_'+id) && a.hasClassName('expandListItem')){
				a.down('.itemInner').addClassName('allowFlagSome');
			}
		});
		$('aclAcoItem_'+id).descendants().each(function(a){
			if(a != $('aclAcoItem_'+id) && a.hasClassName('itemInner')){
				a.addClassName('allowFlagParent');
			}
		});
	});
	
	
	$$('.allowFlagSome').each(function(a){
		var allChildsAllowed = true;
		a.up('li').down('ul').descendants().each(function(element){
			if(element.hasClassName('itemInner')){
				if(allChildsAllowed && !element.hasClassName('allowFlagAll')){
					allChildsAllowed = false;
				}
			}
		});
		if(allChildsAllowed){
			a.addClassName('allowFlagAll');
		}
	});
	
}


Event.observe(window, 'load', aclExpandListInit);