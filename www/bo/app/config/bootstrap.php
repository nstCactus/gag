<?php

	// ================= SPECIFIQUES AU PROJET ====================

	/**
	 * L'adresse mail du super_admin client pour une demande de suppression
	 */
	Configure::write('Delete.emailSuperAdmin', 'maxime@lahautesociete.com');


	/**
	 * Chemins vers le dossier media, relatif au webroot (xxx/bo/)
	 */
	Configure::write('Config.mediaPath', "../media/");


	/**
	 * Adresse du front
	 * URL utilisé pour Twitter / Facebook / "Accéder au site"
	 */
	Configure::write('Config.httpWebroot', '');


	/**
	* Vimeo
	* @link http://vimeo.com/api
	*/
	Configure::write('Config.vimeo.user_id', 'user17612074');
	Configure::write('Config.vimeo.consumer_key', '87662f2da4ba68a3ea92ee6dd4198b385915de86');
	Configure::write('Config.vimeo.consumer_secret', 'f8b6039302625128394595684eb0f22e9da7f6b3');
	Configure::write('Config.vimeo.token', '593f6b242a7b64e80092e04271a82091');
	Configure::write('Config.vimeo.token_secret', '64e204703047cd80c60ba9848cad57a070cc189e');



	/**
	* Youtube
	* @link http://youtube.com/
	*/
	//Configure::write('YouTube.login', 'LaHauteSociete');
	//Configure::write('YouTube.password', 'HOcqC2I7');
	//Configure::write('YouTube.developerKey', 'AI39si56SHM-Uz5KzD9UzdxyepsxfBGSDHtO1zP0e8HYTBsd6LnZg7HTNkPrxpC9vbg-9dckBL9YuymtUNrGEwz7uNMT0UgCRQ');


	/**
	 * Langages disponibles
	 */
	Configure::write('Config.allowedInterfaceLanguages', array(
		'fre',
	));

