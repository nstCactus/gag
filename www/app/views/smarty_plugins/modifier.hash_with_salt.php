<?php

App::import('Vendor', 'SecurityHelper');

/**
 * Return hash of content
 * @param $content
 * @return String
 */
function smarty_modifier_hash_with_salt ($content) {
	return SecurityHelper::hashWithSalt($content);
}