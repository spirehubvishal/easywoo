<?php
/**
 * My Packages.
 * Shows packages on the account page.
 *
 * @version 2.0.0
 * @since 2.0.0
 *
 * @var array  $packages User Packages.
 * @var string $type     Job Listing/Resume Listing. "job_listing" / "resume".
 *
 * @package Listing Payments
 * @category Template
 * @author Astoundify
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Title.
$title = __( 'My Packages', 'listar' );

if ( 'job_listing' === $type ) {
	$title = __( 'My Listing Packages', 'listar' );
} elseif ( 'resume' === $type ) {
	$title = __( 'My Resume Packages', 'listar' );
}

$title = apply_filters( 'woocommerce_my_account_astoundify_wpjmlp_packages_title', $title, $type );
?>

<h2><?php echo esc_html( $title ); ?></h2>

<table class="shop_table my_account_job_packages my_account_astoundify_wpjmlp_packages">
	<thead>
		<tr>
			<th scope="col"><?php esc_html_e( 'Package Name', 'listar' ); ?></th>
			<th scope="col"><?php esc_html_e( 'Remaining', 'listar' ); ?></th>
			<?php if ( 'job_listing' === $type ) : ?>
				<th scope="col"><?php esc_html_e( 'Listing Duration', 'listar' ); ?></th>
			<?php endif; ?>
			<th scope="col"><?php esc_html_e( 'Featured?', 'listar' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $packages as $package ) :
			$package = astoundify_wpjmlp_get_package( $package );
			?>
			<tr>
				<td><?php echo esc_html( $package->get_title() ); ?></td>
				<td><?php echo esc_html( $package->get_limit() ? absint( $package->get_limit() - $package->get_count() ) : __( 'Unlimited', 'listar' ) ); ?></td>
				<?php if ( 'job_listing' === $type ) : ?>
					<td><?php
						// Translators: %d Package duration in days.
						echo esc_html( $package->get_duration() ? sprintf( _n( '%d day', '%d days', $package->get_duration(), 'listar' ), $package->get_duration() ) : '-' );
					?></td>
				<?php endif; ?>
				<td><?php echo esc_html( $package->is_listing_featured() ? __( 'Yes', 'listar' ) : __( 'No', 'listar' ) ); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
