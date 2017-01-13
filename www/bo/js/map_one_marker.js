/**
 * Map one marker BO
 */
var MapOneMarker = {
    
	options: false,
	map: false,
	geocoder:false,
	marker: false,
    addressFieldEventDelay: false,
    paysIdByCode: {},
		
	/**
	 * Init
	 * 
	 * options:
	 * 		
	 * 'fields' => array(
	 *			'inputAddress' => 'Model.address_localization',
	 *			'latitude' => 'Model.latitude',
	 * 			'longitude' => 'Model.longitude',
	 *			//'postalCode' => 'Model.postal_code',
	 *			//'locality' => 'Model.city',
	 *			//'street' => 'Model.street',
	 *			//'country' => 'Model.pays_id',
	 *		),
	 *		//'defaultLatitude' => data[Model][latitude]..,
	 *		//'defaultLongitude' => data[Model][longitude]..,
	 *		//'fillAddress' => false, // si add: true ; si edit : false
	 * 
	 * 
	 */
	init: function(pOptions, pPaysIdByCode){
		var that = this;
		this.options = pOptions;
		
		this.paysIdByCode = pPaysIdByCode;
		
		
		// Geocoder
		this.geocoder = new google.maps.Geocoder();
		
		// On load
		google.maps.event.addDomListener(window, 'load', function(){
			
			var currentLocation = new google.maps.LatLng(45.184166, 5.715542);
			
			if(that.options.defaultLatitude !== false){
				currentLocation = new google.maps.LatLng(that.options.defaultLatitude, that.options.defaultLongitude)
			}
			
			// Options de la map
	        var mapOptions = {
	          zoom: 2,
	          center: currentLocation,
	          disableDefaultUI: true,
	          mapTypeId: google.maps.MapTypeId.ROADMAP
	        }; 
	        
	        // Création de la map
	        that.map = new google.maps.Map(document.getElementById(that.options.mapContainer), mapOptions);
	    
	        
	        // Création du marker
	        that.marker = new google.maps.Marker({
	            map: that.map
	        });
	        
	        // Marker draggable
	        that.marker.setDraggable(true);
	        
	        // Affichage du marker
	        if(that.options.defaultLatitude !== false){
		        that.marker.setVisible(true);
		        that.marker.setPosition(currentLocation);
		        that.map.setZoom(15);
	        } else {
	        	that.marker.setVisible(false);
	        }

	        
	        // Marker drag event
	        google.maps.event.addListener(that.marker, 'dragend', function(){
				that.changePosition(that.marker.getPosition());
				window.setTimeout(function(){
					that.map.panTo(that.marker.getPosition());
				},500);
	        });
	        
	        
	        // Events sur address field
	        
	        console.log(that.options.fields.inputAddress);
	        $(that.options.fields.inputAddress).observe('keyup', that.inputAddressChanged.bind(that));
	        $(that.options.fields.inputAddress).observe('paste', that.inputAddressChanged.bind(that));
	        
		});
	},
	
	
	/**
	 * Address changed
	 */
	inputAddressChanged: function(event) {
		var that = this;
		
		// Address
    	var addressValue = $(this.options.fields.inputAddress).value;
    	
    	// Animation sur le marker
    	this.marker.setAnimation(google.maps.Animation.BOUNCE);
    	
    	// Delay la requete
    	if(this.addressFieldEventDelay) window.clearTimeout(this.addressFieldEventDelay);
    	this.addressFieldEventDelay = window.setTimeout(function(){
    		that.findPoint(addressValue);
    	}, 750);
    },
	
	
	/**
	 * Placer un marqueur a une adresse
	 */
	findPoint: function (address){
		var that = this;
		this.geocoder.geocode( { 'address': address}, function(results, status) {
			
			// Adresse trouvée
			if (status == google.maps.GeocoderStatus.OK) {
				// Repositionne la map + marker
				that.positionMarker(results[0].geometry.location);
				that.map.panTo(results[0].geometry.location);
				that.map.setZoom(15);
				that.marker.setAnimation(null);

				// Met à jour les input
				that.changePosition(results[0].geometry.location);
				that.fillAddress(results[0].address_components);
		      } else {
		        that.removePosition();
		      }
	    });
	},
	
	
	
	/**
	 * Position marker
	 */
	positionMarker: function(location){
		if(this.marker){
			this.marker.setPosition(location);
			this.marker.setVisible(true);
		}
	},
	
	/**
	 * Change position
	 */
	changePosition: function(location){
		$(this.options.fields.latitude).value = location.lat();
		$(this.options.fields.longitude).value = location.lng();
	},
	
	/**
	 * Remplir les adresses 
	 */
	fillAddress: function(address){
		// On veut pas remplir!
		if(!this.options.fillAddress) return;
		console.log('fneug');
		var addressLength = address.length;
		var addressItemByType = {};

		// Réordonne par type
		for(var itemKey = 0 ; itemKey < addressLength ; itemKey++){
			addressItemByType[address[itemKey]['types'][0]] = address[itemKey];
		}
		
		// Postal code
		if('postalCode' in this.options.fields) {
			$(this.options.fields.postalCode).value = '';
			if('postal_code' in addressItemByType ) {
				$(this.options.fields.postalCode).value = addressItemByType['postal_code']['long_name'];
			}
		}

		// Locality
		if('locality' in this.options.fields) {
			$(this.options.fields.locality).value = '';
			if('locality' in addressItemByType ) {
				$(this.options.fields.locality).value = addressItemByType['locality']['long_name'];
			}
		}

		// Street
		if('street' in this.options.fields) {
			$(this.options.fields.street).value = '';
			if('street_number' in addressItemByType ) {
				$(this.options.fields.street).value = addressItemByType['street_number']['long_name'] + ' ';
			}
			if('street' in this.options.fields && 'route' in addressItemByType ) {
				$(this.options.fields.street).value += addressItemByType['route']['long_name'];
			}
		}
		
		// Country
		if('country' in this.options.fields) {
			$(this.options.fields.country).value = '';
			if('country' in addressItemByType && addressItemByType['country']['short_name'] in this.paysIdByCode) {
				$(this.options.fields.country).value = this.paysIdByCode[addressItemByType['country']['short_name']];
			}
		}
	},
	
	
	/**
	 * Remove position
	 */
	removePosition: function(){
		this.marker.setVisible(false);
		this.map.setZoom(2);
	}
};
