<?php
	$lang_ = isset( $_GET[ "lang" ] ) && !empty( $_GET[ "lang" ] ) ? sanitize_text_field( $_GET[ "lang" ] ) : "en";

	$welcome_handler = get_page_by_path( "welcome" );
	$welcome_translation_id = wpbt_get_translation_id( $welcome_handler->ID, $lang_ );

	$user_id = get_current_user_id();
	$welcome_label = get_field( "welcome_label", $welcome_translation_id );
	$first_name = get_user_meta( $user_id, "first_name", true );
	$logout_label = get_field( "logout_label", $welcome_translation_id );

	$languages = wpbt_get_registered_languages();
	$current_language = new stdClass;
	foreach ( $languages as $language ) {
		if ( $language->code == $lang_ ) {
			$current_language = $language;
			break;
		}
	}
?>
<div id="logged-header" class="logged-header">
	<div class="left-col">
		<h1 class="welcome-message"><?php echo $welcome_label ." ". $first_name; ?></h1>
	</div>
	<div class="right-col">
		<div id="languages">
			<button id="current-language">
				<img src="<?php echo $current_language->icon; ?>" />
			</button>
			<div id="languages-container" class="hidden animated fadeIn">
				<?php
				foreach ( $languages as $language ) {
					?>

					<a href="<?php echo get_permalink( $page_id ); ?>/?lang=<?php echo $language->code; ?>" class="language invisible-anchor">
						<img src="<?php echo $language->icon; ?>" class="Make Million in <?php echo $language->full_name; ?>" />
					</a>

					<?php
				}
				?>
			</div>
		</div>
		<button id="logout"><?php echo $logout_label; ?></button>
	</div>
</div>
