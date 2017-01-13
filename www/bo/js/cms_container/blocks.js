jQuery(function($){

	// ==== DOM ====
	$addBlockButton = $('#cmsContainerAddBlockButton');
	$addBlockSelect = $('#cmsContainerAddBlockSelect');
	$blockContainer = $('#blockContainer');
	delBlockButton = '.cmsContainerDelBlockButton';
	editBlockButton = '.cmsContainerEditBlockButton';
	
	
	// ==== Events =====
	$addBlockButton.on('click', addBlockButtonClick);
	$(delBlockButton).on('click', delBlockButtonClick);
	$(editBlockButton).on('click', editBlockButtonClick);
	
	
	// ==== Events handlers ====
	/**
	 * addBlockButtonClick
	 */
	function addBlockButtonClick(){
		// Block sélectionné
		selectedBlock = $addBlockSelect.val();
		addBlock(selectedBlock);
	}
	
	
	function delBlockButtonClick(blockLink){
		if( ! window.confirm('Are you sure you want to delete this item?')){
			return false;
		}

		var blockContainer = $(blockLink.currentTarget).parents('fieldset.blockItem');
		deleteBlock(blockContainer);
	}

	function editBlockButtonClick(blockLink){
		var blockContainer = $(blockLink.currentTarget).parents('fieldset.blockItem');
		if(blockContainer.hasClass('notOpen')){
			openBlock(blockContainer);
		}
		else {
			closeBlock(blockContainer);
		};
	}
	// ==== Functions ====
	
	/**
	 * Ajouter un block
	 */
	function addBlock(blockName){
		serviceGetBlock(blockName);
	}
	
	/**
	 * Récupère un block sur le serveur
	 * AJAX
	 */
	function serviceGetBlock(blockName){
		// On n'a pas l'url du service
		if(serviceBlockFactory == undefined){
			alert('serviceBlockFactory n\'est pas défini');
		}
		
		// Requete AJAX
		blockCounter++;
		$.ajax({
			url: serviceBlockFactory + '/' + blockName + '?blockCounter='+blockCounter+'&cmsContainerId='+cmsContainerId,
			success: function(data){
				$blockContainer.append(data);
				document.fire('tabsI18N:init');
				document.fire('ck:init');
				blocksOnChange();
				bindBlocksControls();
			}
		});
	}
	
	function blocksOnChange(){
		reorderRank();
	}
	
	function bindBlocksControls(){
		$(delBlockButton).on('click', delBlockButtonClick);
		$(editBlockButton).on('click', editBlockButtonClick);
	}

	/**
	 * Réordonne les rank
	 */
	function reorderRank(){
		var rank = 0;
		$('.blockItem .blockRankField').each(function(){
			rank++;
			$(this).val(rank);
		});
	}

	/**
	 * Delete un block
	 */
	function deleteBlock(blockElem){
		blockElem.fadeOut('slow',function(){
			blockElem.remove();
		})
	}

	/**
	 * Ouvrir un block
	 */
	function openBlock(blockElem){
		blockElem.removeClass('notOpen');
	}

	
	/**
	 * Fermer un block
	 */
	function closeBlock(blockElem){
		blockElem.addClass('notOpen');
	}

});