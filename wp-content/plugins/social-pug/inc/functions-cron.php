<?php


	/*
	 * Add custom schedules to use for the cron jobs
	 *
	 */
	function dpsp_cron_schedules( $schedules ) {

		$schedules['dpsp_2x_hourly'] = array(
			'interval' => (3600 * 2),
			'display'  => __( 'Once every two hours', 'social-pug' )
		);

		return $schedules;

	}
	add_filter( 'cron_schedules', 'dpsp_cron_schedules' );

	
	/*
	 * Set cron jobs
	 *
	 * @return void
	 *
	 */
	function dpsp_set_cron_jobs() {

		wp_schedule_event( time(), 'dpsp_2x_hourly', 'dpsp_cron_get_posts_networks_share_count');

	}


	/*
	 * Stop cron jobs
	 *
	 * @return void
	 *
	 */
	function dpsp_stop_cron_jobs() {

		wp_clear_scheduled_hook( 'dpsp_cron_get_posts_networks_share_count' );

	}


	/*
	 * Retreives the share counts for each post, for each network and saves
	 * them in the post meta
	 *
	 * @return void
	 *
	 */
	function dpsp_cron_get_posts_networks_share_count() {

		/*
		 * Start with getting all post types saved in every 
		 * settings page. We only wish to get share counts for the
		 * posts that have these certain post types.
		 *
		 * Also get all active social networks from each of the
		 * settings page
		 *
		 */
		$locations  	 = dpsp_get_network_locations();
		$social_networks = dpsp_get_active_networks();
		$post_types 	 = array();

		foreach( $locations as $location ) {
			
			$location_settings = get_option( 'dpsp_location_' . $location );

			/*
			 * Get post types of settings page
			 *
			 */
			if( isset( $location_settings['post_type_display'] ) )
				$post_types = array_merge( $post_types, $location_settings['post_type_display'] );
			
		}


		/*
		 * Filter post types
		 *
		 */
		$post_types = array_unique( $post_types );
		$registered_post_types = get_post_types();

		foreach( $post_types as $key => $post_type ) {
			if( !in_array($post_type, $registered_post_types) )
				unset( $post_types[$key] );
		}


		/*
		 * Get all posts for each post type saved in every
		 * settings page and get network share counts
		 *
		 */
		$posts 	   	  = get_posts( array( 'post_type' => $post_types, 'numberposts' => -1 ) );
		$top_posts 	  = array();

		if( !empty( $posts ) ) {
			foreach( $posts as $post_object ) {

				$dpsp_networks_shares = get_post_meta( $post_object->ID, 'dpsp_networks_shares', true );

				if( empty( $dpsp_networks_shares ) )
					$dpsp_networks_shares = array();

				if( !empty( $social_networks ) ) {
					foreach( $social_networks as $network_slug ) {

						if( !in_array( $network_slug, dpsp_get_networks_with_social_count() ) )
							continue;

						$share_count = dpsp_get_post_network_share_count( $post_object->ID, $network_slug );

						if( $share_count !== false )
							$dpsp_networks_shares[$network_slug] = $share_count;

					}
				}

				// Update post meta with all shares
				update_post_meta( $post_object->ID, 'dpsp_networks_shares', $dpsp_networks_shares );

				// Get total shares and save top posts
				$total_shares = 0;

				if( !empty( $dpsp_networks_shares ) ) {
					foreach( $dpsp_networks_shares as $network_slug => $share_count )
						$total_shares += $share_count;
				}
				
				$top_posts[$post_object->post_type][$post_object->ID] = $total_shares;

			}

			// Filter top posts array
			foreach( $post_types as $key => $post_type ) {
				if( isset( $top_posts[$post_type] ) && !empty( $top_posts[$post_type] ) ) {

					// Sort descending
					arsort( $top_posts[$post_type] );

					// Get only first ten
					$top_posts[$post_type] = array_slice( $top_posts[$post_type], 0, 10, true );

				}
			}

			// Update top posts
			update_option( 'dpsp_top_shared_posts', json_encode( $top_posts ) );

		}
		
	}
	add_action( 'dpsp_cron_get_posts_networks_share_count', 'dpsp_cron_get_posts_networks_share_count' );