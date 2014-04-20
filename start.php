<?php
/**
 *	cv
 *	Author : moneya | Sociabie
 *	@package cv plugin
 *	Licence : GPLv2
 *	Copyright : moneya 2011-2015
 */
 
elgg_register_event_handler('init', 'system', 'cv_init');

function cv_init() {
	elgg_register_page_handler('career', 'cv_page_handler');	
	elgg_register_action('cv/contact', elgg_get_plugins_path() . "cv/actions/cv/contact.php", 'public');
	
	$admin_email = elgg_get_plugin_setting('admin_email', 'cv');
	if($admin_email && is_email_address($admin_email)){
		$menu_locations = array('footer', 'site');
		foreach($menu_locations as $location){
			elgg_register_menu_item($location, array(
											'name' => 'career',
											'text' => elgg_echo('cv:contact'),
											'href' => 'career',
										));	
		}		
	}	
	if(!elgg_is_logged_in()){
		elgg_register_plugin_hook_handler('actionlist', 'captcha', 'cv_captcha_hook');
	}
}	

function cv_page_handler($page) {
	$title = elgg_echo('cv:contact');
	$body = elgg_view_form('cv/contact');
	$params = array(
		'content' => $body,
		'title' => $title,
	);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
	return true;
}

function cv_captcha_hook($hook, $entity_type, $returnvalue, $params)	{
	if (!is_array($returnvalue)){
		$returnvalue = array();
	}	
	$returnvalue[] = 'cv/contact';
	return $returnvalue;
}
