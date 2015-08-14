<?php

/**
 * @link              http://docs.evine.co/category/wordpress/plugins/
 * @since             1.0.0
 * @package           Js_Redirect_Lite
 *
 * @wordpress-plugin
 * Plugin Name:       JS Redirect Lite
 * Plugin URI:        js-redirect-lite
 * Description:       Redirect new visitors (cookie based) to a specific URL using JavaScript.
 * Version:           1.0.0
 * Author:            Werner Smit
 * Author URI:        http://docs.evine.co/category/wordpress/plugins/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       js-redirect
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function run_js_redirect_lite() {
		global $js_redirect_url;

		// Change the value below.
		$js_redirect_url = site_url('test1');

		// include cookie.min.js JS
		wp_enqueue_script( 'js-redirect-lite', plugin_dir_url( __FILE__ ) . 'js/cookie.min.js', array( 'jquery' ), '0.0.1', false );

		add_action( 'wp_head', 'ck_cookie_check' );
}

/*
 Don't Edit below this line.
*/

run_js_redirect_lite();


function ck_cookie_check() {
	global $js_redirect_url;

?>
<script>
		jQuery(document).ready(function() {

		// check for cookie
		js_redirect_flag = cookie.get( 'js_redirect_flag' );

<?php
		if (isset($_GET['js_redirect_reset'])) {
?>
			cookie.set( 'js_redirect_flag' , '1', {
					expires: -1,
					path: "/",
					secure: false
			});

<?php
		} else {
?>
// check if it's the homepage. Assuming the homepage is the root "/"
if (window.location.pathname.substring(1) == "") {

	// set cookie.
	if (typeof js_redirect_flag == 'undefined') {
			// set cookie
			// expires = number of days.
			cookie.set( 'js_redirect_flag' , '1', {
					expires: 90,
					path: "/",
					secure: false
			});

			// redirect
			window.location.href = '<?php echo $js_redirect_url; ?>';

		}

	} // homepage check.

<?php
		}
?>

		});

</script>
<?php
}
