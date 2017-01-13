var MultipleMedia = Class.create({
	/**
	 * Constructeur
	 */
	initialize: function(model, forms, videoChannelProviderUrl, videoProviderUrl, videoInfoProviderUrl) {
		this.modelName = model;
		this.forms = forms;
		this.multipleMediaElementCounter = 0;
		this.multipleMediaChannelJsonCache;
		this.multipleMediaVideoJsonCache;
		this.videoChannelProviderUrl = videoChannelProviderUrl;
		this.videoProviderUrl = videoProviderUrl;
		this.videoInfoProviderUrl = videoInfoProviderUrl;
		
		document.observe("dom:loaded", this.initObserve.bind(this));
	},

	
	/**
	 * Initialisation
	 */
	initObserve: function() {
		$('multipleMediaAddElementFormSubmit_'+this.modelName).observe('click', this.addElement.bind(this));
	},

	addElement: function(){
		this.multipleMediaElementCounter++; 
		var type = $('multipleMediaAddFormList_'+this.modelName).value;
		
		var syntax = /(^|.|\r|\n)(\{\s*(\w+)\s*\})/;
		var template = new Template(this.forms[type],syntax);
		var data = {
			model: this.modelName,
			counter: this.multipleMediaElementCounter
		};
		// INSERT FORM
		// -----------
		$('multipleMediaAddElementForm_'+this.modelName).insert({
			before: template.evaluate(data)
		});
		
		/*
		 * SPECIFIC SCRIPT
		 */
		if(type == 'youtube' || type == 'vimeo' || type == 'dailymotion'){
			$('multipleMediaAddVimeoLoading_'+this.multipleMediaElementCounter).show();
			this.initVideoObserver(this.multipleMediaElementCounter);
		}
	},
	
	
	/**
	 * Init Video Observer
	 */
	initVideoObserver: function(elemId){
		// Chargement des channels
		if(this.multipleMediaChannelJsonCache == undefined){
			new Ajax.Request(this.videoChannelProviderUrl, {
				evalJSON: 'force',
				onSuccess: function(transport){
					json = transport.responseJSON;
					if('error' in json){
						// Error
						$('multipleMediaAddVimeoLoading_'+elemId).replace('Erreur : ' + json.error);
					} else {
						// Success
						this.fillVideoChannel(json, elemId);
						this.multipleMediaChannelJsonCache = json;
					}
				  }.bind(this).bind(elemId)
			});
		} else {
			// Version cache
			this.fillVideoChannel(this.multipleMediaChannelJsonCache, elemId);
		}

		// Chargement des videos
		$('multipleMediaAddVimeoChannelList_'+elemId).observe('change', function(){
			$('multipleMediaAddVimeoVideo_'+elemId).hide(); 
			$('multipleMediaAddVimeoVideoInfo_'+elemId).hide(); 

			var list = $('multipleMediaAddVimeoChannelList_'+elemId);
			channelId = list.value;
			if(channelId != '-1'){
				$('multipleMediaAddVimeoLoading_'+elemId).show();
				
				new Ajax.Request(this.videoProviderUrl + '/channel:'+channelId, {
					evalJSON: 'force',
					onSuccess: function(transport){
						json = transport.responseJSON;
						this.fillVideoList(json, elemId);
						this.multipleMediaVideoJsonCache[channelId] = json;
					  }.bind(this).bind(elemId)
				});
			}
		}.bind(this).bind(elemId));

		// Info videos
		$('multipleMediaAddVimeoVideoList_'+this.multipleMediaElementCounter).observe('change', function(){
			this.fillVideoInfoAjax(elemId);
		}.bind(this).bind(elemId));
	},
	
	
	/**
	 * Remplir la liste des channels
	 */
	fillVideoChannel: function(json, elemId){
		resultLen = json.length;
		for(var i=0; i<resultLen; i++) {
			$('multipleMediaAddVimeoChannelList_'+elemId).insert('<option value="'+json[i].id+'">'+json[i].label+'</option>');
		}
		$('multipleMediaAddVimeoChannelList_'+elemId).selectedIndex = 0;
		$('multipleMediaAddVimeoLoading_'+elemId).hide();
		$('multipleMediaAddVimeoChannel_'+elemId).show();
	},

	
	/**
	 * Remplir la liste des videos
	 */
	fillVideoList: function(json, elemId){
		resultLen = json.length;
		$$('#multipleMediaAddVimeoVideoList_'+elemId+' option').invoke('remove');
		for(var i=0; i<resultLen; i++) {
			$('multipleMediaAddVimeoVideoList_'+elemId).insert('<option value="'+json[i].id+'">'+json[i].label+'</option>');
		}
		$('multipleMediaAddVimeoVideoList_'+elemId).selectedIndex = 0;
		$('multipleMediaAddVimeoLoading_'+elemId).hide();
		$('multipleMediaAddVimeoVideo_'+elemId).show();
		this.fillVideoInfoAjax(elemId);
	},

	/**
	 * remplir les infos AJAX
	 */
	fillVideoInfoAjax: function(elemId){
		$('multipleMediaAddVimeoVideoInfo_'+elemId).hide(); 
		$('multipleMediaAddVimeoLoading_'+elemId).show();

		var videoList = $('multipleMediaAddVimeoVideoList_'+elemId);
		videoId = videoList.value;
		
		new Ajax.Request(this.videoInfoProviderUrl + '/video:'+videoId, {
			evalJSON: 'force',
			onSuccess: function(transport){
				json = transport.responseJSON;
				$('multipleMediaAddVimeoVideoInfoLink_'+elemId).writeAttribute('href', json.url); 
				$('multipleMediaAddVimeoVideoInfoThumb_'+elemId).writeAttribute('value', json.thumb); 
				$('multipleMediaAddVimeoVideoInfoWidth_'+elemId).writeAttribute('value', json.width); 
				$('multipleMediaAddVimeoVideoInfoHeight_'+elemId).writeAttribute('value', json.height); 
				$('multipleMediaAddVimeoVideoInfo_'+elemId).show(); 
				$('multipleMediaAddVimeoLoading_'+elemId).hide();
			  }.bind(this)
		});
	}
});