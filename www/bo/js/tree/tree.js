(function($){
	$.fn.tree = function(params){
		//params.changeServiceURL
		
		this.each(function(){
			
			// ==== DOM ====
			$treeContainer = $(this);
			$treeInner = $treeContainer.select('.treeIndexTree');
			
			// ==== INIT ====
			$treeContainer.treeDragDrop();
			
			// ==== EVENTS ====
			// Node position change
			$treeContainer.on('position:change', positionChangeHandler);

			
		});
		
		/**
		 * Position change handler
		 */
		function positionChangeHandler(event, data)
		{
			$treeContainer.off('position:change', positionChangeHandler);
			
			$treeContainer.css('visibility', 'hidden');
			
			$.ajax({
			  type: "POST",
			  url: params.changeServiceURL,
			  data: data
			}).done(function(treeDOM) {
				$treeInner.html(treeDOM);
				$treeContainer.tree(params);
				$treeContainer.css('visibility', 'visible');
			});
		}
	};
})(jQuery);
