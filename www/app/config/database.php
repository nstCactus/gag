<?php

class DATABASE_CONFIG {

	// ============ DEV LHS ==============
	var $default = array(
    	/* ---------------------------- */
		'host' => BDD_HOST,	  
		'login' => BDD_LOGIN,		  
		'password' => BDD_PASSWORD,   
		'database' => BDD_DATABASE,  
    	/* ---------------------------- */
		'driver' => 'mysql',
		'persistent' => false,
		'prefix' => '',
		'encoding' => 'utf8',
	);
}
