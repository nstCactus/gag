var Multiple = Class.create({
	/**
	 * Constructeur
	 */
	initialize: function(field, dataProviderUrl, addService, opt) {
		this.fieldName = field;
		this.dataProviderUrl = dataProviderUrl;
		this.addService = addService;
		this.newFieldName = opt['newFieldName'];
		this.opt = opt;
		
		this.lastFilter = "";
		this.updateListeTimer = "";
		this.hideListeTimer = "";
    
		this.cachedResults = new Array();
		
		this.initElements();
		this.initObserver();
		
		// Init interface
		$(this.liste).hide();
		
		this.initSortable();
			
	},

	initSortable: function(){
		Sortable.create(this.elemMultipleUL, {
			overlap: 'horizontal',
			constraint:'horizontal',
			only: 'multipleLiElement',
			onUpdate: function() {
				var seq = Sortable.sequence(this.elemMultipleUL);
				var count = 0;
				for(var i in seq){
					var field = $(this.fieldName+'_'+seq[i]);
					if(field){
						field.setAttribute('value',count);
						count++;
					}
				}
			}.bind(this)
		});
	},
	
	/**
	 * Initialise les références vers les éléments
	 */
	initElements: function(){
		this.elemMultipleUL = "multipleUl"+this.fieldName;
		this.elemMultipleInput = "multipleInput"+this.fieldName;
		this.elemMultipleList = "multipleList"+this.fieldName;
		this.elemMultipleContainer = "multipleContainer"+this.fieldName;
		this.elemMultipleHiddenFieldContainer = "multipleHiddenFieldContainer"+this.fieldName;
		this.elemMultipleLi = "multipleLi";
		
		this.input = $(this.elemMultipleInput);
		this.liste = $(this.elemMultipleList);
		this.container = $(this.elemMultipleContainer);
		this.timerUpdateList = null;		
	},
	
	/**
	 * InitializeObserver
	 */
	initObserver: function() {
		this.input.observe("keydown", this.inputDownFire.bind(this));
		this.input.observe("keyup", this.inputFire.bind(this));
		this.input.observe("cut", this.inputFire.bind(this));
		this.input.observe("paste", this.inputFire.bind(this));
		this.container.observe("click", this.eventContainerClick.bind(this));
		this.input.observe("focus", this.eventInputFocus.bind(this));
		document.observe("click", this.eventDocumentClick.bind(this));
		
		// Delete
		$$("#"+this.elemMultipleContainer+" ul li a").each(function(name, id){
			name.observe("click", this.deleteFire.bind(this));
		}.bind(this));
	},
	
	/**
	 * Event Document Click
	 */
	eventDocumentClick: function(event){
		var isList = false;
		event.element().ancestors().each(function(name, id){
			if(name == this.container || name == this.liste){
				isList = true;
			}
		}.bind(this));
		if(!isList){
			this.liste.hide();
		}
	},
	
	/**
	 * Event Input Focus
	 */
	eventInputFocus: function(event){
		if(this.input.getValue() == ""){
			this.updateList("");
		} else {
			this.liste.show();
		}
	},
	
	/**
	 * Event Container Click
	 * Focus sur input au clic
	 */
	eventContainerClick: function(event){
		this.input.focus();
	},
	
	
	/**
	 * Input --Down-- Fire 
	 */
	inputDownFire: function(event) {
		var element = event.element();
		if(event.keyCode == 40){
			// ---- Descendre le selecteur ---
			event.stop();
			this.moveSelected("DOWN");
		
		} else if(event.keyCode == 38){
			// --- Monter le selecteur ---
			event.stop();
			this.moveSelected("UP");	
								
		} else if(event.keyCode == 13){
			// --- Touche Entrer ---
			event.stop();
			this.enterFire();
			
		} else if(event.keyCode == 8 && this.input.getValue() == ""){
			// --- Touche Retour arrière ---
			/*
			var last = $$("#"+this.elemMultipleUL+" li:not(.autocompleteText)").last();
			if(last != undefined){
				var id = last.down("a").getAttribute("href").split('#');
				id = id[1].substr(2);
				this.deleteItem(id);
			}
			*/
		}
	},
	
	
	/**
	 * Move selector 
	 */
	moveSelected: function(direction){
		$$("#"+this.elemMultipleList+" ul li a.selected").each(function(name, id){
			var nextItem;
			if( direction == "UP"){
				// -- MONTER --
				nextItem = name.up("li").previous("li:not(.hidden)");
			} else if( direction == "DOWN" ){
				// -- DESCENDRE --
				nextItem = name.up("li").next("li:not(.hidden)");
			}
			if(nextItem != undefined){	
				nextItem.down("a").addClassName("selected");	
				name.removeClassName("selected");
			}
		});
	},
	
	/**
	 * Ajout d'un item
	 */
	clickAddItem: function(){
		var label = $(this.elemMultipleInput).value;
		
		
		$('multipleAddItem'+this.fieldName).innerHTML = 'Ajout en cours...';
		$('multipleAddItem'+this.fieldName).addClassName('multipleAddItemLoading');
		
		new Ajax.Request(this.addService, {
			  parameters: {label: label},
			  onSuccess: function(transport){
				  $(this.elemMultipleInput).value = '';
				  $('multipleAddItem'+this.fieldName).remove();
				  
			      res = transport.responseText;
			      this.addItem(label, res);
			      // on vide le cache
			      this.cachedResults = new Array();
			  }.bind(this).bind(label)
		});
	},
	
	/**
	 * Enter Fire 
	 */
	enterFire: function() {
		$$("#"+this.elemMultipleList+" ul li a.selected").each(function(name, id){
			// recupere les infos de lelement
			var itemName = name.innerHTML;
			var itemId = name.getAttribute("href").split("#");
			var itemId = itemId[1].split("_");
			if(itemId[0] == 'add'){
				this.clickAddItem();
			} else {
				itemId = itemId["1"];
				this.addItem(itemName, itemId);
			}
			
		}.bind(this));
	},
	
	/**
	 * Click Item 
	 */
	clickItem: function(event) {
		// recupere les infos de lelement
		var itemName = event.element().innerHTML;
		var itemId = event.element().getAttribute("href").split("#");
		itemId = itemId[1].split("_");
		itemId = itemId["1"];
		
		this.addItem(itemName, itemId);
	},
	
	
	/**
	 * Add Item 
	 */
	addItem: function(itemName, itemId) {
		if($(this.elemMultipleLi+this.fieldName+'_'+itemId) != null){
			this.deleteItem(this.fieldName+'_'+itemId);
		}
		
		var newItem = '<li id="'+this.elemMultipleLi+this.fieldName+'_'+itemId+'" class="multipleLiElement">'+itemName+' <a href="#n_'+this.fieldName+'_'+itemId+'">'+this.opt['deleteImage']+'</a></li>';
		this.input.up("li").insert({before: newItem});
		
		// Event sur delete
		this.input.up("li").previous().down("a").observe("click", this.deleteFire.bind(this));
		this.input.clear();
		this.liste.hide();
		this.input.focus();
		
		this.selectById(itemId);
		this.lastFilter = "";
		this.initSortable();
	},
	

	
	
	/**
	 * Select Item in List ==================================
	 */
	selectById: function(id, select){
		if(select == undefined){
			select = true;
		}
		//id = id.replace('_', '');
		
		if(select == false){
			// Suppression
			$(id).remove();
		} else {
			// Ajout
			var fieldName = this.newFieldName.replace('{id}', id);
			
			$(this.elemMultipleHiddenFieldContainer).insert(
					'<input type="text" id="'+this.fieldName+'_'+id+'" value="-1" name="'+fieldName+'">'
			);
		}
		
	},
	
	
	/**
	 * Delete Fire ==================================
	 */
	deleteFire: function(event){
		var id = event.element().up("a").getAttribute("href").split("#");
		id= id[1].split("_");
		id = id[1]+'_'+id[2];
		this.deleteItem(id);
	},
	
	/**
	 * Delete Item ==================================
	 * Suppression cadre bleu
	 */
	deleteItem: function(id){
		$(this.elemMultipleLi  + id).remove();
		this.selectById(id, false);
	},
	
	
	/**
	 * Input Fire ==================================
	 */
	inputFire: function(event) {
		var element = event.element();
		if(event.keyCode != 40 && event.keyCode != 38 && event.keyCode != 13){
			this.updateListTemp(element.getValue());
		}
	},
	
	/**
	 * Update List Temp====================================
	 */
	updateListTemp: function(filter){
		clearTimeout(this.updateListeTimer);
		this.updateListeTimer = setTimeout(function(){
			this.updateList(filter);
		}.bind(this).bind(filter),250);
	},
		
	/**
	 * Update List ====================================
	 */
	updateList: function(filter){
		// Ul
		elemUl = $$('#'+this.elemMultipleList+' ul');
		elemUl = elemUl[0];
		
		// Si un filtre :
		if(filter != '.*' && filter != ''){
			if(!this.cachedResults[filter]){
				// image loading
				$$('.multipleImageLoading').invoke('hide');
				elemUl.insert({top:'<li class="multipleImageLoading">Chargement...</li>'});
				this.liste.show();
				
				var ajaxResponse;
				new Ajax.Request(this.dataProviderUrl, {
					  parameters: {query: filter},
					  evalJSON: 'force',
					  onSuccess: function(transport){
					      ajaxResponse = transport.responseJSON;
					      this.cachedResults[filter] = ajaxResponse;
					      this.updateListWithResults(ajaxResponse);
					  }.bind(this).bind(filter)
				});
			} else if(this.cachedResults[filter]){
				this.updateListWithResults(this.cachedResults[filter]);
			}
		} else{
			// Vide la liste
			var liste = $$('#'+this.elemMultipleList+' ul li');
			if(liste){
				liste.invoke('remove');
			}
		}
	},
	
	/**
	 * Update Liste With results
	 */
	updateListWithResults: function(result){
		// Vide la liste
		var liste = $$('#'+this.elemMultipleList+' ul li');
		if(liste){
			liste.invoke('remove');
		}
		
		var selected = '';
		
		// Ul
		elemUl = $$('#'+this.elemMultipleList+' ul');
		elemUl = elemUl[0];
		
		// Résultats ?
		resultLen = result.length;
		if(resultLen > 0){
			// Parcours du résultat
		    for(var i=0; i<resultLen; i++) {
		    	element = result[i];
		    	if(i==0){
		    		selected = 'selected';
		    	} else {
		    		selected = '';
		    	}
				elemUl.insert('<li><a href="#n_'+element.id+'" class="'+selected+' '+element.className+'">'+element.label+'</a></li>');
		    }
		    
		    $$("#"+this.elemMultipleList+" ul li a").each(function(name, id){
		    	name.observe("click", this.clickItem.bind(this));
		    }.bind(this));
		    
		    selected = '';
		} else {
			// Pas de resultats
			selected = 'selected';
		}
		//elemUl.insert('<li><a href="#add" id="multipleAddItem'+this.fieldName+'" class="'+selected+' multipleAddItem">Ajouter <em>'+	$(this.elemMultipleInput).value +'</em></a></li>');
		//$('multipleAddItem'+this.fieldName).observe("click", this.clickAddItem.bind(this));
		this.liste.show();
	}
	
	
});
