<?php
/*
 * Template Name: My Panel
 *
 * The customer-facing pharmacy dashboard.
 *
 * @package Writr
 */

$dads_user = wp_get_current_user();
$dads_name = $dads_user->exists() ? $dads_user->display_name : __( 'James', 'writr' );
$dads_first_name = trim( strtok( $dads_name, ' ' ) );
$dads_initials = '';
foreach ( preg_split( '/\s+/', trim( $dads_name ) ) as $dads_name_part ) {
	$dads_initials .= strtoupper( substr( $dads_name_part, 0, 1 ) );
}
$dads_initials = substr( $dads_initials, 0, 2 );

$dads_icon = function ( $name, $class = '' ) {
	$icons = array(
		'grid' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
		'prescription' => '<path d="M6 3h9a3 3 0 0 1 0 6H6V3Z"/><path d="M6 9h7l5 12M6 3v18M13 14l6-5"/>',
		'box' => '<path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="m3 8 9 5 9-5v9l-9 5-9-5V8Z"/><path d="M12 13v9"/>',
		'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
		'help' => '<circle cx="12" cy="12" r="9"/><path d="M9.7 9a2.5 2.5 0 1 1 3.4 2.33c-.72.3-1.1.83-1.1 1.67M12 17h.01"/>',
		'logout' => '<path d="M10 17l5-5-5-5M15 12H3"/><path d="M14 3h5a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5"/>',
		'bell' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>',
		'plus' => '<path d="M12 5v14M5 12h14"/>',
		'upload' => '<path d="M12 16V4M7 9l5-5 5 5M5 20h14"/>',
		'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'check' => '<circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16 9"/>',
		'chevron' => '<path d="m9 18 6-6-6-6"/>',
		'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'close' => '<path d="m6 6 12 12M18 6 6 18"/>',
	);
	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}
	return '<svg class="dads-icon ' . esc_attr( $class ) . '" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $icons[ $name ] . '</svg>';
};
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'dads-dashboard-page' ); ?>>
<div class="dads-dashboard">
	<aside class="dads-sidebar" id="dads-sidebar" aria-label="<?php esc_attr_e( 'Main navigation', 'writr' ); ?>">
		<a class="dads-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Dad’s Pharmacy home', 'writr' ); ?>">
			<span class="dads-brand-mark" aria-hidden="true"><span></span><span></span><span></span><span></span></span>
			<span><strong>dad’s</strong><small>PHARMACY</small></span>
		</a>

		<nav class="dads-nav">
			<p><?php esc_html_e( 'MAIN MENU', 'writr' ); ?></p>
			<a class="is-active" href="#overview"><?php echo $dads_icon( 'grid' ); ?><span><?php esc_html_e( 'Overview', 'writr' ); ?></span></a>
			<a href="#prescriptions"><?php echo $dads_icon( 'prescription' ); ?><span><?php esc_html_e( 'Prescriptions', 'writr' ); ?></span><b>2</b></a>
			<a href="#orders"><?php echo $dads_icon( 'box' ); ?><span><?php esc_html_e( 'Orders', 'writr' ); ?></span></a>
			<a href="#profile"><?php echo $dads_icon( 'user' ); ?><span><?php esc_html_e( 'My Profile', 'writr' ); ?></span></a>
			<p><?php esc_html_e( 'SUPPORT', 'writr' ); ?></p>
			<a href="#help"><?php echo $dads_icon( 'help' ); ?><span><?php esc_html_e( 'Help & Support', 'writr' ); ?></span></a>
		</nav>

		<div class="dads-care-card">
			<div class="dads-care-icon"><?php echo $dads_icon( 'help' ); ?></div>
			<strong><?php esc_html_e( 'Need help?', 'writr' ); ?></strong>
			<span><?php esc_html_e( 'Our pharmacists are here for you.', 'writr' ); ?></span>
			<a href="tel:+18003237427"><?php esc_html_e( 'Talk to a pharmacist', 'writr' ); ?></a>
		</div>

		<a class="dads-logout" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php echo $dads_icon( 'logout' ); ?><span><?php esc_html_e( 'Log out', 'writr' ); ?></span></a>
	</aside>

	<div class="dads-main-shell">
		<header class="dads-topbar">
			<button class="dads-menu-button" type="button" aria-controls="dads-sidebar" aria-expanded="false">
				<span class="dads-menu-open"><?php echo $dads_icon( 'menu' ); ?></span>
				<span class="dads-menu-close"><?php echo $dads_icon( 'close' ); ?></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Toggle navigation', 'writr' ); ?></span>
			</button>
			<div class="dads-topbar-spacer"></div>
			<button class="dads-notification" type="button" aria-label="<?php esc_attr_e( 'View notifications', 'writr' ); ?>"><?php echo $dads_icon( 'bell' ); ?><i></i></button>
			<span class="dads-topbar-rule"></span>
			<div class="dads-user">
				<span class="dads-avatar"><?php echo esc_html( $dads_initials ? $dads_initials : 'JD' ); ?></span>
				<span><strong><?php echo esc_html( $dads_name ); ?></strong><small><?php esc_html_e( 'Patient', 'writr' ); ?></small></span>
			</div>
		</header>

		<main class="dads-content" id="overview">
			<section class="dads-welcome">
				<div>
					<p class="dads-eyebrow"><?php echo esc_html( strtoupper( date_i18n( 'l, F j' ) ) ); ?></p>
					<h1><?php printf( esc_html__( 'Good morning, %s.', 'writr' ), esc_html( $dads_first_name ) ); ?></h1>
					<p><?php esc_html_e( 'Here’s what’s happening with your health today.', 'writr' ); ?></p>
				</div>
				<a class="dads-button" href="#new-prescription"><?php echo $dads_icon( 'plus' ); ?><?php esc_html_e( 'New prescription', 'writr' ); ?></a>
			</section>

			<section class="dads-alert" aria-label="<?php esc_attr_e( 'Prescription reminder', 'writr' ); ?>">
				<div class="dads-alert-icon"><?php echo $dads_icon( 'prescription' ); ?></div>
				<div><span><?php esc_html_e( 'ACTION NEEDED', 'writr' ); ?></span><h2><?php esc_html_e( 'Your prescription is ready for review', 'writr' ); ?></h2><p><?php esc_html_e( 'Lisinopril 10mg · Prescribed by Dr. Patel', 'writr' ); ?></p></div>
				<a href="#review"><?php esc_html_e( 'Review prescription', 'writr' ); ?><?php echo $dads_icon( 'chevron' ); ?></a>
			</section>

			<div class="dads-grid">
				<section class="dads-panel dads-medications" id="prescriptions">
					<header><div><p class="dads-kicker"><?php esc_html_e( 'YOUR HEALTH', 'writr' ); ?></p><h2><?php esc_html_e( 'Active medications', 'writr' ); ?></h2></div><a href="#all-medications"><?php esc_html_e( 'View all', 'writr' ); ?><?php echo $dads_icon( 'chevron' ); ?></a></header>
					<div class="dads-medication-list">
						<article>
							<div class="dads-pill dads-pill-blue"><span></span></div>
							<div><h3>Lisinopril</h3><p>10mg · 1 tablet daily</p><small><?php echo $dads_icon( 'clock' ); ?><?php esc_html_e( 'Next dose at 8:00 PM', 'writr' ); ?></small></div>
							<span class="dads-status dads-status-refill"><?php esc_html_e( 'Refill due', 'writr' ); ?></span>
						</article>
						<article>
							<div class="dads-pill dads-pill-coral"><span></span></div>
							<div><h3>Metformin</h3><p>500mg · 2 tablets daily</p><small><?php echo $dads_icon( 'check' ); ?><?php esc_html_e( 'Taken today', 'writr' ); ?></small></div>
							<span class="dads-status dads-status-good"><?php esc_html_e( '18 days left', 'writr' ); ?></span>
						</article>
						<article>
							<div class="dads-pill dads-pill-yellow"><span></span></div>
							<div><h3>Atorvastatin</h3><p>20mg · 1 tablet nightly</p><small><?php echo $dads_icon( 'clock' ); ?><?php esc_html_e( 'Next dose at 9:00 PM', 'writr' ); ?></small></div>
							<span class="dads-status dads-status-good"><?php esc_html_e( '26 days left', 'writr' ); ?></span>
						</article>
					</div>
				</section>

				<div class="dads-side-stack">
					<section class="dads-panel dads-order" id="orders">
						<p class="dads-kicker"><?php esc_html_e( 'LATEST ORDER', 'writr' ); ?></p>
						<header><h2>#DP-4821</h2><span><?php esc_html_e( 'On the way', 'writr' ); ?></span></header>
						<p><?php esc_html_e( 'Expected delivery', 'writr' ); ?><strong><?php esc_html_e( 'Tomorrow, Oct 5', 'writr' ); ?></strong></p>
						<div class="dads-progress" aria-label="<?php esc_attr_e( 'Order is out for delivery', 'writr' ); ?>"><i></i><i></i><i class="current"></i><i></i><span></span></div>
						<div class="dads-progress-labels"><span><?php esc_html_e( 'Confirmed', 'writr' ); ?></span><span><?php esc_html_e( 'Packed', 'writr' ); ?></span><span><?php esc_html_e( 'On the way', 'writr' ); ?></span><span><?php esc_html_e( 'Delivered', 'writr' ); ?></span></div>
						<a href="#track"><?php esc_html_e( 'Track order', 'writr' ); ?><?php echo $dads_icon( 'chevron' ); ?></a>
					</section>

					<section class="dads-panel dads-quick" id="new-prescription">
						<p class="dads-kicker"><?php esc_html_e( 'QUICK ACTIONS', 'writr' ); ?></p>
						<h2><?php esc_html_e( 'What do you need?', 'writr' ); ?></h2>
						<div><a href="#upload"><?php echo $dads_icon( 'upload' ); ?><span><strong><?php esc_html_e( 'Upload prescription', 'writr' ); ?></strong><small><?php esc_html_e( 'Snap or upload a photo', 'writr' ); ?></small></span><?php echo $dads_icon( 'chevron' ); ?></a><a href="#refill"><?php echo $dads_icon( 'prescription' ); ?><span><strong><?php esc_html_e( 'Request a refill', 'writr' ); ?></strong><small><?php esc_html_e( 'For an active medication', 'writr' ); ?></small></span><?php echo $dads_icon( 'chevron' ); ?></a></div>
					</section>
				</div>
			</div>

			<footer class="dads-page-footer"><span><?php esc_html_e( 'Your health, handled with care.', 'writr' ); ?></span><span><?php esc_html_e( 'Questions?', 'writr' ); ?> <a href="tel:+18003237427">1-800-DAD’S-CARE</a></span></footer>
		</main>
	</div>
	<div class="dads-scrim" aria-hidden="true"></div>
</div>
<?php wp_footer(); ?>
</body>
</html>
