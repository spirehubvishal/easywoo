<?php
/**
 * Custom functions that setup/change/alter the behaviour of WP Job Manager
 *
 * See: https://wpjobmanager.com/
 * See: https://wpjobmanager.com/customization-snippets/
 *
 * @package Listar_Addons
 */

add_filter( 'submit_job_form_fields', 'listar_frontend_add_jobmanager_fields', 20 );

if ( ! function_exists( 'listar_frontend_add_jobmanager_fields' ) ) :
	/**
	 * Adding custom fields to WP Job Manager submission form - Front end.
	 *
	 * @since 1.0
	 * @param (array) $fields WP Job Manager input fields settings.
	 * @return (array)
	 */
	function listar_frontend_add_jobmanager_fields( $fields ) {

		$fields['job']['job_fix_for_checkboxes'] = array(
			'label'       => '',
			'type'        => 'text',
			'required'    => false,
			'placeholder' => '',
			'priority'    => 0.1,
		);

		$fields['job']['job_useuseremail'] = array(
			'label'       => esc_html__( 'Use Default Email', 'listar' ),
			'type'        => 'checkbox',
			'description' => esc_html__( 'If checked, the email set on your profile will be shown on the listing contact data', 'listar' ),
			'required'    => false,
			'priority'    => 0.5,
		);

		$fields['job']['job_custom_email'] = array(
			'label'       => esc_html__( 'Custom Contact Email', 'listar' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'name@domain.com', 'listar' ),
			'priority'    => 0.5,
		);
		
		$listar_disable_private_messages = (int) get_option( 'listar_disable_private_message' );
		
		if ( 0 === $listar_disable_private_messages ) {
			$fields['job']['job_disable_privatemessage'] = array(
				'label'       => esc_html__( 'Disable Private Messages', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'If checked, the Private Message form will be hidden', 'listar' ),
				'priority'    => 0.51,
			);
		}

		$fields['job']['job_listing_subtitle'] = array(
			'label'       => esc_html__( 'Listing Subtitle', 'listar' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'e.g. Since 1992', 'listar' ),
			'priority'    => 1.1,
		);
		
		$listar_location_disable = (int) get_option( 'listar_location_disable' );
		
		if ( 0 === $listar_location_disable ) {
			$fields['job']['job_customlatitude'] = array(
				'label'       => esc_html__( 'Force custom Latitute', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '25.84827',
				'priority'    => 2.101,
			);

			$fields['job']['job_customlongitude'] = array(
				'label'       => esc_html__( 'Force custom Longitude', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '-80.18444',
				'priority'    => 2.102,
			);

			$location_options = array(
				'location-default'  => esc_html__( 'Use default location address', 'listar' ),
				'location-geocoded' => esc_html__( 'Use geocoded address', 'listar' ),
				'location-custom'   => esc_html__( 'Use custom address', 'listar' ),
			);

			$fields['job']['job_locationselector'] = array(
				'label'       => esc_html__( 'Public address', 'listar' ),
				'type'        => 'select',
				'required'    => false,
				'options'     => $location_options,
				'priority'    => 2.103,
			);

			$fields['job']['job_customlocation'] = array(
				'label'       => esc_html__( 'Enter new address for public view', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( '7919 Biscayne Boulevard, Miami, FL 33138', 'listar' ),
				'priority'    => 2.104,
			);
		}

		$fields['job']['job_tagline'] = array(
			'label'       => esc_html__( 'Tagline or Slogan', 'listar' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'e.g. Fine Breads, Crafted with Artistry and Passion', 'listar' ),
			'priority'    => 2.5,
		);

		if ( taxonomy_exists( 'job_listing_amenity' ) ) :
			$fields['job']['job_amenities'] = array(
				'label'       => esc_html__( 'Listing Amenities', 'listar' ),
				'type'        => 'term-multiselect',
				'required'    => false,
				'placeholder' => esc_html__( 'Choose amenities', 'listar' ) . '&hellip;',
				'taxonomy'    => 'job_listing_amenity',
				'priority'    => 4.8,
			);
		endif;
		
		$fields['job']['job_searchtags'] = array(
			'label'       => esc_html__( 'Search tags', 'listar' ),
			'type'        => 'textarea',
			'required'    => false,
			'placeholder' => esc_html__( 'Dinner pasta salad coffee sandwich soda wine...', 'listar' ),
			'priority'    => 4.801,
		);

		$fields['job']['job_business_use_custom_excerpt'] = array(
			'label'       => esc_html__( 'Customize Short Description', 'listar' ),
			'type'        => 'checkbox',
			'required'    => false,
			'description' => esc_html__( 'Short descriptions are generated automatically. Check to write a custom text for cards.', 'listar' ),
			'priority'    => 5.555,
		);

		$fields['job']['job_business_custom_excerpt'] = array(
			'label'       => esc_html__( 'Short Description (Custom)', 'listar' ),
			'type'        => 'textarea',
			'required'    => false,
			'placeholder' => esc_html__( 'Short Description', 'listar' ),
			'priority'    => 5.556,
		);
		
		$listar_operating_hours_disable = (int) get_option( 'listar_operating_hours_disable' );

		if ( 0 === $listar_operating_hours_disable ) {
			$fields['job']['job_business_use_hours'] = array(
				'label'       => esc_html__( 'Operation Hours', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to inform the hours of operation for your business.', 'listar' ),
				'priority'    => 5.905,
			);

			$fields['job']['job_business_hours_monday'] = array(
				'label'       => esc_html__( 'Monday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 5.91,
			);

			$fields['job']['job_business_hours_tuesday'] = array(
				'label'       => esc_html__( 'Tuesday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 5.92,
			);

			$fields['job']['job_business_hours_wednesday'] = array(
				'label'       => esc_html__( 'Wednesday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 5.93,
			);

			$fields['job']['job_business_hours_thursday'] = array(
				'label'       => esc_html__( 'Thursday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 5.94,
			);

			$fields['job']['job_business_hours_friday'] = array(
				'label'       => esc_html__( 'Friday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 5.95,
			);

			$fields['job']['job_business_hours_saturday'] = array(
				'label'       => esc_html__( 'Saturday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 5.96,
			);

			$fields['job']['job_business_hours_sunday'] = array(
				'label'       => esc_html__( 'Sunday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 5.97,
			);
		}
		
		$listar_menu_catalog_disable = (int) get_option( 'listar_menu_catalog_disable' );

		if ( 0 === $listar_menu_catalog_disable ) {
			$fields['job']['job_business_use_catalog'] = array(
				'label'       => esc_html__( 'Menu/Catalog', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to publish menu(s), catalog(s) or other list(s) for your business.', 'listar' ),
				'priority'    => 5.980,
			);

			$menu_label_options = array(
				'menu'      => esc_html__( 'Menu', 'listar' ),
				'catalog'   => esc_html__( 'Catalog', 'listar' ),
				'products'  => esc_html__( 'Products', 'listar' ),
				'services'  => esc_html__( 'Services', 'listar' ),
				'pricing'   => esc_html__( 'Pricing', 'listar' ),
				'files'     => esc_html__( 'Files', 'listar' ),
				'documents' => esc_html__( 'Documents', 'listar' ),
				'downloads' => esc_html__( 'Downloads', 'listar' ),
				'custom'    => esc_html__( 'Custom Label', 'listar' ),
			);

			$fields['job']['job_business_catalog_label'] = array(
				'label'       => esc_html__( 'Label for Menu/Catalog section', 'listar' ),
				'type'        => 'select',
				'required'    => false,
				'options'     => $menu_label_options,
				'description' => esc_html__( 'Select a label for Menu/Catalog section.', 'listar' ),
				'priority'    => 5.980,
			);

			$fields['job']['job_business_catalog_custom_label'] = array(
				'label'       => esc_html__( 'Custom Label for Menu/Catalog section.', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu', 'listar' ),
				'description' => esc_html__( 'Type a single word (preferable) to name the section. It is recommended a maximum of 15 letters.', 'listar' ),
				'priority'    => 5.980,
			);

			$fields['job']['job_business_use_price_list'] = array(
				'label'       => esc_html__( 'Product/Service list', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to build a list of products or services.', 'listar' ),
				'priority'    => 5.98001,
			);

			$fields['job']['job_business_price_list_content'] = array(
				'label'       => '',
				'type'        => 'textarea',
				'required'    => false,
				'description' => esc_html__( 'Create a list of products or services for quick presentation, prices are optional.', 'listar' ),
				'priority'    => 5.98002,
			);

			$fields['job']['job_business_use_catalog_documents'] = array(
				'label'       => esc_html__( 'I have document(s) to upload', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to upload menu/catalog file(s).', 'listar' ),
				'priority'    => 5.98003,
			);

			$fields['job']['job_business_document_1_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'1'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9801,
			);

			$menu_mime_types = array(
				'doc'   => 'application/msword',
				'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'pdf'   => 'application/pdf',
				'jpg'   => 'image/jpeg',
				'jpeg'  => 'image/jpeg',
				'gif'   => 'image/gif',
				'png'   => 'image/png',
				'txt'   => 'text/plain',
				'xls'   => 'application/vnd.ms-excel',
				'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'ppt'   => 'application/vnd.ms-powerpoint',
				'pptx'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				'rtf'   => 'application/rtf',
			);

			$fields['job']['job_business_document_1_file'] = array(
				'label'        => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'1'
				),
				'description'   => sprintf(
					/* TRANSLATORS: 1: https://www.coolutils.com/online/XLS-to-DOC, 2: https://www.google.com/search?q=xls+doc+convert&oq=xls+doc+convert */
					esc_html__( 'Valid file formats:', 'listar' ) . ' .jpg, .jpeg, .gif, .png, .txt, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .rtf, .pdf. ' . '<br>' . esc_html__( 'Any other file format need to be converted for one of these.', 'listar' ) . ' ' . wp_kses( __( 'You can convert it <a target="_blank" href="%1$s">here</a> or try <a href="%2$s" target="_blank">other online tools</a>.', 'listar' ), 'listar-basic-html' ),
					'https://www.coolutils.com/online/XLS-to-DOC',
					'https://www.google.com/search?q=xls+doc+convert&oq=xls+doc+convert'
				),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 5.9802,
				'ajax'          => false,
				'allowed_mime_types' => $menu_mime_types,
			);

			$fields['job']['job_business_document_2_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'2'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9803,
			);

			$fields['job']['job_business_document_2_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'2'
				),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 5.9804,
				'ajax'          => false,
				'allowed_mime_types' => $menu_mime_types,
			);

			$fields['job']['job_business_document_3_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'3'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9805,
			);

			$fields['job']['job_business_document_3_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'3'
				),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 5.9806,
				'ajax'          => false,
				'allowed_mime_types'  => $menu_mime_types,
			);

			$fields['job']['job_business_document_4_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'4'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9807,
			);

			$fields['job']['job_business_document_4_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'4'
				),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 5.9808,
				'ajax'          => false,
				'allowed_mime_types'  => $menu_mime_types,
			);

			$fields['job']['job_business_document_5_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'5'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9809,
			);

			$fields['job']['job_business_document_5_file'] = array(
				'label'        => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'5'
				),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 5.981,
				'ajax'          => false,
				'allowed_mime_types'  => $menu_mime_types,
			);

			$fields['job']['job_business_document_6_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'6'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9811,
			);

			$fields['job']['job_business_document_6_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'6'
				),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 5.9812,
				'ajax'          => false,
				'allowed_mime_types'  => $menu_mime_types,
			);

			$fields['job']['job_business_use_catalog_external'] = array(
				'label'       => esc_html__( 'I have document(s) or data published on external pages', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to link website(s) with external menu/catalog file(s) or page(s) containing your business data published.', 'listar' ),
				'priority'    => 5.9811,
			);

			$fields['job']['job_business_document_1_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'1'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9812,
			);

			$fields['job']['job_business_document_1_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'1'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 5.9813,
			);

			$fields['job']['job_business_document_2_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'2'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9814,
			);

			$fields['job']['job_business_document_2_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'2'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 5.9815,
			);

			$fields['job']['job_business_document_3_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'3'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9816,
			);

			$fields['job']['job_business_document_3_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'3'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 5.9817,
			);

			$fields['job']['job_business_document_4_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'4'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9818,
			);

			$fields['job']['job_business_document_4_file_external'] = array(
				'label'        => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'4'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 5.9819,
			);

			$fields['job']['job_business_document_5_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'5'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.982,
			);

			$fields['job']['job_business_document_5_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'5'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 5.9821,
			);

			$fields['job']['job_business_document_6_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'6'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 5.9822,
			);

			$fields['job']['job_business_document_6_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'6'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 5.9823,
			);
		}
		
		$listar_booking_service_disable = (int) get_option( 'listar_appointments_disable' );

		if ( 0 === $listar_booking_service_disable ) {
			$fields['job']['job_business_use_booking'] = array(
				'label'       => esc_html__( 'Appointments', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to use an appointment service, like Acuity, TimeKit, OpenTable, Booksy, Yelp Reservations, etc.', 'listar' ),
				'priority'    => 5.9824,
			);
			
			$appointment_label_options = array(
				'reservation' => esc_html__( 'Reservation', 'listar' ),
				'booking'     => esc_html__( 'Booking', 'listar' ),
				'book-now'    => esc_html__( 'Book Now', 'listar' ),
				'ordering'    => esc_html__( 'Ordering', 'listar' ),
				'custom'      => esc_html__( 'Custom Label', 'listar' ),
			);

			$fields['job']['job_business_booking_label'] = array(
				'label'       => esc_html__( 'Label for Appointments section', 'listar' ),
				'type'        => 'select',
				'required'    => false,
				'options'     => $appointment_label_options,
				'description' => esc_html__( 'Select a label for Appointments section', 'listar' ),
				'priority'    => 5.9825,
			);

			$fields['job']['job_business_booking_custom_label'] = array(
				'label'       => esc_html__( 'Custom Label for Appointments section', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Booking', 'listar' ),
				'description' => esc_html__( 'Type a single word (preferable) to name the section. It is recommended a maximum of 15 letters.', 'listar' ),
				'priority'    => 5.9826,
			);
			
			$recommended_appointment_services_enabled = 0 === (int) get_option( 'listar_recommended_appointment_services_disable' );
			$recommended_appointment_services         = '';
			$recommended_appointment_services_output  = '';
			$recommended_appointment_services_urls    = '';
			
			if ( $recommended_appointment_services_enabled ) {
				$appointment_services_temp_urls           = array();
				$recommended_appointment_services         = trim( (string) $recommended_appointment_services_enabled ? get_option( 'listar_recommended_appointment_services' ) : '' );
				$recommended_appointment_services_output .=  '<div class="listar-show-recommended-appointment-tools"><a href="#">' . esc_html__( 'Show recommended Appointment Managers', 'listar' ) . '</a></div>';

				if ( false !== strpos( $recommended_appointment_services, 'http' ) ) {
					if ( false !== strpos( $recommended_appointment_services, '|||||' ) ) {
						$recommended_appointment_services = explode( '|||||', $recommended_appointment_services );
						
						foreach( $recommended_appointment_services as $url ) {
							if ( false !== strpos( $url, 'http' ) ) {
								$appointment_services_temp_urls[] = $url;
							}
						}
					} else {
						$appointment_services_temp_urls[] = $recommended_appointment_services;
					}
				} else {
					
					$appointment_services_temp_urls[] = 'https://acuityscheduling.com/';
					$appointment_services_temp_urls[] = 'https://www.opentable.com/';
					$appointment_services_temp_urls[] = 'https://restaurants.yelp.com/';
					$appointment_services_temp_urls[] = 'https://www.timekit.io/';
					$appointment_services_temp_urls[] = 'https://booksy.com/';
					$appointment_services_temp_urls[] = 'https://resy.com/';
					$appointment_services_temp_urls[] = 'https://www.zomato.com/';
					$appointment_services_temp_urls[] = 'https://www.bookafy.com/';
					$appointment_services_temp_urls[] = 'https://simplybook.me/';
					$appointment_services_temp_urls[] = 'https://www.thefork.com/';
				}
					
				if ( ! empty( $appointment_services_temp_urls ) ) {
					foreach( $appointment_services_temp_urls as $url ) {
						$url = listar_get_domain_name( $url );
						
						if ( isset( $url['url'] ) && ! empty( $url['url'] ) && isset( $url['host'] ) && ! empty( $url['host'] ) ) {
							if ( false !== strpos( $url['url'], 'restaurants.yelp' ) ) {
								$url['host'] = 'restaurants.yelp';
							}

							$recommended_appointment_services_urls .= '<a href="' . esc_url( $url['url'] ) . '" target="_blank">' . esc_html( $url['host'] ) .'</a>';
						}
					}
				}
			}
			
			if ( ! empty( $recommended_appointment_services_urls ) ) {
				$recommended_appointment_services_output .= '<div class="listar-appointment-recommended-services hidden tags listar-single-tags">' . $recommended_appointment_services_urls . '</div>';
			} else {
				$recommended_appointment_services_output = '';
			}

			$fields['job']['job_business_bookings_third_party_service'] = array(
				'label'       => esc_html__( 'Appointment Service Embedding Code', 'listar' ),
				'type'        => 'textarea',
				'required'    => false,
				'description' => sprintf(

					/* TRANSLATORS: 1: HTML example, 2:HTML example, 3:HTML example */
					esc_html__( 'Insert a link (e.g. http://any-site.com) or HTML code containing: %1$s or %2$s', 'listar' ) . '<br>' . esc_html__( 'You can use %3$s as well, but only known markups will be validated.', 'listar' ),
					htmlentities( '<iframe src>' ),
					htmlentities( '<a href>' ),
					htmlentities( '<script src>' )
				) . wp_kses( $recommended_appointment_services_output, 'listar-basic-html' ),
				'placeholder' => esc_html__( 'Paste the generated code here', 'listar' ),
				'priority'    => 5.9827,
			);
		}
		
		$listar_price_range_disable = (int) get_option( 'listar_price_range_disable' );

		if ( 0 === $listar_price_range_disable ) {
			$fields['job']['job_pricerange'] = array(
				'label'       => esc_html__( 'Price Range', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '',
				'priority'    => 6,
			);
		}

		$listar_popular_price_disable = (int) get_option( 'listar_popular_price_disable' );

		if ( 0 === $listar_popular_price_disable ) {
			$fields['job']['job_priceaverage'] = array(
				'label'       => esc_html__( 'Most Popular or Average Price', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '',
				'priority'    => 7,
			);
		}

		$listar_logo_disable = (int) get_option( 'listar_logo_disable' );

		if ( 0 === $listar_logo_disable ) {
			$fields['company']['company_logotype'] = array(
				'label'         => __( 'Listing Logo', 'listar' ),
				'description'   => __( 'Recommended size: 400x400px or proportional', 'listar' ),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 0.9,
				'ajax'          => true,
				'allowed_mime_types' => array(
					'jpg'       => 'image/jpeg',
					'jpeg'      => 'image/jpeg',
					'gif'       => 'image/gif',
					'png'       => 'image/png',
				)
			);
		}

		$fields['company']['gallery_images'] = array(
			'label'              => esc_html__( 'Images to Gallery', 'listar' ),
			'type'               => 'file',
			'multiple'           => true,
			'priority'           => 1,
			'required'           => false,
			'ajax'               => true,
			'allowed_mime_types' => array(
				'jpg'  => 'image/jpeg',
				'jpeg' => 'image/jpeg',
				'gif'  => 'image/gif',
				'png'  => 'image/png',
			),
		);

		$fields['company']['company_excerpt'] = array(
			'label'       => esc_html__( 'Short Description (Automatic)', 'listar' ),
			'type'        => 'textarea',
			'required'    => false,
			'placeholder' => esc_html__( 'Short Description', 'listar' ),
			'priority'    => 4.8,
		);

		$listar_phone_disable = (int) get_option( 'listar_phone_disable' );

		if ( 0 === $listar_phone_disable ) {
			$fields['company']['company_phone'] = array(
				'label'       => esc_html__( 'Phone', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'priority'    => 3,
				'description' => esc_html__( "The country calling code will be automatically added as a prefix to your phone numbers. Please, don't remove it manually, once this code is required to properly execute online calls.", 'listar' ),
			);
		}

		$listar_fax_disable = (int) get_option( 'listar_fax_disable' );

		if ( 0 === $listar_fax_disable ) {
			$fields['company']['company_fax'] = array(
				'label'       => esc_html__( 'Fax', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'priority'    => 4,
			);
		}

		$listar_mobile_disable = (int) get_option( 'listar_mobile_disable' );

		if ( 0 === $listar_mobile_disable ) {
			$fields['company']['company_mobile'] = array(
				'label'       => esc_html__( 'Mobile', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'priority'    => 4,
			);
		}

		$listar_whatsapp_disable = (int) get_option( 'listar_whatsapp_disable' );

		if ( 0 === $listar_whatsapp_disable ) {
			$fields['company']['company_whatsapp'] = array(
				'label'       => 'WhatsApp',
				'type'        => 'text',
				'required'    => false,
				'priority'    => 4,
			);
		}
		
		$listar_social_networks_disable = (int) get_option( 'listar_social_networks_disable' );

		if ( 0 === $listar_social_networks_disable ) {
			$fields['company']['company_use_social_networks'] = array(
				'label'       => esc_html__( 'Social Networks', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to inform social networks for your business.', 'listar' ),
				'priority'    => 6.9,
			);

			$fields['company']['company_facebook'] = array(
				'label'       => 'Facebook',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 7,
			);

			$fields['company']['company_instagram'] = array(
				'label'       => 'Instagram',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 8,
			);

			$fields['company']['company_linkedin'] = array(
				'label'       => 'Linkedin',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 9,
			);

			$fields['company']['company_pinterest'] = array(
				'label'       => 'Pinterest',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 10,
			);

			$fields['company']['company_youtube'] = array(
				'label'       => 'Youtube',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 11,
			);

			$fields['company']['company_googleplus'] = array(
				'label'       => 'Google+',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 12,
			);

			$fields['company']['company_vimeo'] = array(
				'label'       => 'Vimeo',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 13,
			);

			$fields['company']['company_vk'] = array(
				'label'       => 'VK',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 14,
			);

			$fields['company']['company_foursquare'] = array(
				'label'       => 'Foursquare',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 15,
			);

			$fields['company']['company_tripadvisor'] = array(
				'label'       => 'TripAdvisor',
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'priority'    => 15,
			);
		}
		
		$listar_external_references_disable = (int) get_option( 'listar_external_references_disable' );

		if ( 0 === $listar_external_references_disable ) {
			$fields['company']['company_use_external_links'] = array(
				'label'       => esc_html__( 'External References', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to inform external links for "References" section.', 'listar' ),
				'priority'    => 16,
			);

			$fields['company']['company_external_link_1'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'1'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 17,
			);

			$fields['company']['company_external_link_2'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'2'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 18,
			);

			$fields['company']['company_external_link_3'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'3'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 19,
			);

			$fields['company']['company_external_link_4'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'4'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 20,
			);

			$fields['company']['company_external_link_5'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'5'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 21,
			);

			$fields['company']['company_external_link_6'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'6'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 22,
			);

			$fields['company']['company_external_link_7'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'7'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 23,
			);

			$fields['company']['company_external_link_8'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'8'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 24,
			);

			$fields['company']['company_external_link_9'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'9'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 25,
			);

			$fields['company']['company_external_link_10'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'10'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 26,
			);

			$fields['company']['company_external_link_11'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'11'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 27,
			);

			$fields['company']['company_external_link_12'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'12'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 28,
			);
		}

		$fields['company']['company_featured_listing_category'] = array(
			'label'       => '',
			'type'        => 'text',
			'required'    => false,
			'placeholder' => '',
			'priority'    => 500,
		);

		$fields['company']['company_featured_listing_region'] = array(
			'label'       => '',
			'type'        => 'text',
			'required'    => false,
			'placeholder' => '',
			'priority'    => 501,
		);
		
		$listing_view_counter_shown_by_default = listar_single_listing_view_counter_active();
		$listing_owners_handle_counters = (int) get_option( 'listar_allow_listing_owners_handle_counter' );
		$listing_owners_can_handle_counters = 1 === $listing_owners_handle_counters ? true : false;
		
		if ( $listing_owners_can_handle_counters ) {
			if ( $listing_view_counter_shown_by_default ) {
				$fields['company']['company_disable_views_counter'] = array(
					'label'       => esc_html__( 'Hide views counter on the listing page?', 'listar' ),
					'type'        => 'checkbox',
					'required'    => false,
					'description' => esc_html__( 'Yes, disable', 'listar' ),
					'priority'    => 29,
				);
			} else {
				$fields['company']['company_enable_views_counter'] = array(
					'label'       => esc_html__( 'Show views counter on the listing page?', 'listar' ),
					'type'        => 'checkbox',
					'required'    => false,
					'description' => esc_html__( 'Activate', 'listar' ),
					'priority'    => 29,
				);
			}
		}

		return $fields;
	}

endif;


add_action( 'job_manager_update_job_data', 'listar_sanitize_listing_data_and_save_frontend', 100, 2 );

if ( ! function_exists( 'listar_sanitize_listing_data_and_save_frontend' ) ) :
	/**
	 * Sanitize WP Job Manager data after a listing submission on front end form.
	 *
	 * @since 1.0
	 * @param (integer) $post_id ID of the listing.
	 * @param (array)   $values Values that were sent on listing submission.
	 */
	function listar_sanitize_listing_data_and_save_frontend( $post_id, $values ) {

		$img_urls = isset( $values['company']['gallery_images'] ) ? $values['company']['gallery_images'] : '';

		if ( ! empty( $img_urls ) ) {

			$temp_ids = array();
			$count   = is_array( $img_urls ) ? count( $img_urls ) : 0;

			for ( $i = 0; $i < $count; $i++ ) {
				$temp_ids[] = attachment_url_to_postid( $img_urls[ $i ] );
			}

			$ids = implode( ',', $temp_ids );
			$shortcode = '[gallery ids=' . $ids . ']';
			update_post_meta( $post_id, '_gallery', $shortcode );

		} else {
			update_post_meta( $post_id, '_gallery', '[gallery ids=]' );
		}

		if ( isset( $values['job']['job_description'] ) ) {
			$input = listar_excerpt_limit( $values['job']['job_description'], 300, false );
			update_post_meta( $post_id, '_company_excerpt', $input );
		}

		if ( isset( $values['company']['company_facebook'] ) ) {
			$input = listar_sanitize_facebook( $values['company']['company_facebook'] );
			update_post_meta( $post_id, '_company_facebook', $input );
		}

		if ( isset( $values['company']['company_twitter'] ) ) {
			$input = listar_sanitize_twitter( $values['company']['company_twitter'] );
			update_post_meta( $post_id, '_company_twitter', $input );
		}

		if ( isset( $values['company']['company_instagram'] ) ) {
			$input = listar_sanitize_instagram( $values['company']['company_instagram'] );
			update_post_meta( $post_id, '_company_instagram', $input );
		}

		if ( isset( $values['company']['company_linkedin'] ) ) {
			$input = listar_sanitize_linkedin( $values['company']['company_linkedin'] );
			update_post_meta( $post_id, '_company_linkedin', $input );
		}

		if ( isset( $values['company']['company_pinterest'] ) ) {
			$input = listar_sanitize_pinterest( $values['company']['company_pinterest'] );
			update_post_meta( $post_id, '_company_pinterest', $input );
		}

		if ( isset( $values['company']['company_youtube'] ) ) {
			$input = listar_sanitize_youtube( $values['company']['company_youtube'] );
			update_post_meta( $post_id, '_company_youtube', $input );
		}

		if ( isset( $values['company']['company_googleplus'] ) ) {
			$input = listar_sanitize_googleplus( $values['company']['company_googleplus'] );
			update_post_meta( $post_id, '_company_googleplus', $input );
		}

		if ( isset( $values['company']['company_vimeo'] ) ) {
			$input = listar_sanitize_vimeo( $values['company']['company_vimeo'] );
			update_post_meta( $post_id, '_company_vimeo', $input );
		}

		if ( isset( $values['company']['company_vk'] ) ) {
			$input = listar_sanitize_vk( $values['company']['company_vk'] );
			update_post_meta( $post_id, '_company_vk', $input );
		}

		if ( isset( $values['company']['company_foursquare'] ) ) {
			$input = listar_sanitize_foursquare( $values['company']['company_foursquare'] );
			update_post_meta( $post_id, '_company_foursquare', $input );
		}

		if ( isset( $values['company']['company_tripadvisor'] ) ) {
			$input = listar_sanitize_tripadvisor( $values['company']['company_tripadvisor'] );
			update_post_meta( $post_id, '_company_tripadvisor', $input );
		}

		if ( isset( $values['company']['company_website'] ) ) {
			$input = listar_sanitize_website( $values['company']['company_website'] );
			update_post_meta( $post_id, '_company_website', $input );
		}

		if ( isset( $values['company']['company_video'] ) ) {
			$input = listar_sanitize_youtube_video( $values['company']['company_video'] );
			update_post_meta( $post_id, '_company_video', $input );
		}

		if ( isset( $values['company']['company_external_link_1'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_1'] );
			update_post_meta( $post_id, '_company_external_link_1', $input );
		}

		if ( isset( $values['company']['company_external_link_2'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_2'] );
			update_post_meta( $post_id, '_company_external_link_2', $input );
		}

		if ( isset( $values['company']['company_external_link_3'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_3'] );
			update_post_meta( $post_id, '_company_external_link_3', $input );
		}

		if ( isset( $values['company']['company_external_link_4'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_4'] );
			update_post_meta( $post_id, '_company_external_link_4', $input );
		}

		if ( isset( $values['company']['company_external_link_5'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_5'] );
			update_post_meta( $post_id, '_company_external_link_5', $input );
		}

		if ( isset( $values['company']['company_external_link_6'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_6'] );
			update_post_meta( $post_id, '_company_external_link_6', $input );
		}

		if ( isset( $values['company']['company_external_link_7'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_7'] );
			update_post_meta( $post_id, '_company_external_link_7', $input );
		}

		if ( isset( $values['company']['company_external_link_8'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_8'] );
			update_post_meta( $post_id, '_company_external_link_8', $input );
		}

		if ( isset( $values['company']['company_external_link_9'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_9'] );
			update_post_meta( $post_id, '_company_external_link_9', $input );
		}

		if ( isset( $values['company']['company_external_link_10'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_10'] );
			update_post_meta( $post_id, '_company_external_link_10', $input );
		}

		if ( isset( $values['company']['company_external_link_11'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_11'] );
			update_post_meta( $post_id, '_company_external_link_11', $input );
		}

		if ( isset( $values['company']['company_external_link_12'] ) ) {
			$input = listar_sanitize_url( $values['company']['company_external_link_12'] );
			update_post_meta( $post_id, '_company_external_link_12', $input );
		}

		if ( isset( $values['job']['job_business_document_1_file_external'] ) ) {
			$input = listar_sanitize_url( $values['job']['job_business_document_1_file_external'] );
			update_post_meta( $post_id, '_job_business_document_1_file_external', $input );
		}

		if ( isset( $values['job']['job_business_document_2_file_external'] ) ) {
			$input = listar_sanitize_url( $values['job']['job_business_document_2_file_external'] );
			update_post_meta( $post_id, '_job_business_document_2_file_external', $input );
		}

		if ( isset( $values['job']['job_business_document_3_file_external'] ) ) {
			$input = listar_sanitize_url( $values['job']['job_business_document_3_file_external'] );
			update_post_meta( $post_id, '_job_business_document_3_file_external', $input );
		}

		if ( isset( $values['job']['job_business_document_4_file_external'] ) ) {
			$input = listar_sanitize_url( $values['job']['job_business_document_4_file_external'] );
			update_post_meta( $post_id, '_job_business_document_4_file_external', $input );
		}

		if ( isset( $values['job']['job_business_document_5_file_external'] ) ) {
			$input = listar_sanitize_url( $values['job']['job_business_document_5_file_external'] );
			update_post_meta( $post_id, '_job_business_document_5_file_external', $input );
		}

		if ( isset( $values['job']['job_business_document_6_file_external'] ) ) {
			$input = listar_sanitize_url( $values['job']['job_business_document_6_file_external'] );
			update_post_meta( $post_id, '_job_business_document_6_file_external', $input );
		}

		if ( isset( $values['job']['job_fix_for_checkboxes'] ) && ! empty( $values['job']['job_fix_for_checkboxes'] ) ) {
			if ( false !== strpos( $values['job']['job_fix_for_checkboxes'], '-----' ) ) {
				$checkboxes = explode( '-----', $values['job']['job_fix_for_checkboxes'] );
				
				foreach( $checkboxes as $temp ) {
					if ( ! empty( $temp ) ) {
						if ( false !== strpos( $temp, 'checkboxischecked_0' ) ) {
							$field_key = str_replace( 'checkboxischecked_0', '', $temp );
							update_post_meta( $post_id, $field_key, '' );
						} elseif ( false !== strpos( $temp, 'checkboxischecked_1' ) ) {
							$field_key = str_replace( 'checkboxischecked_1', '', $temp );
							update_post_meta( $post_id, $field_key, '1' );
						}
					}
				}
			}
		}
	}

endif;


add_action( 'save_post', 'listar_sanitize_listing_data_and_save_backend', 10, 3 );

if ( ! function_exists( 'listar_sanitize_listing_data_and_save_backend' ) ) :
	/**
	 * Sanitize WP Job Manager data after a listing submission via WordPress post editor.
	 * Notice: All these fields were generically sanitized by WP Job Manager plugin according with the type of input data.
	 *
	 * @since 1.0
	 * @param (integer) $post_id The ID of the post.
	 * @param (object)  $post The current post object.
	 * @param (array)   $update Whether this is an existing post being updated or not.
	 */
	function listar_sanitize_listing_data_and_save_backend( $post_id, $post, $update ) {

		$post_type = get_post_type( $post );

		if ( ! is_admin() ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( 'job_listing' !== $post_type ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( 'job_listing' === $post_type ) {
			$facebook         = get_post_meta( $post_id, '_company_facebook', true );
			$twitter          = get_post_meta( $post_id, '_company_twitter', true );
			$instagram        = get_post_meta( $post_id, '_company_instagram', true );
			$linkedin         = get_post_meta( $post_id, '_company_linkedin', true );
			$pinterest        = get_post_meta( $post_id, '_company_pinterest', true );
			$youtube          = get_post_meta( $post_id, '_company_youtube', true );
			$googleplus       = get_post_meta( $post_id, '_company_googleplus', true );
			$vimeo            = get_post_meta( $post_id, '_company_vimeo', true );
			$vk               = get_post_meta( $post_id, '_company_vk', true );
			$foursquare       = get_post_meta( $post_id, '_company_foursquare', true );
			$tripadvisor      = get_post_meta( $post_id, '_company_tripadvisor', true );
			$website          = get_post_meta( $post_id, '_company_website', true );
			$video            = get_post_meta( $post_id, '_company_video', true );
			$sanitized        = '';
			$external_link_1  = get_post_meta( $post_id, '_company_external_link_1', true );
			$external_link_2  = get_post_meta( $post_id, '_company_external_link_2', true );
			$external_link_3  = get_post_meta( $post_id, '_company_external_link_3', true );
			$external_link_4  = get_post_meta( $post_id, '_company_external_link_4', true );
			$external_link_5  = get_post_meta( $post_id, '_company_external_link_5', true );
			$external_link_6  = get_post_meta( $post_id, '_company_external_link_6', true );
			$external_link_7  = get_post_meta( $post_id, '_company_external_link_7', true );
			$external_link_8  = get_post_meta( $post_id, '_company_external_link_8', true );
			$external_link_9  = get_post_meta( $post_id, '_company_external_link_9', true );
			$external_link_10 = get_post_meta( $post_id, '_company_external_link_10', true );
			$external_link_11 = get_post_meta( $post_id, '_company_external_link_11', true );
			$external_link_12 = get_post_meta( $post_id, '_company_external_link_12', true );
			$external_doc_1   = get_post_meta( $post_id, '_job_business_document_1_file_external', true );
			$external_doc_2   = get_post_meta( $post_id, '_job_business_document_2_file_external', true );
			$external_doc_3   = get_post_meta( $post_id, '_job_business_document_3_file_external', true );
			$external_doc_4   = get_post_meta( $post_id, '_job_business_document_4_file_external', true );
			$external_doc_5   = get_post_meta( $post_id, '_job_business_document_5_file_external', true );

			if ( isset( $post->post_content ) ) {
				$sanitized = listar_excerpt_limit( $post->post_content, 300, false );
				update_post_meta( $post_id, '_company_excerpt', $sanitized );
			}

			if ( ! empty( $facebook ) ) {
				$sanitized = listar_sanitize_facebook( $facebook );

				if ( $sanitized !== $facebook ) {
					update_post_meta( $post_id, '_company_facebook', $sanitized );
				}
			}

			if ( ! empty( $twitter ) ) {
				$sanitized = listar_sanitize_twitter( $twitter );

				if ( $sanitized !== $twitter ) {
					update_post_meta( $post_id, '_company_twitter', $sanitized );
				}
			}

			if ( ! empty( $instagram ) ) {
				$sanitized = listar_sanitize_instagram( $instagram );

				if ( $sanitized !== $instagram ) {
					update_post_meta( $post_id, '_company_instagram', $sanitized );
				}
			}

			if ( ! empty( $linkedin ) ) {
				$sanitized = listar_sanitize_linkedin( $linkedin );

				if ( $sanitized !== $linkedin ) {
					update_post_meta( $post_id, '_company_linkedin', $sanitized );
				}
			}

			if ( ! empty( $pinterest ) ) {
				$sanitized = listar_sanitize_pinterest( $pinterest );

				if ( $sanitized !== $pinterest ) {
					update_post_meta( $post_id, '_company_pinterest', $sanitized );
				}
			}

			if ( ! empty( $youtube ) ) {
				$sanitized = listar_sanitize_youtube( $youtube );

				if ( $sanitized !== $youtube ) {
					update_post_meta( $post_id, '_company_youtube', $sanitized );
				}
			}

			if ( ! empty( $googleplus ) ) {
				$sanitized = listar_sanitize_googleplus( $googleplus );

				if ( $sanitized !== $googleplus ) {
					update_post_meta( $post_id, '_company_googleplus', $sanitized );
				}
			}

			if ( ! empty( $vimeo ) ) {
				$sanitized = listar_sanitize_vimeo( $vimeo );

				if ( $sanitized !== $vimeo ) {
					update_post_meta( $post_id, '_company_vimeo', $sanitized );
				}
			}

			if ( ! empty( $vk ) ) {
				$sanitized = listar_sanitize_vk( $vk );

				if ( $sanitized !== $vk ) {
					update_post_meta( $post_id, '_company_vk', $sanitized );
				}
			}

			if ( ! empty( $foursquare ) ) {
				$sanitized = listar_sanitize_foursquare( $foursquare );

				if ( $sanitized !== $foursquare ) {
					update_post_meta( $post_id, '_company_foursquare', $sanitized );
				}
			}

			if ( ! empty( $tripadvisor ) ) {
				$sanitized = listar_sanitize_tripadvisor( $tripadvisor );

				if ( $sanitized !== $tripadvisor ) {
					update_post_meta( $post_id, '_company_tripadvisor', $sanitized );
				}
			}

			if ( ! empty( $external_link_1 ) ) {
				$sanitized = listar_sanitize_url( $external_link_1 );

				if ( $sanitized !== $external_link_1 ) {
					update_post_meta( $post_id, '_company_external_link_1', $sanitized );
				}
			}

			if ( ! empty( $external_link_2 ) ) {
				$sanitized = listar_sanitize_url( $external_link_2 );

				if ( $sanitized !== $external_link_2 ) {
					update_post_meta( $post_id, '_company_external_link_2', $sanitized );
				}
			}

			if ( ! empty( $external_link_3 ) ) {
				$sanitized = listar_sanitize_url( $external_link_3 );

				if ( $sanitized !== $external_link_3 ) {
					update_post_meta( $post_id, '_company_external_link_3', $sanitized );
				}
			}

			if ( ! empty( $external_link_4 ) ) {
				$sanitized = listar_sanitize_url( $external_link_4 );

				if ( $sanitized !== $external_link_4 ) {
					update_post_meta( $post_id, '_company_external_link_4', $sanitized );
				}
			}

			if ( ! empty( $external_link_5 ) ) {
				$sanitized = listar_sanitize_url( $external_link_5 );

				if ( $sanitized !== $external_link_5 ) {
					update_post_meta( $post_id, '_company_external_link_5', $sanitized );
				}
			}

			if ( ! empty( $external_link_6 ) ) {
				$sanitized = listar_sanitize_url( $external_link_6 );

				if ( $sanitized !== $external_link_6 ) {
					update_post_meta( $post_id, '_company_external_link_6', $sanitized );
				}
			}

			if ( ! empty( $external_link_7 ) ) {
				$sanitized = listar_sanitize_url( $external_link_7 );

				if ( $sanitized !== $external_link_7 ) {
					update_post_meta( $post_id, '_company_external_link_7', $sanitized );
				}
			}

			if ( ! empty( $external_link_8 ) ) {
				$sanitized = listar_sanitize_url( $external_link_8 );

				if ( $sanitized !== $external_link_8 ) {
					update_post_meta( $post_id, '_company_external_link_8', $sanitized );
				}
			}

			if ( ! empty( $external_link_9 ) ) {
				$sanitized = listar_sanitize_url( $external_link_9 );

				if ( $sanitized !== $external_link_9 ) {
					update_post_meta( $post_id, '_company_external_link_9', $sanitized );
				}
			}

			if ( ! empty( $external_link_10 ) ) {
				$sanitized = listar_sanitize_url( $external_link_10 );

				if ( $sanitized !== $external_link_10 ) {
					update_post_meta( $post_id, '_company_external_link_10', $sanitized );
				}
			}

			if ( ! empty( $external_link_11 ) ) {
				$sanitized = listar_sanitize_url( $external_link_11 );

				if ( $sanitized !== $external_link_11 ) {
					update_post_meta( $post_id, '_company_external_link_11', $sanitized );
				}
			}

			if ( ! empty( $external_link_12 ) ) {
				$sanitized = listar_sanitize_url( $external_link_12 );

				if ( $sanitized !== $external_link_12 ) {
					update_post_meta( $post_id, '_company_external_link_12', $sanitized );
				}
			}

			if ( ! empty( $external_doc_1 ) ) {
				$sanitized = listar_sanitize_url( $external_doc_1 );

				if ( $sanitized !== $external_doc_1 ) {
					update_post_meta( $post_id, '_job_business_document_1_file_external', $sanitized );
				}
			}

			if ( ! empty( $external_doc_2 ) ) {
				$sanitized = listar_sanitize_url( $external_doc_2 );

				if ( $sanitized !== $external_doc_2 ) {
					update_post_meta( $post_id, '_job_business_document_2_file_external', $sanitized );
				}
			}

			if ( ! empty( $external_doc_3 ) ) {
				$sanitized = listar_sanitize_url( $external_doc_3 );

				if ( $sanitized !== $external_doc_3 ) {
					update_post_meta( $post_id, '_job_business_document_3_file_external', $sanitized );
				}
			}

			if ( ! empty( $external_doc_4 ) ) {
				$sanitized = listar_sanitize_url( $external_doc_4 );

				if ( $sanitized !== $external_doc_4 ) {
					update_post_meta( $post_id, '_job_business_document_4_file_external', $sanitized );
				}
			}

			if ( ! empty( $external_doc_5 ) ) {
				$sanitized = listar_sanitize_url( $external_doc_5 );

				if ( $sanitized !== $external_doc_5 ) {
					update_post_meta( $post_id, '_job_business_document_5_file_external', $sanitized );
				}
			}

			if ( ! empty( $website ) ) {
				$sanitized = listar_sanitize_website( $website );

				if ( $sanitized !== $website ) {
					update_post_meta( $post_id, '_company_website', $sanitized );
				}
			}

			if ( ! empty( $video ) ) {
				$sanitized = listar_sanitize_youtube_video( $video );

				if ( $sanitized !== $video ) {
					update_post_meta( $post_id, '_company_video', $sanitized );
				}
			}
		}// End if().
	}

endif;


add_filter( 'job_manager_job_listing_data_fields', 'listar_backend_add_jobmanager_fields', 20 );

if ( ! function_exists( 'listar_backend_add_jobmanager_fields' ) ) :
	/**
	 * Adding custom fields to WP Job Manager submission form - Back end.
	 *
	 * @since 1.0
	 * @param (array) $fields WP Job Manager input fields settings.
	 * @return (array)
	 */
	function listar_backend_add_jobmanager_fields( $fields ) {

		$fields['_job_custom_email'] = array(
			'label'       => esc_html__( 'Custom Contact Email', 'listar' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'name@domain.com', 'listar' ),
			'priority'    => 0.011,
		);
		
		$listar_disable_private_messages = (int) get_option( 'listar_disable_private_message' );
		
		if ( 0 === $listar_disable_private_messages ) {
			$fields['_job_disable_privatemessage'] = array(
				'label'       => esc_html__( 'Disable Private Messages', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'If checked, the Private Message form will be hidden', 'listar' ),
				'priority'    => 0.011,
			);
		}

		$fields['_job_listing_subtitle'] = array(
			'label'       => esc_html__( 'Listing Subtitle', 'listar' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'e.g. Since 1992', 'listar' ),
			'priority'    => 0.009,
		);

		$fields['_job_useuseremail'] = array(
			'label'       => esc_html__( 'Use Default Email', 'listar' ),
			'type'        => 'checkbox',
			'description' => esc_html__( 'If checked, the email set on your profile will be shown on the listing contact data', 'listar' ),
			'required'    => false,
			'priority'    => 0.01,
		);

		$gallery_options = array(
			'gallery-default'    => esc_html__( 'Default', 'listar' ),
			'slideshow-rounded'  => esc_html__( 'Slideshow, circular thumbnails', 'listar' ),
			'slideshow-squared'  => esc_html__( 'Slideshow, squared thumbnails', 'listar' ),
			'tiny-rounded'       => esc_html__( 'Circular, boxed', 'listar' ),
			'tiny-rounded-dark'  => esc_html__( 'Circular, boxed, dark', 'listar' ),
			'rounded-boxed'      => esc_html__( 'Oval, boxed', 'listar' ),
			'rounded-boxed-dark' => esc_html__( 'Oval, boxed, dark', 'listar' ),
			'rounded'            => esc_html__( 'Oval, wide', 'listar' ),
			'rounded-dark'       => esc_html__( 'Oval, wide, dark', 'listar' ),
			'squared-boxed'      => esc_html__( 'Rectangular, boxed', 'listar' ),
			'squared-boxed-dark' => esc_html__( 'Rectangular, boxed, dark', 'listar' ),
			'squared'            => esc_html__( 'Rectangular, wide', 'listar' ),
			'squared-dark'       => esc_html__( 'Rectangular, wide, dark', 'listar' ),
			'tiny-squared'       => esc_html__( 'Squared, boxed', 'listar' ),
			'tiny-squared-dark'  => esc_html__( 'Squared, boxed, dark', 'listar' ),
		);

		$fields['_job_gallery_design'] = array(
			'label'       => esc_html__( 'Listing Gallery Design', 'listar' ),
			'type'        => 'select',
			'options'     => $gallery_options,
			'description' => '',
			'priority'    => 0.019,
		);

		$fields['_job_tagline'] = array(
			'label'       => esc_html__( 'Tagline or Slogan', 'listar' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Fine Wines, Crafted with Artistry and Passion', 'listar' ),
			'description' => '',
			'priority'    => 0.02,
		);

		$fields['_company_excerpt'] = array(
			'label'       => esc_html__( 'Short Description (Automatic)', 'listar' ),
			'type'        => 'textarea',
			'required'    => false,
			'placeholder' => esc_html__( 'Short Description', 'listar' ),
			'priority'    => 0.03,
		);

		if ( taxonomy_exists( 'job_listing_amenity' ) ) :
			$fields['_job_amenities'] = array(
				'label'       => esc_html__( 'Listing Amenities', 'listar' ),
				'type'        => 'term-multiselect',
				'placeholder' => '',
				'taxonomy'    => 'job_listing_amenity',
				'priority'    => 4.8,
			);
		endif;
		
		$fields['_job_searchtags'] = array(
			'label'       => esc_html__( 'Search tags', 'listar' ),
			'type'        => 'textarea',
			'required'    => false,
			'placeholder' => esc_html__( 'Dinner pasta salad coffee sandwich soda wine...', 'listar' ),
			'priority'    => 4.801,
		);

		$listar_logo_disable = (int) get_option( 'listar_logo_disable' );

		if ( 0 === $listar_logo_disable ) {
			$fields['_company_logotype'] = array(
				'label'         => __( 'Listing Logo', 'listar' ),
				'description'   => __( 'Recommended size: 400x400px or proportional', 'listar' ),
				'type'          => 'file',
				'priority'      => 3.05,
				'ajax'          => true,
				'allowed_mime_types' => array(
					'jpg'       => 'image/jpeg',
					'jpeg'      => 'image/jpeg',
					'gif'       => 'image/gif',
					'png'       => 'image/png',
				)
			);
		}

		$listar_phone_disable = (int) get_option( 'listar_phone_disable' );

		if ( 0 === $listar_phone_disable ) {
			$fields['_company_phone'] = array(
				'label'       => esc_html__( 'Phone', 'listar' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'e.g.', 'listar' ) . ' +49-636-4808',
				'description' => '',
				'priority'    => 3.1,
			);
		}

		$listar_fax_disable = (int) get_option( 'listar_fax_disable' );

		if ( 0 === $listar_fax_disable ) {
			$fields['_company_fax'] = array(
				'label'       => esc_html__( 'Fax', 'listar' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'e.g.', 'listar' ) . ' +49-636-4808',
				'description' => '',
				'priority'    => 3.2,
			);
		}

		$listar_mobile_disable = (int) get_option( 'listar_mobile_disable' );

		if ( 0 === $listar_mobile_disable ) {
			$fields['_company_mobile'] = array(
				'label'       => esc_html__( 'Mobile', 'listar' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'e.g.', 'listar' ) . ' +49-636-4808',
				'description' => '',
				'priority'    => 3.3,
			);
		}

		$listar_whatsapp_disable = (int) get_option( 'listar_whatsapp_disable' );

		if ( 0 === $listar_whatsapp_disable ) {
			$fields['_company_whatsapp'] = array(
				'label'       => 'WhatsApp',
				'type'        => 'text',
				'placeholder' => esc_html__( 'e.g.', 'listar' ) . ' +49-636-4808',
				'description' => '',
				'priority'    => 3.3,
			);
		}

		/* Social */
		
		$listar_social_networks_disable = (int) get_option( 'listar_social_networks_disable' );

		if ( 0 === $listar_social_networks_disable ) {
			$fields['_company_use_social_networks'] = array(
				'label'       => esc_html__( 'Social Networks', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to inform social networks for your business.', 'listar' ),
				'priority'    => 5.09,
			);

			$fields['_company_facebook'] = array(
				'label'       => 'Facebook',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.1,
			);

			$fields['_company_instagram'] = array(
				'label'       => 'Instagram',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.2,
			);

			$fields['_company_linkedin'] = array(
				'label'       => 'Linkedin',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.25,
			);

			$fields['_company_pinterest'] = array(
				'label'       => 'Pinterest',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.3,
			);

			$fields['_company_youtube'] = array(
				'label'       => 'Youtube',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.4,
			);

			$fields['_company_googleplus'] = array(
				'label'       => 'Google+',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.45,
			);

			$fields['_company_vimeo'] = array(
				'label'       => 'Vimeo',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.5,
			);

			$fields['_company_vk'] = array(
				'label'       => 'VK',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.6,
			);

			$fields['_company_foursquare'] = array(
				'label'       => 'Foursquare',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.7,
			);

			$fields['_company_tripadvisor'] = array(
				'label'       => 'TripAdvisor',
				'type'        => 'text',
				'placeholder' => esc_html__( 'Username or URL', 'listar' ),
				'description' => '',
				'priority'    => 5.6,
			);
		}
		
		$listar_external_references_disable = (int) get_option( 'listar_external_references_disable' );

		if ( 0 === $listar_external_references_disable ) {
			$fields['_company_use_external_links'] = array(
				'label'       => esc_html__( 'External References', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to inform external links for "References" section.', 'listar' ),
				'priority'    => 16,
			);

			$fields['_company_external_link_1'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'1'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 17,
			);

			$fields['_company_external_link_2'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'2'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 18,
			);

			$fields['_company_external_link_3'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'3'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 19,
			);

			$fields['_company_external_link_4'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'4'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 20,
			);

			$fields['_company_external_link_5'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'5'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 21,
			);

			$fields['_company_external_link_6'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'6'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 22,
			);

			$fields['_company_external_link_7'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'7'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 23,
			);

			$fields['_company_external_link_8'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'8'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 24,
			);

			$fields['_company_external_link_9'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'9'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 25,
			);

			$fields['_company_external_link_10'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'10'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 26,
			);

			$fields['_company_external_link_11'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'11'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 27,
			);

			$fields['_company_external_link_12'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Link %s', 'listar' ),
					'12'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => 'http://',
				'priority'    => 28,
			);
		}

		$fields['_company_featured_listing_category'] = array(
			'label'       => '',
			'type'        => 'text',
			'required'    => false,
			'placeholder' => '',
			'priority'    => 500,
		);

		$fields['_company_featured_listing_region'] = array(
			'label'       => '',
			'type'        => 'text',
			'required'    => false,
			'placeholder' => '',
			'priority'    => 501,
		);
		
		$listing_view_counter_shown_by_default = listar_single_listing_view_counter_active();
		$listing_owners_handle_counters = (int) get_option( 'listar_allow_listing_owners_handle_counter' );
		$listing_owners_can_handle_counters = 1 === $listing_owners_handle_counters ? true : false;
		
		if ( $listing_owners_can_handle_counters ) {
			if ( $listing_view_counter_shown_by_default ) {
				$fields['_company_disable_views_counter'] = array(
					'label'       => esc_html__( 'Hide views counter on the listing page?', 'listar' ),
					'type'        => 'checkbox',
					'required'    => false,
					'description' => esc_html__( 'Yes, disable', 'listar' ),
					'priority'    => 29,
				);
			} else {
				$fields['_company_enable_views_counter'] = array(
					'label'       => esc_html__( 'Show views counter on the listing page?', 'listar' ),
					'type'        => 'checkbox',
					'required'    => false,
					'description' => esc_html__( 'Activate', 'listar' ),
					'priority'    => 29,
				);
			}
		}

		$listar_location_disable = (int) get_option( 'listar_location_disable' );
		
		if ( 0 === $listar_location_disable ) {
			$fields['_job_customlatitude'] = array(
				'label'       => esc_html__( 'Force custom Latitute', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '25.84827',
				'priority'    => 1.0001,
			);

			$fields['_job_customlongitude'] = array(
				'label'       => esc_html__( 'Force custom Longitude', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '-80.18444',
				'priority'    => 1.00012,
			);

			$location_options = array(
				'location-default'  => esc_html__( 'Use default location address', 'listar' ),
				'location-geocoded' => esc_html__( 'Use geocoded address', 'listar' ),
				'location-custom'   => esc_html__( 'Use custom address', 'listar' ),
			);

			$fields['_job_locationselector'] = array(
				'label'       => esc_html__( 'Public address', 'listar' ),
				'type'        => 'select',
				'required'    => false,
				'options'     => $location_options,
				'priority'    => 1.00013,
			);

			$fields['_job_customlocation'] = array(
				'label'       => esc_html__( 'Enter new address for public view', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( '7919 Biscayne Boulevard, Miami, FL 33138', 'listar' ),
				'priority'    => 1.00014,
			);
		}

		$fields['_job_business_use_custom_excerpt'] = array(
			'label'       => esc_html__( 'Customize Short Description', 'listar' ),
			'type'        => 'checkbox',
			'required'    => false,
			'description' => esc_html__( 'Short descriptions are generated automatically. Check to write a custom text for cards.', 'listar' ),
			'priority'    => 1.00038,
		);

		$fields['_job_business_custom_excerpt'] = array(
			'label'       => esc_html__( 'Short Description (Custom)', 'listar' ),
			'type'        => 'textarea',
			'required'    => false,
			'placeholder' => esc_html__( 'Short Description', 'listar' ),
			'priority'    => 1.00039,
		);

		if ( listar_is_claim_enabled() ) :
			$claim_options = array(
				'not-claimed'         => esc_html__( 'Not Claimed', 'listar' ),
				'awaiting-moderation' => esc_html__( 'Awaiting Moderation', 'listar' ),
				'claimed'             => esc_html__( 'Claimed', 'listar' ),
				'claim-disabled'      => esc_html__( 'Disable Claim', 'listar' ),
			);

			$fields['_job_businessclaim'] = array(
				'label'       => esc_html__( 'Business Claim', 'listar' ),
				'type'        => 'select',
				'required'    => false,
				'options'     => $claim_options,
				'priority'    => 1.0004,
			);
		endif;
		
		$listar_operating_hours_disable = (int) get_option( 'listar_operating_hours_disable' );

		if ( 0 === $listar_operating_hours_disable ) {
			$fields['_job_business_use_hours'] = array(
				'label'       => esc_html__( 'Operation Hours', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to inform the hours of operation for your business.', 'listar' ),
				'priority'    => 1.0005,
			);

			$fields['_job_business_hours_monday'] = array(
				'label'       => esc_html__( 'Monday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 1.001,
			);

			$fields['_job_business_hours_tuesday'] = array(
				'label'       => esc_html__( 'Tuesday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 1.002,
			);

			$fields['_job_business_hours_wednesday'] = array(
				'label'       => esc_html__( 'Wednesday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 1.003,
			);

			$fields['_job_business_hours_thursday'] = array(
				'label'       => esc_html__( 'Thursday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 1.004,
			);

			$fields['_job_business_hours_friday'] = array(
				'label'       => esc_html__( 'Friday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 1.005,
			);

			$fields['_job_business_hours_saturday'] = array(
				'label'       => esc_html__( 'Saturday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 1.006,
			);

			$fields['_job_business_hours_sunday'] = array(
				'label'       => esc_html__( 'Sunday', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '09:00am - 17:00pm',
				'priority'    => 1.007,
			);
		}
		
		$listar_menu_catalog_disable = (int) get_option( 'listar_menu_catalog_disable' );

		if ( 0 === $listar_menu_catalog_disable ) {
			$fields['_job_business_use_catalog'] = array(
				'label'       => esc_html__( 'Menu/Catalog', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to publish menu(s), catalog(s) or other list(s) for your business.', 'listar' ),
				'priority'    => 1.0080,
			);

			$menu_label_options = array(
				'menu'      => esc_html__( 'Menu', 'listar' ),
				'catalog'   => esc_html__( 'Catalog', 'listar' ),
				'products'  => esc_html__( 'Products', 'listar' ),
				'services'  => esc_html__( 'Services', 'listar' ),
				'pricing'   => esc_html__( 'Pricing', 'listar' ),
				'files'     => esc_html__( 'Files', 'listar' ),
				'documents' => esc_html__( 'Documents', 'listar' ),
				'downloads' => esc_html__( 'Downloads', 'listar' ),
				'custom'    => esc_html__( 'Custom Label', 'listar' ),
			);

			$fields['_job_business_catalog_label'] = array(
				'label'       => esc_html__( 'Label for Menu/Catalog section', 'listar' ),
				'type'        => 'select',
				'required'    => false,
				'options'     => $menu_label_options,
				'description' => esc_html__( 'Select a label for Menu/Catalog section.', 'listar' ),
				'priority'    => 1.0080,
			);

			$fields['_job_business_catalog_custom_label'] = array(
				'label'       => esc_html__( 'Custom Label for Menu/Catalog section.', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu', 'listar' ),
				'description' => esc_html__( 'Type a single word (preferable) to name the section. It is recommended a maximum of 15 letters.', 'listar' ),
				'priority'    => 1.0080,
			);

			$fields['_job_business_use_price_list'] = array(
				'label'       => esc_html__( 'Product/Service list', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to build a list of products or services.', 'listar' ),
				'priority'    => 1.008001,
			);

			$fields['_job_business_price_list_content'] = array(
				'label'       => '',
				'type'        => 'textarea',
				'required'    => false,
				'description' => esc_html__( 'Create a list of products or services for quick presentation, prices are optional.', 'listar' ),
				'priority'    => 1.008002,
			);

			$fields['_job_business_use_catalog_documents'] = array(
				'label'       => esc_html__( 'I have document(s) to upload', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to upload menu/catalog file(s).', 'listar' ),
				'priority'    => 1.008003,
			);

			$fields['_job_business_document_1_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'1'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.0081,
			);

			$menu_mime_types = array(
				'doc'   => 'application/msword',
				'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'pdf'   => 'application/pdf',
				'jpg'   => 'image/jpeg',
				'jpeg'  => 'image/jpeg',
				'gif'   => 'image/gif',
				'png'   => 'image/png',
				'txt'   => 'text/plain',
				'xls'   => 'application/vnd.ms-excel',
				'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'ppt'   => 'application/vnd.ms-powerpoint',
				'pptx'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				'rtf'   => 'application/rtf',
			);

			$fields['_job_business_document_1_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'1'
				),
				'description'   => esc_html__( 'Valid file formats:', 'listar' ) . ' .jpg, .jpeg, .gif, .png, .txt, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .rtf, .pdf. ' . esc_html__( 'Any other file format need to be converted for one of these.', 'listar' ),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 1.0082,
				'ajax'          => false,
				'allowed_mime_types' => $menu_mime_types,
			);

			$fields['_job_business_document_2_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'2'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.0083,
			);

			$fields['_job_business_document_2_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'2'
				),
				'description'   => esc_html__( 'Valid file formats:', 'listar' ) . ' .jpg, .jpeg, .gif, .png, .txt, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .rtf, .pdf. ' . esc_html__( 'Any other file format need to be converted for one of these.', 'listar' ),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 1.0084,
				'ajax'          => false,
				'allowed_mime_types' => $menu_mime_types,
			);

			$fields['_job_business_document_3_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'3'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.0085,
			);

			$fields['_job_business_document_3_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'3'
				),
				'description'   => esc_html__( 'Valid file formats:', 'listar' ) . ' .jpg, .jpeg, .gif, .png, .txt, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .rtf, .pdf. ' . esc_html__( 'Any other file format need to be converted for one of these.', 'listar' ),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 1.0086,
				'ajax'          => false,
				'allowed_mime_types'  => $menu_mime_types,
			);

			$fields['_job_business_document_4_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'4'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.0087,
			);

			$fields['_job_business_document_4_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'4'
				),
				'description'   => esc_html__( 'Valid file formats:', 'listar' ) . ' .jpg, .jpeg, .gif, .png, .txt, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .rtf, .pdf. ' . esc_html__( 'Any other file format need to be converted for one of these.', 'listar' ),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 1.0088,
				'ajax'          => false,
				'allowed_mime_types'  => $menu_mime_types,
			);

			$fields['_job_business_document_5_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'5'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.0089,
			);

			$fields['_job_business_document_5_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'5'
				),
				'description'   => esc_html__( 'Valid file formats:', 'listar' ) . ' .jpg, .jpeg, .gif, .png, .txt, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .rtf, .pdf. ' . esc_html__( 'Any other file format need to be converted for one of these.', 'listar' ),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 1.009,
				'ajax'          => false,
				'allowed_mime_types'  => $menu_mime_types,
			);

			$fields['_job_business_document_6_title'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Label', 'listar' ),
					'6'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.0091,
			);

			$fields['_job_business_document_6_file'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'File %s - Upload', 'listar' ),
					'6'
				),
				'description'   => esc_html__( 'Valid file formats:', 'listar' ) . ' .jpg, .jpeg, .gif, .png, .txt, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .rtf, .pdf. ' . esc_html__( 'Any other file format need to be converted for one of these.', 'listar' ),
				'type'          => 'file',
				'multiple'      => false,
				'required'      => false,
				'placeholder'   => '',
				'priority'      => 1.0092,
				'ajax'          => false,
				'allowed_mime_types'  => $menu_mime_types,
			);

			$fields['_job_business_use_catalog_external'] = array(
				'label'       => esc_html__( 'I have document(s) or data published on external pages', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to link website(s) with external menu/catalog file(s) or page(s) containing your business data published.', 'listar' ),
				'priority'    => 1.0093,
			);

			$fields['_job_business_document_1_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'1'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.0094,
			);

			$fields['_job_business_document_1_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'1'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 1.0095,
			);

			$fields['_job_business_document_2_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'2'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.0096,
			);

			$fields['_job_business_document_2_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'2'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 1.0097,
			);

			$fields['_job_business_document_3_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'3'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.0098,
			);

			$fields['_job_business_document_3_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'3'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 1.0099,
			);

			$fields['_job_business_document_4_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'4'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.00991,
			);

			$fields['_job_business_document_4_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'4'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 1.00992,
			);

			$fields['_job_business_document_5_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'5'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.00993,
			);

			$fields['_job_business_document_5_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'5'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 1.00994,
			);

			$fields['_job_business_document_6_title_external'] = array(
				'label'       => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Label', 'listar' ),
					'6'
				),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Menu/Catalog Name', 'listar' ),
				'priority'    => 1.00995,
			);

			$fields['_job_business_document_6_file_external'] = array(
				'label'         => sprintf(
					/* TRANSLATORS: a number for ordering. Ex.: 1 */
					esc_html__( 'Page or File %s - Link', 'listar' ),
					'6'
				),
				'type'          => 'text',
				'required'      => false,
				'placeholder'   => 'http://',
				'priority'      => 1.00996,
			);
		}
		
		$listar_booking_service_disable = (int) get_option( 'listar_appointments_disable' );

		if ( 0 === $listar_booking_service_disable ) {
			$fields['_job_business_use_booking'] = array(
				'label'       => esc_html__( 'Appointments', 'listar' ),
				'type'        => 'checkbox',
				'required'    => false,
				'description' => esc_html__( 'Check to use an appointment service, like Acuity, TimeKit, OpenTable, Booksy, Yelp Reservations, etc.', 'listar' ),
				'priority'    => 1.00997,
			);
			
			$appointment_label_options = array(
				'reservation' => esc_html__( 'Reservation', 'listar' ),
				'booking'     => esc_html__( 'Booking', 'listar' ),
				'book-now'    => esc_html__( 'Book Now', 'listar' ),
				'ordering'    => esc_html__( 'Ordering', 'listar' ),
				'custom'      => esc_html__( 'Custom Label', 'listar' ),
			);

			$fields['_job_business_booking_label'] = array(
				'label'       => esc_html__( 'Label for Appointments section', 'listar' ),
				'type'        => 'select',
				'required'    => false,
				'options'     => $appointment_label_options,
				'description' => esc_html__( 'Select a label for Appointments section', 'listar' ),
				'priority'    => 1.009971,
			);

			$fields['_job_business_booking_custom_label'] = array(
				'label'       => esc_html__( 'Custom Label for Appointments section', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => esc_html__( 'Booking', 'listar' ),
				'description' => esc_html__( 'Type a single word (preferable) to name the section. It is recommended a maximum of 15 letters.', 'listar' ),
				'priority'    => 1.009972,
			);

			$fields['_job_business_bookings_third_party_service'] = array(
				'label'       => esc_html__( 'Appointment Service Embedding Code', 'listar' ),
				'type'        => 'textarea',
				'description' => sprintf(

					/* TRANSLATORS: 1: HTML example, 2:HTML example, 3:HTML example */
					esc_html__( 'Insert a link (e.g. http://any-site.com) or HTML code containing: %1$s or %2$s', 'listar' ) . '<br>' . esc_html__( 'You can use %3$s as well, but only known markups will be validated.', 'listar' ),
					htmlentities( '<iframe src>' ),
					htmlentities( '<a href>' ),
					htmlentities( '<script src>' )
				),
				'required'    => false,
				'placeholder' => esc_html__( 'Paste the generated code here', 'listar' ),
				'priority'    => 1.00998,
			);
		}
		
		$listar_price_range_disable = (int) get_option( 'listar_price_range_disable' );

		if ( 0 === $listar_price_range_disable ) {
			$fields['_job_pricerange'] = array(
				'label'       => esc_html__( 'Price Range', 'listar' ),
				'type'        => 'text',
				'placeholder' => '',
				'description' => '',
				'priority'    => 1.01,
			);
		}
		
		$listar_popular_price_disable = (int) get_option( 'listar_popular_price_disable' );

		if ( 0 === $listar_popular_price_disable ) {
			$fields['_job_priceaverage'] = array(
				'label'       => esc_html__( 'Most Popular or Average Price', 'listar' ),
				'type'        => 'text',
				'required'    => false,
				'placeholder' => '',
				'priority'    => 1.02,
			);
		}

		return $fields;
	}

endif;


add_action( 'init', 'listar_change_post_object_label' );

if ( ! function_exists( 'listar_change_post_object_label' ) ) :
	/**
	 * Change WP Job Manager labels.
	 *
	 * @since 1.0
	 */
	function listar_change_post_object_label() {

		global $wp_post_types;

		if ( isset( $wp_post_types['job_listing']->labels ) ) {
			$global_obj                 = &$wp_post_types['job_listing'];
			$labels                     = &$wp_post_types['job_listing']->labels;
			$labels->name               = esc_html__( 'Listings', 'listar' );
			$labels->singular_name      = esc_html__( 'Listing', 'listar' );
			$labels->add_new            = esc_html__( 'Add Listing', 'listar' );
			$labels->add_new_item       = esc_html__( 'Add Listing', 'listar' );
			$labels->edit_item          = esc_html__( 'Edit Listings', 'listar' );
			$labels->new_item           = esc_html__( 'Listing', 'listar' );
			$labels->view_item          = esc_html__( 'View Listing', 'listar' );
			$labels->search_items       = esc_html__( 'Search Listings', 'listar' );
			$labels->not_found          = esc_html__( 'No Listings found', 'listar' );
			$labels->not_found_in_trash = esc_html__( 'No Listings found in Trash', 'listar' );
			$labels->all_items          = esc_html__( 'All Listings', 'listar' );
			$labels->archives           = esc_html__( 'All Listings', 'listar' );
			$labels->menu_name          = esc_html__( 'Listings', 'listar' );
			$labels->view               = esc_html__( 'View Listing', 'listar' );
			$labels->name_admin_bar     = esc_html__( 'Listing', 'listar' );
			$global_obj->label          = esc_html__( 'Listings', 'listar' );
		}
	}

endif;

add_filter( 'submit_job_form_fields', 'listar_modify_frontend_jobmanager_fields', 2000 );

if ( ! function_exists( 'listar_modify_frontend_jobmanager_fields' ) ) :
	/**
	 * Modifying WP Job Manager fields - Front end.
	 *
	 * @since 1.0
	 * @param (array) $fields WP Job Manager fields.
	 * @return (array)
	 */
	function listar_modify_frontend_jobmanager_fields( $fields ) {
		$disabled_package_options                            = listar_get_package_options_disabled();
		$required_package_options                            = listar_get_package_options_required();
		$fields['job']['job_title']['label']                 = esc_html__( 'Listing Title', 'listar' );
		$fields['job']['job_title']['placeholder']           = esc_html__( 'e.g. Johnson Bakery and Coffee', 'listar' );
		$fields['job']['job_location']['placeholder']        = esc_html__( 'e.g. 53 Broadway', 'listar' );
		$fields['job']['job_location']['description']        = esc_html__( 'Needed to generate a map marker', 'listar' ) . ' - ' . esc_html__( 'Leave this blank if the location is not important', 'listar' );
		$fields['job']['job_category']['label']              = esc_html__( 'Listing Category', 'listar' );
		$fields['job']['job_description']['required']        = false;
		$fields['company']['company_twitter']['label']       = 'Twitter';
		$fields['company']['company_twitter']['placeholder'] = esc_html__( 'Username or URL', 'listar' );
		$fields['company']['company_twitter']['priority']    = 8;
		$fields['company']['company_logo']['label']          = esc_html__( 'Main Image', 'listar' );
		$fields['company']['company_logo']['multiple']       = false;
		$fields['company']['company_logo']['priority']       = 0;
		$fields['company']['company_logo']['required']       = false;
		$fields['company']['company_website']['priority']    = 5;
		$fields['company']['company_video']['label']         = esc_html__( 'Youtube Video', 'listar' );
		$fields['company']['company_video']['priority']      = 2.999;
		$fields['company']['company_video']['placeholder']   = esc_html__( 'e.g. https://youtu.be/MWqbPJfCdA8', 'listar' );
		$fields['company']['company_video']['type']          = 'text';

		if ( class_exists( 'Astoundify_Job_Manager_Regions' ) ) {
			$fields['job']['job_region']['label'] = esc_html__( 'Listing Region', 'listar' );
			$multiple_regions = (int) get_option( 'listar_allow_multiple_regions_frontend' );
			
			if ( 1 === $multiple_regions) {
				$fields['job']['job_region']['type'] = 'term-multiselect';
			}
		}

		$listar_location_disable = (int) get_option( 'listar_location_disable' );
		
		if ( 1 === $listar_location_disable ) {
			unset( $fields['job']['job_location'] );
		}
		
		$listar_social_networks_disable = (int) get_option( 'listar_social_networks_disable' );

		if ( 1 === $listar_social_networks_disable ) {
			unset( $fields['company']['company_twitter'] );
		}
		
		$listar_website_disable = (int) get_option( 'listar_website_disable' );

		if ( 1 === $listar_website_disable ) {
			unset( $fields['company']['company_website'] );
		}

		unset(
			$fields['job']['application'],
			$fields['company']['company_name'],
			$fields['company']['company_tagline']
		);
		
		if ( ! empty( $disabled_package_options ) ) {
			
			if ( isset( $disabled_package_options['listar_disable_private_message'] ) ) :
				if ( isset( $fields['job']['job_disable_privatemessage'] ) ) :
					unset( $fields['job']['job_disable_privatemessage'] );
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_disable_job_listing_subtitle'] ) ) :
				if ( isset( $fields['job']['job_listing_subtitle'] ) ) :
					unset( $fields['job']['job_listing_subtitle'] );
				endif;
			else :
				if ( isset( $fields['job']['job_listing_subtitle'] ) ) :
					$required = isset( $required_package_options['listar_disable_job_listing_subtitle'] ) ? true : false;
					$fields['job']['job_listing_subtitle']['required'] = $required;
				endif;
			endif;

			if ( isset( $disabled_package_options['listar_location_disable'] ) ) :
				if ( isset( $fields['job']['job_location'] ) ) :
					unset( $fields['job']['job_location'] );
				endif;

				if ( isset( $fields['job']['job_customlatitude'] ) ) :
					unset( $fields['job']['job_customlatitude'] );
				endif;

				if ( isset( $fields['job']['job_customlongitude'] ) ) :
					unset( $fields['job']['job_customlongitude'] );
				endif;

				if ( isset( $fields['job']['job_locationselector'] ) ) :
					unset( $fields['job']['job_locationselector'] );
				endif;

				if ( isset( $fields['job']['job_customlocation'] ) ) :
					unset( $fields['job']['job_customlocation'] );
				endif;
			else :
				if ( isset( $fields['job']['job_location'] ) ) :
					$required = isset( $required_package_options['listar_location_disable'] ) ? true : false;
					$fields['job']['job_location']['required'] = $required;
					
					if ( $required ) :
						$fields['job']['job_location']['description'] = esc_html__( 'Needed to generate a map marker', 'listar' );
					endif;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_disable_map'] ) ) :
				if ( isset( $fields['job']['job_customlatitude'] ) ) :
					unset( $fields['job']['job_customlatitude'] );
				endif;

				if ( isset( $fields['job']['job_customlongitude'] ) ) :
					unset( $fields['job']['job_customlongitude'] );
				endif;

				if ( isset( $fields['job']['job_locationselector'] ) ) :
					unset( $fields['job']['job_locationselector'] );
				endif;

				if ( isset( $fields['job']['job_customlocation'] ) ) :
					unset( $fields['job']['job_customlocation'] );
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_disable_job_tagline'] ) ) :
				if ( isset( $fields['job']['job_tagline'] ) ) :
					unset( $fields['job']['job_tagline'] );
				endif;
			else :
				if ( isset( $fields['job']['job_tagline'] ) ) :
					$required = isset( $required_package_options['listar_disable_job_tagline'] ) ? true : false;
					$fields['job']['job_tagline']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_disable_job_listing_region'] ) ) :
				if ( isset( $fields['job']['job_region'] ) ) :
					unset( $fields['job']['job_region'] );
					
					if ( isset( $fields['company']['company_featured_listing_region'] ) ) :
						unset( $fields['company']['company_featured_listing_region'] );
					endif;
				endif;
			else :
				if ( isset( $fields['job']['job_region'] ) ) :
					$required = isset( $required_package_options['listar_disable_job_listing_region'] ) ? true : false;
					$fields['job']['job_region']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_disable_job_listing_category'] ) ) :
				if ( isset( $fields['job']['job_category'] ) ) :
					unset( $fields['job']['job_category'] );
					
					if ( isset( $fields['company']['company_featured_listing_category'] ) ) :
						unset( $fields['company']['company_featured_listing_category'] );
					endif;
				endif;
			else :
				if ( isset( $fields['job']['job_category'] ) ) :
					$required = isset( $required_package_options['listar_disable_job_listing_category'] ) ? true : false;
					$fields['job']['job_category']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_disable_job_listing_amenity'] ) ) :
				if ( isset( $fields['job']['job_amenities'] ) ) :
					unset( $fields['job']['job_amenities'] );
				endif;
			else :
				if ( isset( $fields['job']['job_amenities'] ) ) :
					$required = isset( $required_package_options['listar_disable_job_listing_amenity'] ) ? true : false;
					$fields['job']['job_amenities']['required'] = $required;
				endif;
			endif;

			if ( isset( $disabled_package_options['listar_disable_job_searchtags'] ) ) :
				if ( isset( $fields['job']['job_searchtags'] ) ) :
					unset( $fields['job']['job_searchtags'] );
				endif;
			else :
				if ( isset( $fields['job']['job_searchtags'] ) ) :
					$required = isset( $required_package_options['listar_disable_job_searchtags'] ) ? true : false;
					$fields['job']['job_searchtags']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_operating_hours_disable'] ) ) :
				if ( isset( $fields['job']['job_business_use_hours'] ) ) :
					unset( $fields['job']['job_business_use_hours'] );
				endif;

				if ( isset( $fields['job']['job_business_use_hours'] ) ) :
					unset( $fields['job']['job_business_use_hours'] );
				endif;

				if ( isset( $fields['job']['job_business_hours_monday'] ) ) :
					unset( $fields['job']['job_business_hours_monday'] );
				endif;

				if ( isset( $fields['job']['job_business_hours_tuesday'] ) ) :
					unset( $fields['job']['job_business_hours_tuesday'] );
				endif;

				if ( isset( $fields['job']['job_business_hours_wednesday'] ) ) :
					unset( $fields['job']['job_business_hours_wednesday'] );
				endif;

				if ( isset( $fields['job']['job_business_hours_thursday'] ) ) :
					unset( $fields['job']['job_business_hours_thursday'] );
				endif;

				if ( isset( $fields['job']['job_business_hours_friday'] ) ) :
					unset( $fields['job']['job_business_hours_friday'] );
				endif;

				if ( isset( $fields['job']['job_business_hours_saturday'] ) ) :
					unset( $fields['job']['job_business_hours_saturday'] );
				endif;

				if ( isset( $fields['job']['job_business_hours_sunday'] ) ) :
					unset( $fields['job']['job_business_hours_sunday'] );
				endif;
			else :
				if ( isset( $fields['job']['job_business_use_hours'] ) ) :
					$required = isset( $required_package_options['listar_operating_hours_disable'] ) ? true : false;
					$fields['job']['job_business_use_hours']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_menu_catalog_disable'] ) ) :
				if ( isset( $fields['job']['job_business_use_catalog'] ) ) :
					unset( $fields['job']['job_business_use_catalog'] );
				endif;
				
				if ( isset( $fields['job']['job_business_catalog_label'] ) ) :
					unset( $fields['job']['job_business_catalog_label'] );
				endif;
				
				if ( isset( $fields['job']['job_business_catalog_custom_label'] ) ) :
					unset( $fields['job']['job_business_catalog_custom_label'] );
				endif;
				
				if ( isset( $fields['job']['job_business_use_price_list'] ) ) :
					unset( $fields['job']['job_business_use_price_list'] );
				endif;
				
				if ( isset( $fields['job']['job_business_price_list_content'] ) ) :
					unset( $fields['job']['job_business_price_list_content'] );
				endif;
				
				if ( isset( $fields['job']['job_business_use_catalog_documents'] ) ) :
					unset( $fields['job']['job_business_use_catalog_documents'] );
				endif;
				
				if ( isset( $fields['job']['job_business_use_catalog_external'] ) ) :
					unset( $fields['job']['job_business_use_catalog_external'] );
				endif;
				
				for ( $i = 1; $i < 7; $i++ ) {
					if ( isset( $fields['job']['job_business_document_' . $i . '_title'] ) ) :
						unset( $fields['job']['job_business_document_' . $i . '_title'] );
					endif;
					
					if ( isset( $fields['job']['job_business_document_' . $i . '_file'] ) ) :
						unset( $fields['job']['job_business_document_' . $i . '_file'] );
					endif;
					
					if ( isset( $fields['job']['job_business_document_' . $i . '_title_external'] ) ) :
						unset( $fields['job']['job_business_document_' . $i . '_title_external'] );
					endif;
					
					if ( isset( $fields['job']['job_business_document_' . $i . '_file_external'] ) ) :
						unset( $fields['job']['job_business_document_' . $i . '_file_external'] );
					endif;
				}
			else :
				if ( isset( $fields['job']['job_business_use_catalog'] ) ) :
					$required = isset( $required_package_options['listar_menu_catalog_disable'] ) ? true : false;
					$fields['job']['job_business_use_catalog']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_booking_service_disable'] ) ) :
				if ( isset( $fields['job']['job_business_use_booking'] ) ) :
					unset( $fields['job']['job_business_use_booking'] );
				endif;

				if ( isset( $fields['job']['job_business_booking_label'] ) ) :
					unset( $fields['job']['job_business_booking_label'] );
				endif;

				if ( isset( $fields['job']['job_business_booking_custom_label'] ) ) :
					unset( $fields['job']['job_business_booking_custom_label'] );
				endif;

				if ( isset( $fields['job']['job_business_bookings_third_party_service'] ) ) :
					unset( $fields['job']['job_business_bookings_third_party_service'] );
				endif;
			else :
				if ( isset( $fields['job']['job_business_use_booking'] ) ) :
					$required = isset( $required_package_options['listar_booking_service_disable'] ) ? true : false;
					$fields['job']['job_business_use_booking']['required'] = $required;
					
				endif;

				if ( isset( $fields['job']['job_business_bookings_third_party_service'] ) ) :
					$required = isset( $required_package_options['listar_booking_service_disable'] ) ? true : false;
					$fields['job']['job_business_bookings_third_party_service']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_price_range_disable'] ) ) :
				if ( isset( $fields['job']['job_pricerange'] ) ) :
					unset( $fields['job']['job_pricerange'] );
				endif;
			else :
				if ( isset( $fields['job']['job_pricerange'] ) ) :
					$required = isset( $required_package_options['listar_price_range_disable'] ) ? true : false;
					$fields['job']['job_pricerange']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_popular_price_disable'] ) ) :
				if ( isset( $fields['job']['job_priceaverage'] ) ) :
					unset( $fields['job']['job_priceaverage'] );
				endif;
			else :
				if ( isset( $fields['job']['job_priceaverage'] ) ) :
					$required = isset( $required_package_options['listar_popular_price_disable'] ) ? true : false;
					$fields['job']['job_priceaverage']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_main_image_disable'] ) ) :
				if ( isset( $fields['company']['company_logo'] ) ) :
					unset( $fields['company']['company_logo'] );
				endif;
			else :
				if ( isset( $fields['company']['company_logo'] ) ) :
					$required = isset( $required_package_options['listar_main_image_disable'] ) ? true : false;
					$fields['company']['company_logo']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_logo_disable'] ) ) :
				if ( isset( $fields['company']['company_logotype'] ) ) :
					unset( $fields['company']['company_logotype'] );
				endif;
			else :
				if ( isset( $fields['company']['company_logotype'] ) ) :
					$required = isset( $required_package_options['listar_logo_disable'] ) ? true : false;
					$fields['company']['company_logotype']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_disable_gallery_images'] ) ) :
				if ( isset( $fields['company']['gallery_images'] ) ) :
					unset( $fields['company']['gallery_images'] );
				endif;
			else :
				if ( isset( $fields['company']['gallery_images'] ) ) :
					$required = isset( $required_package_options['listar_disable_gallery_images'] ) ? true : false;
					$fields['company']['gallery_images']['required'] = $required;
				endif;
			endif;

			if ( isset( $disabled_package_options['listar_disable_company_youtube'] ) ) :
				if ( isset( $fields['company']['company_video'] ) ) :
					unset( $fields['company']['company_video'] );
				endif;
			else :
				if ( isset( $fields['company']['company_video'] ) ) :
					$required = isset( $required_package_options['listar_disable_company_youtube'] ) ? true : false;
					$fields['company']['company_video']['required'] = $required;
				endif;
			endif;

			if ( isset( $disabled_package_options['listar_phone_disable'] ) ) :
				if ( isset( $fields['company']['company_phone'] ) ) :
					unset( $fields['company']['company_phone'] );
				endif;
			else :
				if ( isset( $fields['company']['company_phone'] ) ) :
					$required = isset( $required_package_options['listar_phone_disable'] ) ? true : false;
					$fields['company']['company_phone']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_mobile_disable'] ) ) :
				if ( isset( $fields['company']['company_mobile'] ) ) :
					unset( $fields['company']['company_mobile'] );
				endif;
			else :
				if ( isset( $fields['company']['company_mobile'] ) ) :
					$required = isset( $required_package_options['listar_mobile_disable'] ) ? true : false;
					$fields['company']['company_mobile']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_whatsapp_disable'] ) ) :
				if ( isset( $fields['company']['company_whatsapp'] ) ) :
					unset( $fields['company']['company_whatsapp'] );
				endif;
			else :
				if ( isset( $fields['company']['company_whatsapp'] ) ) :
					$required = isset( $required_package_options['listar_whatsapp_disable'] ) ? true : false;
					$fields['company']['company_whatsapp']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_fax_disable'] ) ) :
				if ( isset( $fields['company']['company_fax'] ) ) :
					unset( $fields['company']['company_fax'] );
				endif;
			else :
				if ( isset( $fields['company']['company_fax'] ) ) :
					$required = isset( $required_package_options['listar_fax_disable'] ) ? true : false;
					$fields['company']['company_fax']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_website_disable'] ) ) :
				if ( isset( $fields['company']['company_website'] ) ) :
					unset( $fields['company']['company_website'] );
				endif;
			else :
				if ( isset( $fields['company']['company_website'] ) ) :
					$required = isset( $required_package_options['listar_website_disable'] ) ? true : false;
					$fields['company']['company_website']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_social_networks_disable'] ) ) :
				if ( isset( $fields['company']['company_use_social_networks'] ) ) :
					unset( $fields['company']['company_use_social_networks'] );
				endif;

				if ( isset( $fields['company']['company_twitter'] ) ) :
					unset( $fields['company']['company_twitter'] );
				endif;

				if ( isset( $fields['company']['company_facebook'] ) ) :
					unset( $fields['company']['company_facebook'] );
				endif;

				if ( isset( $fields['company']['company_instagram'] ) ) :
					unset( $fields['company']['company_instagram'] );
				endif;

				if ( isset( $fields['company']['company_linkedin'] ) ) :
					unset( $fields['company']['company_linkedin'] );
				endif;

				if ( isset( $fields['company']['company_pinterest'] ) ) :
					unset( $fields['company']['company_pinterest'] );
				endif;

				if ( isset( $fields['company']['company_youtube'] ) ) :
					unset( $fields['company']['company_youtube'] );
				endif;

				if ( isset( $fields['company']['company_googleplus'] ) ) :
					unset( $fields['company']['company_googleplus'] );
				endif;

				if ( isset( $fields['company']['company_vimeo'] ) ) :
					unset( $fields['company']['company_vimeo'] );
				endif;

				if ( isset( $fields['company']['company_vk'] ) ) :
					unset( $fields['company']['company_vk'] );
				endif;

				if ( isset( $fields['company']['company_foursquare'] ) ) :
					unset( $fields['company']['company_foursquare'] );
				endif;

				if ( isset( $fields['company']['company_tripadvisor'] ) ) :
					unset( $fields['company']['company_tripadvisor'] );
				endif;
			else :
				if ( isset( $fields['company']['company_use_social_networks'] ) ) :
					$required = isset( $required_package_options['listar_social_networks_disable'] ) ? true : false;
					$fields['company']['company_use_social_networks']['required'] = $required;
				endif;
			endif;
			
			if ( isset( $disabled_package_options['listar_external_references_disable'] ) ) :
				if ( isset( $fields['company']['company_use_external_links'] ) ) :
					unset( $fields['company']['company_use_external_links'] );
				endif;
				
				for ( $i = 1; $i < 13; $i++ ) {
					if ( isset( $fields['company']['company_external_link_' . $i ] ) ) :
						unset( $fields['company']['company_external_link_' . $i ] );
					endif;
				}
			else :
				if ( isset( $fields['company']['company_use_external_links'] ) ) :
					$required = isset( $required_package_options['listar_external_references_disable'] ) ? true : false;
					$fields['company']['company_use_external_links']['required'] = $required;
				endif;
			endif;
		}

		return $fields;
	}

endif;

add_filter( 'job_manager_job_listing_data_fields', 'listar_modify_backend_jobmanager_fields', 20 );

if ( ! function_exists( 'listar_modify_backend_jobmanager_fields' ) ) :
	/**
	 * Modifying WP Job Manager fields - Back end.
	 *
	 * @since 1.0
	 * @param (array) $fields WP Job Manager fields.
	 * @return (array)
	 */
	function listar_modify_backend_jobmanager_fields( $fields ) {

		$fields['_company_twitter']['label']       = 'Twitter';
		$fields['_company_website']['label']       = esc_html__( 'Website', 'listar' );
		$fields['_company_website']['placeholder'] = 'http://';
		$fields['_company_tagline']['label']       = esc_html__( 'Tagline', 'listar' );
		$fields['_company_twitter']['placeholder'] = esc_html__( 'Username or URL', 'listar' );
		$fields['_company_twitter']['priority']    = 5.15;
		$fields['_job_location']['placeholder']    = esc_html__( 'e.g. 53 Broadway', 'listar' );
		$fields['_job_location']['description']    = esc_html__( 'Needed to generate a map marker', 'listar' ) . ' - ' . esc_html__( 'Leave this blank if the location is not important', 'listar' );
		$fields['_job_location']['type']           = 'textarea';
		$fields['_company_video']['label']         = esc_html__( 'Youtube Video', 'listar' );
		$fields['_company_video']['type']          = 'text';
		$fields['_company_video']['placeholder']   = esc_html__( 'e.g. https://youtu.be/MWqbPJfCdA8', 'listar' );
		$listar_location_disable                   = (int) get_option( 'listar_location_disable' );
		$listar_website_disable                    = (int) get_option( 'listar_website_disable' );
		$listar_social_networks_disable            = (int) get_option( 'listar_social_networks_disable' );

		if ( 1 === $listar_social_networks_disable ) {
			unset( $fields['_company_twitter'] );
		}
		
		if ( 1 === $listar_location_disable ) {
			unset( $fields['_job_location'] );
		}

		if ( 1 === $listar_website_disable ) {
			unset( $fields['_company_website'] );
		}
		
		unset(
			$fields['_application'],
			$fields['_company_name'],
			$fields['_company_tagline'],
			$fields['_filled']
		);

		return $fields;
	}

endif;


add_filter( 'submit_job_steps', 'listar_custom_submit_listing_steps', 20 );

if ( ! function_exists( 'listar_custom_submit_listing_steps' ) ) :
	/**
	 * Remove the preview step from WP Job Manager.
	 *
	 * @since 1.0
	 * @param (array) $steps Steps from WP Job Manager.
	 * @return (array)
	 */
	function listar_custom_submit_listing_steps( $steps ) {

		unset( $steps['preview'] );

		return $steps;
	}

endif;


add_filter( 'submit_job_form_submit_button_text', 'listar_change_submit_listing_button', 20 );

if ( ! function_exists( 'listar_change_submit_listing_button' ) ) :
	/**
	 * Change submit button text of WP Job Manager submission form.
	 *
	 * @since 1.0
	 */
	function listar_change_submit_listing_button() {

		return esc_html__( 'Submit Listing', 'listar' );
	}

endif;


add_action( 'job_manager_job_submitted', 'listar_submit_listing' );

if ( ! function_exists( 'listar_submit_listing' ) ) :
	/**
	 * Since we removed the preview step from WP Job Manager, we need to programatically publish jobs.
	 *
	 * @since 1.0
	 * @param (integer) $job_id ID of the listing.
	 */
	function listar_submit_listing( $job_id ) {

		$job = get_post( $job_id );

		if ( in_array( $job->post_status, array( 'preview', 'expired' ), true ) ) {

			/* Reset expirey */
			delete_post_meta( $job->ID, '_job_expires' );

			/* Update job listing */
			$update_job                  = array();
			$update_job['ID']            = $job->ID;
			$update_job['post_status']   = get_option( 'job_manager_submission_requires_approval' ) ? 'pending' : 'publish';
			$update_job['post_date']     = current_time( 'mysql' );
			$update_job['post_date_gmt'] = current_time( 'mysql', 1 );
			wp_update_post( $update_job );
		}
	}

endif;


add_filter( 'comment_form_defaults', 'listar_change_reply_text', 20 );

if ( ! function_exists( 'listar_change_reply_text' ) ) :
	/**
	 * Change text to leave a reply on review form of listings page.
	 *
	 * @since 1.0
	 * @param (array) $arg Comment form args.
	 * @return (array)
	 */
	function listar_change_reply_text( $arg ) {

		global $post;

		if ( 'job_listing' === $post->post_type && ( listar_third_party_reviews_active() || listar_built_in_reviews_active() ) ) {
			$arg['title_reply'] = esc_html__( 'Leave your Review', 'listar' );
		}

		return $arg;
	}

endif;


add_filter( 'register_post_type_job_listing', 'listar_change_job_listing_slug', 20 );

if ( ! function_exists( 'listar_change_job_listing_slug' ) ) :
	/**
	 * Set listing slug.
	 *
	 * @since 1.0
	 * @param (array) $args WP Job Manager args.
	 * @return (array)
	 */
	function listar_change_job_listing_slug( $args ) {

		$args['rewrite']['slug'] = esc_html_x( 'listing', 'Job permalink - resave permalinks after changing this', 'listar' );

		return $args;
	}

endif;


add_filter( 'manage_job_listing_posts_columns', 'listar_set_job_listing_columns', 20 );

if ( ! function_exists( 'listar_set_job_listing_columns' ) ) :
	/**
	 * Remove columns exposed by WP Job Manager on 'edit listings' screen ( WordPress admin, menu Listings / All Listings ).
	 *
	 * @since 1.0
	 * @param (array) $columns The columns of listing fields/properties.
	 * @return (array)
	 */
	function listar_set_job_listing_columns( $columns ) {

		if ( isset( $columns['taxonomy-job_listing_amenity'] ) ) {
			unset( $columns['taxonomy-job_listing_amenity'] );
		}

		return $columns;
	}

endif;

add_filter( 'job_manager_chosen_enabled', 'listar_disable_chosen', 20 );

if ( ! function_exists( 'listar_disable_chosen' ) ) :
	/**
	 * Disable Chosen from WP Job Manager, we will use Select2 instead.
	 *
	 * @since 1.0
	 * @return (boolean)
	 */
	function listar_disable_chosen() {
		return false;
	}

endif;

// Make comments open by default for new jobs
add_filter( 'submit_job_form_save_job_data', 'custom_submit_job_form_save_job_data' );

function custom_submit_job_form_save_job_data( $data ) {
	
	if ( isset( $data['post_title'] ) ) {
		$post = get_page_by_title( $data['post_title'], OBJECT, 'job_listing' );
		
		if ( null !== $post ) {
			$id = isset( $post->ID ) ? $post->ID : 0;
			
			if ( comments_open( $id ) ) {
				$data['comment_status'] = 'open';
			} else {
				$data['comment_status'] = 'closed';
			}
		} else {
			$data['comment_status'] = 'open';
		}		
	} else {
		$data['comment_status'] = 'open';
	}

	return $data;
}
