
jQuery(document).ready(function() {
	
	// definiera vars
	var word = '';
	
	// Ladda griden om man "reloadar" sin browser
	loadGrid();

	// Ladda griden med de monterade texterna
	function loadGrid(){
		var content_sortkey = jQuery(".content_list_select option:selected").val();
			jQuery.post(ajaxurl, { action: 'content_action', content_sortkey: content_sortkey }, function(response) {
				jQuery('#sortable2').append(response).sortable({
					update : function () {
						var content_sortkey = jQuery(".content_list_select option:selected").val();
						var serial = jQuery('#sortable2').sortable('serialize');
						jQuery.post(ajaxurl, { action: 'sort_action', content_sortkey: content_sortkey, sorted_list: serial } );
					}
				});
			});				
	}

	// Sök efter poster, finns en bugg som gör att eventen försvinner??
	jQuery("#do_post_search").click(function() { 
		jQuery('#sortable1').html('');
		word = jQuery("#post-search-input").val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		var content_sortkey = jQuery(".content_list_select option:selected").val();
		if(word){
			jQuery.post(ajaxurl, { action: 'search_posts_action', word: word, content_sortkey: content_sortkey }, function(response) {
				jQuery('#sortable1').append(response);
				jQuery("#sortable1, #sortable2").sortable({connectWith: 'ul'});
			});
		}
	});

	// Ladda griden om man väljer i select-dropen
	jQuery(".content_list_select").change(function(){
		jQuery('#sortable2').html('');
		loadGrid();
	});

	// ta bort en post ur listan
	jQuery(".remove").live('click', function() { 
		var post_id = jQuery(this).attr('href');
		var content_sortkey = jQuery(".content_list_select option:selected").val();
		if(post_id){
			jQuery.post(ajaxurl, { action: 'remove_action', post_id: post_id, content_sortkey: content_sortkey }, function(response) {
				jQuery('#content_post_id_' + post_id).css({ 'backgroundColor':'#eee' }).fadeOut('fast');
			});
		}
		return false;
	});

});

