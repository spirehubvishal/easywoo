<?php
/**
 * Action to enable geolocated data form.
 *
 * @package Listar_Addons
 */


/**
 * Actions to output every form
 */

add_action( 'listar_geolocated_data_form', 'listar_geolocated_data_form_output' );

if ( ! function_exists( 'listar_geolocated_data_form_output' ) ) :
	/**
	 * Geolocation form output.
	 *
	 * @since 1.0
	 */
	function listar_geolocated_data_form_output() {
		global $wp;
		
		$current_url = '';
		$query_args  = isset( $wp->query_vars ) && ! empty( $wp->query_vars ) ? $wp->query_vars : '';
		$wp_request  = isset( $wp->request ) && ! empty( $wp->request ) ? $wp->request : '';
		
		if ( ! empty( $query_args ) ) {
			$current_url = add_query_arg( $query_args, network_site_url( $wp_request ) );
		} else {
			$current_url = network_site_url( $wp_request );
		}
		
		$session_main_key = 'listar_user_search_options';
		
		$geolocated_address = isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_address'] ) ? $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_address'] : '';
		$geolocated_number = isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_number'] ) ? $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_number'] : '';
		$geolocated_region = isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_region'] ) ? $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_region'] : '';
		$geolocated_country = isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_country'] ) ? $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_country'] : '';
		$geolocated_lat = isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lat'] ) ? $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lat'] : '';
		$geolocated_lng = isset( $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lng'] ) ? $_SESSION[ $session_main_key ]['explore_by_nearest_me_geocoded_lng'] : '';
		?>
		<!-- Geolocation form -->
		<div class="listar-geolocation-form-wrapper">
			<form id="listar-geolocation-form" action="<?php echo esc_url( network_site_url( '/' ) ); ?>" method="post">
				<div class="form-field">
					<input value="<?php echo esc_html( $geolocated_address ); ?>" class="form-control input-lg required" name="listar_geolocated_data_address" id="listar_geolocated_data_address" type="text" placeholder="<?php esc_attr_e( 'Address', 'listar' ); ?>"/>
				</div>
				<div class="form-field">
					<input value="<?php echo esc_html( $geolocated_number ); ?>" class="form-control input-lg" name="listar_geolocated_data_number" id="listar_geolocated_data_number" placeholder="<?php esc_attr_e( 'Number', 'listar' ); ?>"/>
				</div>
				<div class="form-field">
					<input value="<?php echo esc_html( $geolocated_region ); ?>" class="form-control input-lg required" name="listar_geolocated_data_region" id="listar_geolocated_data_region" placeholder="<?php esc_attr_e( 'City and/or state', 'listar' ); ?>"/>
				</div>
				<div class="form-field">
					<input value="<?php echo esc_html( $geolocated_country ); ?>" class="form-control input-lg required" name="listar_geolocated_data_country" id="listar_geolocated_data_country" placeholder="<?php esc_attr_e( 'Country', 'listar' ); ?>"/>
				</div>
				<div class="form-field hidden">
					<input value="<?php echo esc_html( $geolocated_lat ); ?>" class="form-control input-lg" type="hidden" name="listar_geolocated_data_latitude" id="listar_geolocated_data_latitude"/>
				</div>
				<div class="form-field hidden">
					<input value="<?php echo esc_html( $geolocated_lng ); ?>" class="form-control input-lg" type="hidden" name="listar_geolocated_data_longitude" id="listar_geolocated_data_longitude"/>
				</div>
				<div class="form-field">
					<input type="hidden" name="action" value="listar_geolocated_data"/>
					<button class="listar-submit-geolocation-data btn btn-theme btn-lg" data-button-text="<?php esc_attr_e( 'Save', 'listar' ); ?>" data-loading-text="<?php esc_attr_e( 'Saving...', 'listar' ); ?>" type="submit">
						<?php esc_html_e( 'Save', 'listar' ); ?>
					</button>
				</div>
			</form>
			<div class="listar-errors"></div>
		</div>
		<?php
	}

endif;
