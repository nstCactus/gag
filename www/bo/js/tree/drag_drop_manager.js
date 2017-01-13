(function($){
	$.fn.treeDragDrop = function(params){
		this.each(function(){
			
			// ==== DOM ====
			var $treeContainer = $(this);
			var $dropZones = $treeContainer.find('.treeDropZone');
			var $lines = $treeContainer.find('.treeIndexLine');
			var $allowedDropZones = null;
			var firePositionChangeTimer = null;
			var stopRevert = false;
			
			$dropZones.fadeTo(0, 0);
			
			/**
			 * Allow drag
			 */
			$lines.draggable({
				handle: '.treeDragHandle',
				start: dragStart,
				stop: dragStop,
				revert: function(dropElement){
					if(dropElement === false){
						return true;
					}
					else 
					{
						return false;
					}
				}
			});

			/**
			 * Event : drag start
			 */
			function dragStart(event, ui)
			{
				$treeContainer.addClass('dragging');
				
				// Id de l'element dragué
				dragElementId = $(event.target).attr('data-node-id');
				
				// Elements droppable
				$allowedDropZones = $dropZones.not('.treeDropZoneChildOf_'+dragElementId).not('.treeDropZoneRelativeOf_'+dragElementId);
				
				// Afficher
				$allowedDropZones.fadeTo(0, 0.2);
				
				// Allow drop
				$allowedDropZones.droppable({
					accept: '.treeIndexLine',
					over: dropOver,
					out: dropOut,
					tolerance: 'pointer',
					drop: onDrop,
					hoverClass : 'treeDropZoneDropping'
				});
			}
			
			/**
			 * Event : drag stop
			 */
			function dragStop(event, ui)
			{
				$treeContainer.removeClass('dragging');
				$dropZones.fadeTo(0, 0);
				$allowedDropZones.droppable('destroy');
			}
			
			
			/**
			 * Event : drop activate
			 */
			function dropOver(event, ui)
			{
				$(event.target).fadeTo(0, 1);
			}
			
			/**
			 * Event : drop deactivate
			 */
			function dropOut(event, ui)
			{
				$(event.target).fadeTo(0, 0.2);
			}
			
			
			function onDrop(event, ui)
			{
				if(firePositionChangeTimer) window.clearInterval(firePositionChangeTimer);
				firePositionChangeTimer = window.setTimeout(function(){
					firePositionChange(event, ui);
				}, 75);
				return false;
			}
			
			function firePositionChange(event, ui)
			{
				destroy();
				$treeContainer.trigger('position:change', {
					fromNodeId: $(ui.draggable).attr('data-node-id'),
					toRelativeNodeId: $(event.target).attr('data-relative-node-id'),
					toRelativeNodePosition: $(event.target).attr('data-position'),
				});
			}
			
			function destroy()
			{
				if($allowedDropZones.hasClass('ui-droppable'))
				{
					$allowedDropZones.droppable('destroy');
				}
				if($lines.hasClass('ui-draggable'))
				{
					$lines.draggable('destroy');
				}
			}
			
		});
	};
})(jQuery);