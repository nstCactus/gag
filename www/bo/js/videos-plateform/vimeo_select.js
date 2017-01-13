var VimeoSelect = Class.create({
	/**
	 * initialize
	 * Constructeur
	 */
	initialize: function(elementId, vimeoGetChannelsUrl, vimeoGetVideosByChannelUrl, vimeoGetVideoUrl) {
		this.elementId = elementId;
		this.cacheJsonChannels;
		this.cacheJsonVideosByChannel = [];
		this.cacheJsonVideosInfos = [];
		this.vimeoGetChannelsUrl = vimeoGetChannelsUrl;
		this.vimeoGetVideosByChannelUrl = vimeoGetVideosByChannelUrl;
		this.vimeoGetVideoUrl = vimeoGetVideoUrl;
		
		document.observe("dom:loaded", this.getChannels.bind(this));
	},
	
	
	
	
	/**
	 * getChannels
	 * Load channels
	 */
	getChannels: function(){
		// Cache la liste
		$('vimeoSelect_channelContainer_'+this.elementId).hide();

		if(this.cacheJsonChannels == undefined){
			// Pas de cache: Ajax
			$('vimeoSelect_loading_'+this.elementId).show();
			
			new Ajax.Request(this.vimeoGetChannelsUrl, {
				evalJSON: 'force',
				onSuccess: function(transport){
					this.fillVideoChannel(transport.responseJSON).bind(this);
					this.cacheJsonChannels = transport.responseJSON;
				  }.bind(this)
			});
		} else {
			// Version cache
			this.fillVideoChannel(this.cacheJsonChannels);
		}
	},
	
	/**
	 * getVideos
	 * Récupère la liste des videos d'un channel
	 */
	getVideos: function(){
		// Cache la liste des videos et infos video
		$('vimeoSelect_videoContainer_'+this.elementId).hide(); 
		$('vimeoSelect_videoInfoContainer_'+this.elementId).hide(); 

		// Ref
		var channelId = $('vimeoSelect_channelList_'+this.elementId).value;
		
		// Si un channel sélectionné
		if(channelId != '-1'){
			if(this.cacheJsonVideosByChannel['channel-'+channelId] == undefined){
				// Pas de cache
				$('vimeoSelect_loading_'+this.elementId).show();
				
				// Requete AJAX
				new Ajax.Request(this.vimeoGetVideosByChannelUrl + '/channel:'+channelId, {
					evalJSON: 'force',
					onSuccess: function(transport){
						this.fillVideoList(transport.responseJSON).bind(this);
						this.cacheJsonVideosByChannel['channel-'+channelId] = transport.responseJSON;
					  }.bind(this)
				});
			} else {
				// En cache
				this.fillVideoList(this.cacheJsonVideosByChannel['channel-'+channelId]);	
			}
		}
	},
	
	getVideo: function(){
		$('vimeoSelect_videoInfoContainer_'+this.elementId).hide(); 
		$('vimeoSelect_loading_'+this.elementId).show();

		var videoId = $('vimeoSelect_videoList_'+this.elementId).value;
		new Ajax.Request(this.vimeoGetVideoUrl + '/video:'+videoId, {
			evalJSON: 'force',
			onSuccess: function(transport){
				this.fillVideoInfoAjax(transport.responseJSON);
			  }.bind(this)
		});
	},
	
	/**
	 * Init Video Observer
	 */
	initVideoObserver: function(elemId){
		// Info videos
		$('multipleMediaAddVimeoVideoList_'+this.multipleMediaElementCounter).observe('change', function(){
			this.fillVideoInfoAjax(elemId);
		}.bind(this).bind(elemId));
	},
	
	
	/**
	 * fillVideoChannel
	 * Remplir la liste des channels
	 */
	fillVideoChannel: function(json, elemId){
		resultLen = json.length;
		for(var i=0; i<resultLen; i++) {
			$('vimeoSelect_channelList_'+this.elementId).insert('<option value="'+json[i].id+'">'+json[i].label+'</option>');
		}
		$('vimeoSelect_channelList_'+this.elementId).selectedIndex = 0;
		$('vimeoSelect_loading_'+this.elementId).hide();
		$('vimeoSelect_channelContainer_'+this.elementId).show();
		
		// Active observer
		$('vimeoSelect_channelList_'+this.elementId).observe('change', this.getVideos.bind(this));
	},

	
	/**
	 * fillVideoList
	 * Remplir la liste des videos
	 */
	fillVideoList: function(json){
		resultLen = json.length;
		
		// Vide la liste des videos
		$$('#vimeoSelect_videoList_'+this.elementId+' option').invoke('remove');
		
		// Remplir la liste
		for(var i=0; i<resultLen; i++) {
			$('vimeoSelect_videoList_'+this.elementId).insert('<option value="'+json[i].id+'">'+json[i].label+'</option>');
		}
		$('vimeoSelect_videoList_'+this.elementId).selectedIndex = 0;
		$('vimeoSelect_loading_'+this.elementId).hide();
		$('vimeoSelect_videoContainer_'+this.elementId).show();
		this.getVideo();
		
		// Active observer
		$('vimeoSelect_videoList_'+this.elementId).observe('change', this.getVideo.bind(this));
	},

	
	/**
	 * fillVideoInfoAjax
	 * remplir les infos AJAX
	 */
	fillVideoInfoAjax: function(json){
		$('vimeoSelect_videoInfoLink_'+this.elementId).writeAttribute('href', json.url); 
		$('vimeoSelect_videoInfoWidth_'+this.elementId).value = json.width; 
		$('vimeoSelect_videoInfoHeight_'+this.elementId).value = json.height; 
		$('vimeoSelect_videoInfoThumb_'+this.elementId).value = json.thumb; 
		$('vimeoSelect_videoInfoTitle_'+this.elementId).value = json.title; 
		$('vimeoSelect_videoInfoDescription_'+this.elementId).value = json.description; 
		$('vimeoSelect_videoInfoDuration_'+this.elementId).value = json.duration; 
		
		$('vimeoSelect_videoInfoContainer_'+this.elementId).show(); 
		$('vimeoSelect_loading_'+this.elementId).hide();
	}
});