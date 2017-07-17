<?php
/*
Plugin Name: Content Sort
Plugin URI: http://www.fosseus.se
Description: Sort the posts on your firstpage
Author: Johannes Fosseus
Version: 2.0b
*/

require_once dirname( __FILE__ ) . '/content-sort.class.php';
if (class_exists('ContentSort')){
	$content_sort = new ContentSort();
}

// Register 'activate/deactivate' hooks to the plugin
if (isset($content)) {
   register_activation_hook(__FILE__, array($content,'activate'));
   register_deactivation_hook(__FILE__, array($content, 'deactivate'));
}

// Load js only in backend
if(is_admin()){
	wp_enqueue_script('content_sort_js', WP_PLUGIN_URL.'/content-sort/content-sort.js', array('jquery','jquery-ui-core','jquery-ui-sortable'));
	wp_enqueue_style('content_sort_css', WP_PLUGIN_URL.'/content-sort/content-sort.css');
}

// Register ajax actions
add_action('wp_ajax_content_action', 'content_action_callback');
add_action('wp_ajax_search_posts_action', 'search_posts_action_callback');
add_action('wp_ajax_sort_action', 'sort_action_callback');
add_action('wp_ajax_remove_action', 'remove_action_callback');

function content_action_callback() {
	global $content_sort;
	$result = $content_sort->getPostsInList();
	echo $result;
	die;
}

function search_posts_action_callback() {
	global $content_sort;
	$result = $content_sort->getPostsFromSearch($_POST['word']);
	echo $result;
	die;
}

function sort_action_callback() {
	global $content_sort;
	$sorted_list = $_POST['sorted_list'];
	parse_str($sorted_list);
	$result = $content_sort->saveSortedList($content_post_id);
	echo $result;
	die;
}

function remove_action_callback() {
	$content_sort = new contentSort();
	$result = $content_sort->removeInSortedList($_POST['post_id']);
	die;
}
?>