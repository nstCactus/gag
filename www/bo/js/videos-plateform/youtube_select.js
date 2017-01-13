var YoutubeSelect = Class.create({
	/**
	 * initialize
	 * Constructeur
	 */
	initialize: function(elementId, youtubeGetPlaylistListUrl, youtubeGetVideosFromPlaylistUrl, youtubeGetVideoUrl) {
		this.elementId = elementId;
		this.cacheJsonPlaylistList;
		this.cacheJsonVideosFromPlaylist = [];
		this.cacheJsonVideosInfos = [];
		this.youtubeGetPlaylistListUrl = youtubeGetPlaylistListUrl;
		this.youtubeGetVideosFromPlaylistUrl = youtubeGetVideosFromPlaylistUrl;
		this.youtubeGetVideoUrl = youtubeGetVideoUrl;
		
		document.observe("dom:loaded", this.getPlaylistList.bind(this));
	},
	
	/**
	 * getChannels
	 * Load channels
	 */
	getPlaylistList: function(){
		
		// Cache la liste
		$('youtubeSelect_playlistContainer_'+this.elementId).hide();
		
		if(this.cacheJsonPlaylistList == undefined){
			// Pas de cache: Ajax
			$('youtubeSelect_loading_'+this.elementId).show();
			
			new Ajax.Request(this.youtubeGetPlaylistListUrl, {
				evalJSON: 'force',
				onSuccess: function(transport){
					this.fillVideoPlaylist(transport.responseJSON).bind(this);
					this.cacheJsonPlaylistList = transport.responseJSON;
				  }.bind(this)
			});
		} else {
			// Version cache
			this.fillVideoPlaylist(this.cacheJsonPlaylistList);
		}
	},
	
	/**
	 * getVideos
	 * Récupère la liste des videos d'une playlist
	 */
	getVideos: function(){
		// Cache la liste des videos et infos video
		$('youtubeSelect_videoContainer_'+this.elementId).hide(); 
		$('youtubeSelect_videoInfoContainer_'+this.elementId).hide(); 

		// Ref
		var playlistId = $('youtubeSelect_playlistList_'+this.elementId).value;
		
		// Si une playlist est sélectionnée
		if(playlistId != '-1'){
			if(this.cacheJsonVideosFromPlaylist['playlist-'+playlistId] == undefined){
				// Pas de cache
				$('youtubeSelect_loading_'+this.elementId).show();
				
				// Requete AJAX
				new Ajax.Request(this.youtubeGetVideosFromPlaylistUrl + '/playlist:'+playlistId, {
					evalJSON: 'force',
					onSuccess: function(transport){
						this.fillVideoList(transport.responseJSON).bind(this);
						this.cacheJsonVideosFromPlaylist['playlist-'+playlistId] = transport.responseJSON;
					  }.bind(this)
				});
			} else {
				// En cache
				this.fillVideoList(this.cacheJsonVideosFromPlaylist['playlist-'+playlistId]);	
			}
		}
	},
	
	getVideo: function(){
		$('youtubeSelect_videoInfoContainer_'+this.elementId).hide(); 
		$('youtubeSelect_loading_'+this.elementId).show();

		var videoId = $('youtubeSelect_videoList_'+this.elementId).value;
		new Ajax.Request(this.youtubeGetVideoUrl + '/video:'+videoId, {
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
		$('multipleMediaAddYoutubeVideoList_'+this.multipleMediaElementCounter).observe('change', function(){
			this.fillVideoInfoAjax(elemId);
		}.bind(this).bind(elemId));
	},
	
	
	/**
	 * fillVideoPlaylist
	 * Remplir la liste des playlist
	 */
	fillVideoPlaylist: function(json, elemId){
		resultLen = json.length;
		for(var i=0; i<resultLen; i++) {
			$('youtubeSelect_playlistList_'+this.elementId).insert('<option value="'+json[i].id+'">'+json[i].label+'</option>');
		}
		$('youtubeSelect_playlistList_'+this.elementId).selectedIndex = 0;
		$('youtubeSelect_loading_'+this.elementId).hide();
		$('youtubeSelect_playlistContainer_'+this.elementId).show();
		
		// Active observer
		$('youtubeSelect_playlistList_'+this.elementId).observe('change', this.getVideos.bind(this));
	},

	
	/**
	 * fillVideoList
	 * Remplir la liste des videos
	 */
	fillVideoList: function(json){
		resultLen = json.length;
		
		// Vide la liste des videos
		$$('#youtubeSelect_videoList_'+this.elementId+' option').invoke('remove');
		
		// Remplir la liste
		for(var i=0; i<resultLen; i++) {
			$('youtubeSelect_videoList_'+this.elementId).insert('<option value="'+json[i].id+'">'+json[i].label+'</option>');
		}
		$('youtubeSelect_videoList_'+this.elementId).selectedIndex = 0;
		$('youtubeSelect_loading_'+this.elementId).hide();
		$('youtubeSelect_videoContainer_'+this.elementId).show();
		this.getVideo();
		
		// Active observer
		$('youtubeSelect_videoList_'+this.elementId).observe('change', this.getVideo.bind(this));
	},

	/**
	 * fillVideoInfoAjax
	 * remplir les infos AJAX
	 */
	fillVideoInfoAjax: function(json){
		$('youtubeSelect_videoInfoLink_'+this.elementId).writeAttribute('href', json.url); 
		
		/*
		$('youtubeSelect_videoInfoWidth_'+this.elementId).value = json.width; 
		$('youtubeSelect_videoInfoHeight_'+this.elementId).value = json.height; 
		$('youtubeSelect_videoInfoThumb_'+this.elementId).value = json.thumb; 
		$('youtubeSelect_videoInfoTitle_'+this.elementId).value = json.title; 
		$('youtubeSelect_videoInfoDescription_'+this.elementId).value = json.description; 
		$('youtubeSelect_videoInfoDuration_'+this.elementId).value = json.duration; 
		*/
		
		$('youtubeSelect_videoInfoContainer_'+this.elementId).show(); 
		$('youtubeSelect_loading_'+this.elementId).hide();
	}
});