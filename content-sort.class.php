<?php
class ContentSort {

	function __construct() {
		add_action("admin_menu", array($this,"add_admin_pages"));
		add_filter('the_posts',array($this,'add_content_sort_posts'));
	}

	// Sätt upp menyn
	function add_admin_pages(){
		add_submenu_page('edit.php', "Content Sort", "Content Sort", 'administrator', 'content-sort/grid.php');
	}

	// add post to front page
	function add_content_sort_posts($posts){

		// todo: ta bort ev förekomster av dubletter
		// kolla så pagineringen funkar ändå
		if(is_front_page()){

			$mounted_posts = get_option('content-sort-list');

			if($mounted_posts){
				$mounted_posts = array_reverse($mounted_posts); // flippa på den
				foreach ($mounted_posts as $value) {
					if($value){
						$post = get_post($value); // hämta posten
						array_unshift($posts, $post); // lägg först i post-listan
					}
				}
			}

		}

		// returnera
		return $posts;
	}


	// return posts in the grid and alla post_id to posts in the grid
	function getPostsInList(){

		$result = get_option('content-sort-list'); // get the mounted posts

		// Hämta en html-kodad postlista, som kan returneras till jquery
		if(!empty($result)){
//			$search_result_posts = explode(",", $result);
			$return = $this->getPosts($result);
		}

		return $return;
	}

	// Använd post_id för att hämta fram postlistan
	private function getPosts($result){
		if(!empty($result)){
			foreach ( $result as $post_id ){
				if(get_the_title($post_id)){ // returnera ingen tomt
					$post_list .=  "<li id=\"content_post_id_".$post_id."\"><span></span>".get_the_title($post_id)." <a href=\"".$post_id."\" class=\"remove\">Remove Post</a></li>\n";
				}
			}
		}
		return $post_list;
	}


	// Gör en sökning efter poster och returnera en lista på dem
	function getPostsFromSearch($word){
		global $wpdb;

		$posts_in_grid = $result = get_option('content-sort-list');

		$result = $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = \"post\" AND post_status = \"publish\" AND post_title LIKE \"%".$word."%\" LIMIT 10");
		$result = $this->getPostIdAsStringObj($result);
		$search_result_posts = explode(",", $result); // gör en array på uppsöka poster

		if(!empty($posts_in_grid)){
			$result = $this->removeFromArray($posts_in_grid, $search_result_posts); // remove mounted posts from the arr
		} else {
			$result = $search_result_posts;
		}

		return $this->getPosts($result);
	}

	// Ta bort post_id:n från sökresultatet som redan ligger monterade i griden
	// borde finnas som native-php men jag hittar inte den
	private function removeFromArray($posts_in_grid_arr, $search_result_posts){
		$return_arr = array();
		foreach ($search_result_posts as $item ){
			if (!in_array($item, $posts_in_grid_arr)) {
				array_push($return_arr,$item);
			}
		}
		return $return_arr;
	}


	// Spara en sorterad lista
	function saveSortedList($sorted_list){
		if($sorted_list){
			update_option('content-sort-list',$sorted_list);
		} else {
			delete_option('content-sort-list');
		}
	}

	// Remove the item
	// lite messig, borde göras om helt
	function removeInSortedList($post_id){
		if(isset($post_id)){
			$posts_in_grid_arr = get_option('content-sort-list'); // get all post_id in the grid
			$remove_post_id_as_array = array($post_id); // chang to array
			$result = $this->removeFromArray($remove_post_id_as_array, $posts_in_grid_arr); // remove
			$this->saveSortedList($result); // save new list
		}
	}


	// Gör om ett rowset till en string, från resultset
	private function getPostIdAsStringObj($result){
		$return_string = '';
		if(!empty($result)){
			foreach ($result as $item ){
				$return_string .=  $item->ID.",";
			}
			$return_string = substr($return_string,"",-1);
		}
		return $return_string;
	}


	// Activate method
	function activate() {
		add_option('content-sort','Activated');
   	}

   	// Deactivate pluginen
   	function deactivate() {
      delete_option('content-sort');
   	}

}
?>