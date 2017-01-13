(function($){
	$(function(){
		// Disable check spelling
		$('.jsonEditor').attr('spellcheck', false);
		
		// On key down tab
		$('.jsonEditor').keydown(function (e) {
		    if (e.keyCode == 9) {
		    	var myValue = "\t";
		    	var startPos = this.selectionStart;
		    	var endPos = this.selectionEnd;
		    	var scrollTop = this.scrollTop;
		    	this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos,this.value.length);
		    	this.focus();
		    	this.selectionStart = startPos + myValue.length;
		    	this.selectionEnd = startPos + myValue.length;
		    	this.scrollTop = scrollTop;
		
		    	e.preventDefault();
		    }
		});
		
		/**
		 * CheckJson
		 * Add styles
		 */
		function checkJSON(element){
		    var isValidJSON = true;
		    // Vérifier que le JSON est valide
		    try {
		    	json = eval('(' + element.val() + ')');
		    }
		    catch(e){
		    	isValidJSON = false;
		    }
		    
		    if(isValidJSON){
		    	element.css('border', '1px solid #61ae24');
		    	element.css('background', '#dfefd3');
		    }
		    else {
		    	element.css('border', '1px solid #e54028');
		    	element.css('background', '#fad9d4');
		    }
		}
		
		// On key up : check json
		$('.jsonEditor').keyup(function (e) {
			checkJSON($(this));
		});
	
		// On load: check json
		$('.jsonEditor').each(function(item, element){
			checkJSON($(element));
		});
	});
})(jQuery);