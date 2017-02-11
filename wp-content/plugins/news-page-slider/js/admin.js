(function($) {
	"use strict";
	$(function() {
		$('#cidade').change(function() {
			$.ajax({
				url: "<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",
				type: 'POST',
				data: 'action=category_select_action&name=' + name,
				success: function(results)
				{
					$("#cozinha").html(results);
				}
			});
		});
	});
	$(function() {
		$('#slider_postType').change(function() {
			//console.log( $(this).val());
			var data = {
				action: 'nps_get_cat',
				postType: $(this).val()
			};
			$.post(ajaxurl, data, function(response) {


				$('#taxonomies').html(response);
			});
		});
	});
}(jQuery));
