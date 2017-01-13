var Slug = Class.create({
	/**
	 * Constructeur
	 */
	initialize: function(ajaxCallback, model, currentId, contentLangCode, referenceField, action, slugField, scope, formId) {
		this.ajaxCallback = ajaxCallback;
		this.model = model;
		this.currentId = currentId;
		this.contentLangCode = contentLangCode;
		this.referenceField = referenceField;
		this.action = action;
		this.slugField = slugField;
		this.scope = scope;
		this.formId = formId;
		
		document.observe("dom:loaded", this.initObserve.bind(this));
	},

	
	/**
	 * Initialisation
	 */
	initObserve: function() {
		if(this.action == 'add'){
			// Reference
			this.referenceField.each(function(name, id){
				$(name).observe('change', this.referenceChanged.bind(this));
			}.bind(this));
			
		}

		// Scope change
		this.scope.each(function(name, id){
			var that = this;
			$(name).observe('change', function(event){
				that.slugField.each(function(name, id){
					that.slugChanged($(name));
				});
			}.bind(this));
		}.bind(this));
		
		
		// Slug change
		this.slugField.each(function(name, id){
			var that = this;
			$(name).observe('change', function(event){
				var element = event.element();
				that.slugChanged(element);
			});
		}.bind(this));
	},

	/**
	 * Input reference changed
	 */
	referenceChanged: function(){
		// Loading
		this.slugField.each(function(name, id){
			$(name).previous().addClassName('loading');
		});
		
		// Reference value
		var referenceValue = '';
		this.referenceField.each(function(name, id){
			referenceValue += $(name).value+' ';
		});
		referenceValue = this.trim(referenceValue);

		// Request
		this.getSlug(referenceValue, function(slug){
			this.slugField.each(function(name, id){
				$(name).value = slug;
				$(name).previous().removeClassName('loading');
			});
		}.bind(this));
	},

	/**
	 * Input slug modifié
	 */
	slugChanged: function(element){
		// Loading
		var label = element.previous();
		label.addClassName('loading');
		
		// Request
		this.getSlug(element.value, function(slug){
			element.value = slug;
			label.removeClassName('loading');
		}.bind(this));
	},
	
	
	/**
	 * Get Slug
	 */
	getSlug: function(value, callback){
		new Ajax.Request(this.ajaxCallback, {
			parameters: {model: this.model, currentId: this.currentId, contentLangCode: this.contentLangCode, referenceValue: value, allForm: Object.toJSON($(this.formId).serialize(true))},
			onSuccess: function(transport){
				var res = transport.responseText;
				callback(res);
			  }.bind(this)
		});
	},
	
	trim: function(myString){ 
		return myString.replace(/^\s+/g,'').replace(/\s+$/g,'');
	} 
	
});


