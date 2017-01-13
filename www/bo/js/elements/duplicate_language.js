/**
 * Duplication de langues
 */
document.observe("dom:loaded", function() {

	// DOM elements
	var $elementDuplicateLanguage = $('elementDuplicateLanguage');
	
	if($elementDuplicateLanguage == null) return;
	
	var $formFrom = $('elementDuplicateLanguageFrom');
	var $legendOnClose = $('legendOnClose');
	var $fromElements = $formFrom.select('.radio');
	var $formTo = $('elementDuplicateLanguageTo');
	var $toElements = $formTo.select('.checkbox');
	var $submitButton = $('elementDuplicateLanguageSubmitButton');
	var $cancelButton = $('elementDuplicateLanguageCancelButton');
		
	
	// Variable initialisation
	var fromElementIdPrefix = 'elementDuplicateLanguageFrom_';
	var toElementIdPrefix = 'elementDuplicateLanguageTo_';
	var currentFrom = null;
	var currentTo = [];
	
	
	// Events initialisation
	$fromElements.invoke('observe', 'change', fromChangeHandler);
	$toElements.invoke('observe', 'change', toChangeHandler);
	$submitButton.observe('click', submitHandler);
	$legendOnClose.observe('click', openHandler);
	$cancelButton.observe('click', closeHandler);
	
	isValidForm(false);
	
	
	/**
	 * Ouverture de l'element
	 */
	function openHandler(event){
		event.stop();
		$elementDuplicateLanguage.removeClassName('closed');
	}

	/**
	 * Fermeture de l'element
	 */
	function closeHandler(event){
		event.stop();
		$elementDuplicateLanguage.addClassName('closed');
	}
	
	/**
	 * Gestion du changement de From
	 */
	function fromChangeHandler(){
		currentFrom = this.value;
		deactivateToElement(currentFrom);
		isValidForm(false);
	}

	/**
	 * Gestion du changement de To
	 */
	function toChangeHandler(){
		currentTo = [];
		$formTo.select('.checkbox:checked').each(function(name, index){
			currentTo.push(name.value);
		});
		isValidForm(false);
	}
	
	/**
	 * Submit
	 */
	function submitHandler(event){
		event.stop();
		
		var formIsValid = isValidForm(true);
		
		if(formIsValid) {
			duplicateLanguage();
		}
	}
	
	/**
	 * Désactiver un element To
	 */
	function deactivateToElement(codeIso){
		// Reactiver l'element déja désactivé
		$reactivateElement = $formTo.select('.checkbox[disabled]').first();
		if($reactivateElement != null){
			$reactivateElement.disabled = false;
		}
		
		// Desactiver celui qu'on veut
		$(toElementIdPrefix + codeIso).checked = false;
		$(toElementIdPrefix + codeIso).disabled = true;
		
		toChangeHandler();
	}
	
	/**
	 * Check if form is valid
	 * return true / false
	 */
	function isValidForm(showError){
		var isValid = true;
		if(showError == null) showError = false;
		
		if(currentFrom == null){
			isValid = false;
			if(showError) showErrorElement('elementDuplicateLanguageFromError');
		} else {
			hideErrorElement('elementDuplicateLanguageFromError');
		}

		if(currentTo == null || currentTo.length == 0){
			isValid = false;
			if(showError) showErrorElement('elementDuplicateLanguageToError');
		} else {
			hideErrorElement('elementDuplicateLanguageToError');
		}
		
		if(isValid){
			$submitButton.removeClassName('greatInvalid');
		} else {
			$submitButton.addClassName('greatInvalid');
		}
		
		return isValid;
	}
	
	/**
	 * Affiche un message d'erreur
	 */
	function showErrorElement(element){
		$element = $(element);
		if($element) $element.setStyle({display: 'block'});
	}

	/**
	 * Cacher un message d'erreur
	 */
	function hideErrorElement(element){
		$element = $(element);
		if($element) $element.setStyle({display: 'none'});
	}
	
	
	/**
	 * Dupliquer la langue
	 */
	function duplicateLanguage(){
		var fieldsetI18nPrefix = '.i18n_fieldset_';

		// Recuperer tous les elements dans la lanque source
		var $fromInputElements = $$(fieldsetI18nPrefix + currentFrom).invoke('select', 'input, textarea').flatten();
		
		commitCkEditors();
		
		$fromInputElements.each(function(currentFromElement, fromIndex){
			var fromElementId = currentFromElement.id;
			var $fromElement = $(fromElementId);
			
			currentTo.each(function(toLanguage, fromIndex){	
				var toElementId = translateElementId(fromElementId, toLanguage);
				var $toElement = $(toElementId);
				
				if($toElement != null){
					$toElement.value = $fromElement.value;
					fireEvent($toElement,'change');
				} 
			});
			
		});
		
		updateCkEditors();
		flashTabs(currentTo);
	}
	
	
	/**
	 * Met à jour les CK Editor
	 */
	function commitCkEditors(){
		for(var ckInstanceKey in CKEDITOR.instances){
			CKEDITOR.instances[ckInstanceKey].updateElement();
		}
		
	}

	/**
	 * Met à jour les CK Editor
	 */
	function updateCkEditors(){
		for(var ckInstanceKey in CKEDITOR.instances){
			CKEDITOR.instances[ckInstanceKey].setData($(ckInstanceKey).value);
		}
		
	}
	
	/**
	 * "Traduit" l'id de l'element
	 */
	function translateElementId(fromId, toLanguage){
		// Decoupe l'id
		var idLength = fromId.length;
		var langPosition = null;
		var inputName = fromId.substr(0, idLength-3);
		var inputLang = fromId.substr(idLength-3, 3);
		var translated = '';
		var toLanguageCapitalized = toLanguage.charAt(0).toUpperCase() + toLanguage.slice(1);
		var currentFromCapitalized = currentFrom.charAt(0).toUpperCase() + currentFrom.slice(1);
		
		if(currentFrom.toLowerCase() == inputLang.toLowerCase()){
			langPosition = 'suffixed';
		} else if(currentFrom.toLowerCase() == fromId.substr(0, 3).toLowerCase()){
			langPosition = 'prefixed';
			inputLang = fromId.substr(0, 3);
			inputName = fromId.substr(3, idLength-3);
		} else if(fromId.indexOf(currentFromCapitalized) >= 0){
			position = fromId.indexOf(currentFromCapitalized);
			translated = fromId.substr(0, position) + toLanguageCapitalized + fromId.substr(position + 3);
			return translated;
		}

		// Capitalize si nécessaire
		if(inputLang.charAt(0) == inputLang.charAt(0).toUpperCase()){
			toLanguage = toLanguageCapitalized;
		}
		
		// Langue préfixée
		if(langPosition == 'prefixed'){
 			translated = toLanguage + inputName;
		} 
		// Langue suffixée
		else if(langPosition == 'suffixed'){
			translated = inputName + toLanguage;
		}
		
		return translated;
	}
	
	/**
	 * Fire event
	 */
	function fireEvent(element,event){
	    if (document.createEventObject){
		    // dispatch for IE
		    var evt = document.createEventObject();
		    return element.fireEvent('on'+event,evt)
	    }
	    else{
		    // dispatch for firefox + others
		    var evt = document.createEvent("HTMLEvents");
		    evt.initEvent(event, true, true ); // event type,bubbling,cancelable
		    return !element.dispatchEvent(evt);
	    }
	}
	
	
	/**
	 * Affiche un "flash" sur les tabs des langues
	 */
	function flashTabs(toLanguages){
		toLanguages.each(function(codeIso){
			var $tabs = $$('.li_flag_' + codeIso);
			var $tabsLink = $$('.li_flag_' + codeIso + ' a');
			$tabs.invoke('setStyle', {backgroundColor : '#7ACC57'});
			$tabsLink.invoke('setStyle', {'border-bottom-color' : '#7ACC57'});
			
			window.setTimeout(function(){
				$tabs.invoke('setStyle', {backgroundColor : '#f4f4f4'});
				$tabsLink.invoke('setStyle', {'border-bottom-color' : '#ededed'});
			},500);
		});

		
	}
});