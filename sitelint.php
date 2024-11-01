<?php
/**
 *
 * @package   Spam Prevention for Contact Form 7 and Comments
 * @author    SiteLint <support@sitelint.com>
 * @license   GPL-2.0+
 * @link      https://www.sitelint.com
 * @copyright 2023 SiteLint.com
 *
 * Plugin Name:       Spam Prevention for Contact Form 7 and Comments
 * Description:       Automatic Spam Prevention for Contact Form 7 and Comments
 * Version:           1.3.9
 * Author:            SiteLint
 * Author URI:        https://www.sitelint.com
 * Text Domain:       sitelint
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version. Use SemVer - https://semver.org
 */
define('SLSP_SITELINT_VERSION', '1.3.9');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/sitelint-spam-prevention-activator.php
 */
function slsp_activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/sitelint-spam-prevention-activator.php';
	SLSP_SiteLint_Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/sitelint-spam-prevention-deactivator.php
 */
function slsp_deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/sitelint-spam-prevention-deactivator.php';
	SLSP_SiteLint_Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'slsp_activate_plugin_name' );
register_deactivation_hook( __FILE__, 'slsp_deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/sitelint-spam-prevention.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_slsp_sitelint() {

	$plugin = new SiteLintSpamPrevention();
	$plugin->run();

}

run_slsp_sitelint();
