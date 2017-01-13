<?php
	/**
	 * Slugify content
	 * @param $content
	 * @return String
	 */
	function smarty_modifier_slugify ($content) {
		return Tools::slug($content);
	}