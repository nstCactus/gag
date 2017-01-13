{'footer'|component:[ 'fields' => [
	'menuItems'	=> $footerMenuItems,
	'copyright'	=> 'copyright'|dico
]]}

<script type="application/javascript">
	(function(){
		var lazy = document.getElementsByClassName('Lazy');

		for(var i = 0; i < lazy.length; i++) {
			lazyLoadImage(lazy[i]);
		}

		function lazyLoadImage(element) {
			var imageURL = element.getAttribute("data-original");
			var image = document.createElement('img');
			image.addEventListener("load", function(event) {
				element.classList.add('Lazy-loaded');
			});
			image.setAttribute('src', imageURL);
		}
	})();
</script>
