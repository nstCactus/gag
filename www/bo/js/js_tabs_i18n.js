function toogleTabs(langCode){
	
	var allTabContainer = $$('.i18n_tabs');
	allTabContainer.each(function(name, index){
		if(!name.select('.li_flag_'+langCode)[0].hasClassName('hidden')){
			name.select('li').invoke('removeClassName', 'active');
			name.select('li.li_flag_'+langCode).invoke('addClassName', 'active');
			name.up().select('.tab').invoke('hide');
			name.up().select('.i18n_fieldset_'+langCode).invoke('show');
		}
		
	});
}

function capitaliseFirstLetter(string){
    return string.charAt(0).toUpperCase() + string.slice(1);
}

var tabIndexFocus = false;
var tabIndexBlurTimer;
function tabsObserveFocus(name, index){
	name.observe('focus', function(){
		if(tabIndexBlurTimer){
			window.clearTimeout(tabIndexBlurTimer);	
		}
		tabIndexFocus = this;
	});
	name.observe('blur', function(){
		var elem = this;
		tabIndexBlurTimer = window.setTimeout(function(){
			if(tabIndexFocus == elem){
				tabIndexFocus = false;
			}
		}.bind(elem), 200);
		
	});
}

function setFocusInTab(langCode){
	if(tabIndexFocus){
		var newElem = $(tabIndexFocus.id.substr(0, tabIndexFocus.id.length - 3)+capitaliseFirstLetter(langCode));
		if(!newElem){
			newElem = $(tabIndexFocus.id.substr(0, tabIndexFocus.id.length - 3)+langCode);
		}
		
		if(newElem){
			newElem.focus();
		}
	}
}

function i18nTabsInit() {
	$$('.tab input').each(tabsObserveFocus);
	$$('.tab textarea').each(tabsObserveFocus);

	$$('.i18n_tabs li a').each(function(name, index){
		var langCode = name.readAttribute('href').split('#')[1];
		
		if(name.hasClassName('hidden')){
			name.up().up().next('.i18n_fieldset_' + langCode).addClassName('tabHidden');
		}
		
		//Quand on clic
		name.observe('click', function(){
			toogleTabs(langCode);
			setFocusInTab(langCode);
		});
	});
	
	//On met fre par defaut
	var langCode = false; 
	$$('.i18n_tabs li a').each(function(name, id){
		if(!langCode && !name.up().hasClassName('hidden')) {
			langCode = name.readAttribute('href').split('#')[1];
			toogleTabs(langCode);	
		}
	});	
	fieldsetTrad = $$('fieldset.tab');
	
	fieldsetTrad.each(function(name, index){
		error = name.down('.error-message');
		if(error != undefined)
		{
			ul = name.previous('ul.i18n_tabs');			
			
			tabOnglet = name.readAttribute('class');
			tabOnglet.split(' ').each(function(str){
				if(str.startsWith('i18n_fieldset_'))
				{
					lang = str.substr(14, 3);
				}
			});
			
			if(lang != null)
			{				
				ul.down('li a.flag_'+lang).addClassName('tabContainError');
				ul.down('li a.flag_'+lang).insert('<div class="warning">');
			}									
		}			
	});
}

document.observe("dom:loaded", i18nTabsInit);
document.observe('modal:loaded', i18nTabsInit);
document.observe('tabsI18N:init', i18nTabsInit);