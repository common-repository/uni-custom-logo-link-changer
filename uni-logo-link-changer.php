<?php
/**
 * A WordPress plugin to change the link of the custom logo.
 *
 * @package uni custom logo link changer
 * @author Pawan Kumar
 * @license GPL-2.0+
 *
 *            @wordpress-plugin
 *            Plugin Name: Uni Custom Logo Link Changer
 *            Description: A simple plugin to customize the logo link.
 *            Version: 1.0
 *            Author: Pawan Kumar
 *            Text Domain: uni-custom-logo-link-changer
 *            Contributors: Pawan Kumar
 *            License: GPL-2.0+
 *            License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
function uni_custom_logo_url ( $uni_logo_html ) {
 
	$uni_custom_logo_id = get_theme_mod( 'custom_logo' );
 
	// Make sure to replace your updated site URL
	$uni_new_url = stripslashes_deep ( esc_attr ( get_option ('uni-logo-url') ) );
 
	$uni_logo_html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
		esc_url( $uni_new_url ),
		wp_get_attachment_image( $uni_custom_logo_id, 'full', false, array(
			'class'    => 'custom-logo',
		) )
	);
	return $uni_logo_html;
}
 
// get_custom_logo: Returns a custom logo, linked to home unless the theme supports removing the link on the home page.
add_filter( 'get_custom_logo',  'uni_custom_logo_url' );



function uni_add_menu() {
	add_submenu_page ( "options-general.php", "Logo Link Changer", "Logo Link Changer", "manage_options", "uni-new-logo-url", "uni_logo_changer_page" );
}
add_action ( "admin_menu", "uni_add_menu" );



function uni_logo_changer_page() {
	?>
<div class="wrap">
	<h1>
		Simple Logo Link Changer Plugin
	</h1>
 
	<form method="post" action="options.php">
            <?php
	settings_fields ( "uni_logo_config" );
	do_settings_sections ( "uni-logo-config" );
	submit_button ();
	?>
         </form>
</div>
 
<?php
}



function uni_logo_settings() {
	add_settings_section ( "uni_logo_config", "", null, "uni-logo-config" );
	add_settings_field ( "uni-logo-url", "New URL for the logo", "uni_logo_changer_options", "uni-logo-config", "uni_logo_config" );
	register_setting ( "uni_logo_config", "uni-logo-url" );
}
add_action ( "admin_init", "uni_logo_settings" );


function uni_logo_changer_options() {
	?>

	<input type="text" name="uni-logo-url"
		value="<?php
	echo stripslashes_deep ( esc_attr ( get_option ('uni-logo-url') ) );
	?>" />

<?php
}