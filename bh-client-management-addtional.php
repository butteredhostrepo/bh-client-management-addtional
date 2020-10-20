<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Bh_Client_Management_Addtional
 *
 * @wordpress-plugin
 * Plugin Name:       Buttered Host Client management Extension
 * Plugin URI:        #
 * Description:       Buttered Host client management additional functions
 * Version:           1.0.0
 * Author:            Buttered Host
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bh-client-management-addtional
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('BH_CLIENT_MANAGEMENT_ADDTIONAL_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bh-client-management-addtional-activator.php
 */
function activate_bh_client_management_addtional()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-bh-client-management-addtional-activator.php';
	Bh_Client_Management_Addtional_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bh-client-management-addtional-deactivator.php
 */
function deactivate_bh_client_management_addtional()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-bh-client-management-addtional-deactivator.php';
	Bh_Client_Management_Addtional_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_bh_client_management_addtional');
register_deactivation_hook(__FILE__, 'deactivate_bh_client_management_addtional');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

require plugin_dir_path(__FILE__) . 'admin/risk_report_settings.php';
require plugin_dir_path(__FILE__) . 'admin/added_roles.php';


require plugin_dir_path(__FILE__) . 'includes/class-bh-client-management-addtional.php';
require plugin_dir_path(__FILE__) . 'public/clients.php';
require plugin_dir_path(__FILE__) . 'public/counsellors.php';
require plugin_dir_path(__FILE__) . 'public/my_profile.php';
require plugin_dir_path(__FILE__) . 'public/reports.php';
require plugin_dir_path(__FILE__) . 'public/donations.php';

require plugin_dir_path(__FILE__) . 'public/ajax.php';
require plugin_dir_path(__FILE__) . 'public/post.php';
require plugin_dir_path(__FILE__) . 'public/utils.php';
require plugin_dir_path(__FILE__) . 'public/hooks.php';
require plugin_dir_path(__FILE__) . 'public/mail.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bh_client_management_addtional()
{

	$plugin = new Bh_Client_Management_Addtional();
	$plugin->run();
}
run_bh_client_management_addtional();
