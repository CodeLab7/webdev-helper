<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Webdev Helper
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Codelab7
 * Author URI:        https://codelab7.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       webdevhelper
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('WEBDEVHELPER_VERSION', '1.0.0');

function activate_webdevhelper()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-webdevhelper-activator.php';
    Webdevhelper_Activator::activate();
}

function deactivate_webdevhelper()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-webdevhelper-deactivator.php';
    Webdevhelper_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_webdevhelper');
register_deactivation_hook(__FILE__, 'deactivate_webdevhelper');

require plugin_dir_path(__FILE__) . 'includes/class-webdevhelper.php';


function run_webdevhelper()
{

    $plugin = new Webdevhelper();
    $plugin->run();

}

run_webdevhelper();
