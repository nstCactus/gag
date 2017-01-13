var DailymotionSelect = Class.create({
	/**
	 * initialize
	 * Constructeur
	 */
	initialize: function(elementId, dailymotionGetVideosListUrl, dailymotionGetVideoUrl) {
		this.elementId = elementId;
		this.cacheJsonVideosList;
		this.cacheJsonVideosInfos;
		this.dailymotionGetVideosListUrl = dailymotionGetVideosListUrl;
		this.dailymotionGetVideoUrl = dailymotionGetVideoUrl;
		
		document.observe("dom:loaded", this.getVideos.bind(this));
	},
		
	/**
	 * getVideos
	 * Récupère la liste des videos
	 */
	getVideos: function() {
		// Cache la liste des videos et infos video
		$('dailymotionSelect_videoContainer_'+this.elementId).hide(); 
		$('dailymotionSelect_videoInfoContainer_'+this.elementId).hide(); 

		// Si une liste de videos est sélectionnée
		if(this.cacheJsonVideosList == undefined){
			// Pas de cache
			$('dailymotionSelect_loading_'+this.elementId).show();
			
			// Requete AJAX
			new Ajax.Request(this.dailymotionGetVideosListUrl, {
				evalJSON: 'force',
				onSuccess: function(transport){
					this.fillVideoList(transport.responseJSON).bind(this);
					this.cacheJsonVideosList = transport.responseJSON;
				  }.bind(this)
			});
			} else {
				// En cache
				this.fillVideoList(this.cacheJsonVideosList);	
			}
	},
	
	getVideo: function(){
		$('dailymotionSelect_videoInfoContainer_'+this.elementId).hide(); 
		$('dailymotionSelect_loading_'+this.elementId).show();

		var videoUrl = $('dailymotionSelect_videoList_'+this.elementId).value;
		this.fillVideoInfoAjax(videoUrl);
	},
	
	/**
	 * Init Video Observer
	 */
	initVideoObserver: function(elemId){
		// Info videos
		$('multipleMediaAddDailymotionVideoList_'+this.multipleMediaElementCounter).observe('change', function(){
			this.fillVideoInfoAjax(elemId);
		}.bind(this).bind(elemId));
	},
	
	/**
	 * fillVideoList
	 * Remplir la liste des videos
	 */
	fillVideoList: function(json){
		resultLen = json.length;
		
		// Vide la liste des videos
		$$('#dailymotionSelect_videoList_'+this.elementId+' option').invoke('remove');
		
		// Remplir la liste
		for(var i=0; i<resultLen; i++) {
			$('dailymotionSelect_videoList_'+this.elementId).insert('<option value="'+json[i].url+'">'+json[i].label+'</option>');
		}
		$('dailymotionSelect_videoList_'+this.elementId).selectedIndex = 0;
		$('dailymotionSelect_loading_'+this.elementId).hide();
		$('dailymotionSelect_videoContainer_'+this.elementId).show();
		this.getVideo();
		
		// Active observer
		$('dailymotionSelect_videoList_'+this.elementId).observe('change', this.getVideo.bind(this));
	},

	/**
	 * fillVideoInfoAjax
	 * remplir les infos AJAX
	 */
	fillVideoInfoAjax: function(videoUrl) {
		$('dailymotionSelect_videoInfoLink_'+this.elementId).writeAttribute('href', videoUrl); 
		$('dailymotionSelect_videoInfoContainer_'+this.elementId).show(); 
		$('dailymotionSelect_loading_'+this.elementId).hide();
	}
});