var DailymotionCloudSelect = Class.create({
	/**
	 * initialize
	 * Constructeur
	 */
	initialize: function(elementId, dailymotionCloudGetVideosListUrl, dailymotionCloudGetVideoUrl) {
		this.elementId = elementId;
		this.cacheJsonVideosList;
		this.cacheJsonVideosInfos;
		this.dailymotionCloudGetVideosListUrl = dailymotionCloudGetVideosListUrl;
		this.dailymotionCloudGetVideoUrl = dailymotionCloudGetVideoUrl;
		
		document.observe("dom:loaded", this.getVideos.bind(this));
	},
	
	/**
	 * getVideos
	 * Récupère la liste des videos
	 */
	getVideos: function() {
		
		// Cache la liste des videos et infos video
		$('dailymotionCloudSelect_videoContainer_'+this.elementId).hide(); 

		// Si une liste de vidéo est sélectionnée
		if(this.cacheJsonVideosList == undefined){
			// Pas de cache
			$('dailymotionCloudSelect_loading_'+this.elementId).show();
			
			// Requete AJAX
			new Ajax.Request(this.dailymotionCloudGetVideosListUrl, {
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
		var videoId = $('dailymotionCloudSelect_videoList_'+this.elementId).value;
		
		// Si une vidéo est sélectionnée
		if(videoId != '-1'){
			$('dailymotionCloudSelect_loading_'+this.elementId).show();
			new Ajax.Request(this.dailymotionCloudGetVideoUrl + '/video:'+videoId, {
				evalJSON: 'force',
				onSuccess: function(transport){
					this.fillVideoInfoAjax(transport.responseJSON);
				  }.bind(this)
			});
		}
	},
	
	/**
	 * fillVideoList
	 * Remplir la liste des videos
	 */
	fillVideoList: function(json){
		resultLen = json.length;
		
		// Vide la liste des videos
		$$('#dailymotionCloudSelect_videoList_'+this.elementId+' option').invoke('remove');
		
		// Remplir la liste
		for(var i=0; i<resultLen; i++) {
			$('dailymotionCloudSelect_videoList_'+this.elementId).insert('<option value="'+json[i].id+'">'+json[i].label+'</option>');
		}
		$('dailymotionCloudSelect_videoList_'+this.elementId).selectedIndex = 0;
		$('dailymotionCloudSelect_loading_'+this.elementId).hide();
		$('dailymotionCloudSelect_videoContainer_'+this.elementId).show();
		this.getVideo();
		
		// Active observer
		$('dailymotionCloudSelect_videoList_'+this.elementId).observe('change', this.getVideo.bind(this));
	},
	
	/**
	 * fillVideoInfoAjax
	 * remplir les infos AJAX
	 */
	fillVideoInfoAjax: function(videoInfoJSON) {
		$('dailymotionCloudSelect_videoInfoContainer_'+this.elementId).value =  Object.toJSON(videoInfoJSON);
		$('dailymotionCloudSelect_loading_'+this.elementId).hide();
	}
});