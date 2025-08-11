<?php
require_once( '../../../../wp-load.php' );

$response = '';

if ( isset( $_POST['delete_image'] ) && ! empty( $_POST['delete_image'] ) && is_numeric( $_POST['delete_image'] ) ) {
	wp_delete_attachment( $_POST['delete_image'], true );
}

if ( isset($_FILES['the_file'] ) && ! empty( $_FILES['the_file']['name'] ) && isset( $_POST['type'] ) && ! empty( $_POST['type'] ) && isset( $_POST['action'] ) && 'upload' === $_POST['action'] ) {
	$allowedExts = array( "jpg", "jpeg", "gif", "png", "JPG", "JPEG", "GIF", "PNG" );

	if ( isset( $_POST['extensions_allowed'] ) ) {
		$allowedExts = explode( ' ', $_POST['extensions_allowed'] );
	}

	$temp = explode( ".", $_FILES["the_file"]["name"] );
	$extension = end($temp);

	if ( in_array( $extension, $allowedExts ) ) {
		if ( 'all' === $_POST['type'] ) {
			if ( ( $_FILES["the_file"]["error"] > 0 ) && ( $_FILES['the_file']['size'] <= 3145728 ) ) {
				$response = array(
					"status" => 'error',
					"message" => 'ERROR Return Code: '. $_FILES["the_file"]["error"],
				);
			} else {
				$uploadedfile = $_FILES['the_file'];
				$upload_name = $_FILES['the_file']['name'];
				$uploads = wp_upload_dir();
				$filepath = $uploads['path']."/$upload_name";

				if ( ! function_exists( 'wp_handle_upload' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
				}

				require_once( ABSPATH . 'wp-admin/includes/image.php' );

				$upload_overrides = array( 'test_form' => false );
				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

				if ( $movefile && ! isset( $movefile['error'] )  ) {
					$file = $movefile['file'];
					$url = $movefile['url'];
					$type = $movefile['type'];

					$attachment = array(
						'post_mime_type' => $type,
						'post_title' => $upload_name,
						'post_status' => 'inherit'
					);

					$attach_id=wp_insert_attachment( $attachment, $file, 0);
					$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
					wp_update_attachment_metadata( $attach_id, $attach_data );

					$response = array(
						"status" => 'success',
						"url" => $url,
						"id" => $attach_id,
						"message" => '',
					);
				} else {
					$response = array(
						"status" => 'error',
						"message" => esc_html__( 'Something went wrong, most likely file is too large for upload.', 'listar' ),
					);
				}
			}
		} else {
			$response = array(
				"status" => 'error',
				"message" => esc_html__( 'This type of file is not allowed.', 'listar' ),
			);
		}
	} else {
		$response = array(
			"status" => 'error',
			"message" => esc_html__( 'This type of file is not allowed.', 'listar' ),
		);
	}
} elseif ( isset( $_POST['action'] ) && 'delete' === $_POST['action'] ) {
} else {
	$response = array(
		"status" => 'error',
		"message" => esc_html__( 'Something went wrong, most likely file is too large for upload.', 'listar' ),
	);
}

print json_encode( $response );
exit;