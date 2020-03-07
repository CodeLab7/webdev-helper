<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://codelab7.com
 * @since      1.0.0
 *
 * @package    Webdevhelper
 * @subpackage Webdevhelper/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Webdevhelper
 * @subpackage Webdevhelper/includes
 * @author     Codelab7 <info@codelab7.com>
 */
class Webdevhelper
{
    protected $loader;

    protected $plugin_name;

    protected $version;

    public function __construct()
    {
        if (defined('WEBDEVHELPER_VERSION')) {
            $this->version = WEBDEVHELPER_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'webdevhelper';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        /**
         * Open Below for Create Master setting page to use everywhere
         */
        //$this->create_master_settings();
    }

    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-webdevhelper-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-webdevhelper-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-webdevhelper-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-webdevhelper-settings.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-webdevhelper-public.php';

        $this->loader = new Webdevhelper_Loader();

    }

    private function set_locale()
    {

        $plugin_i18n = new Webdevhelper_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    private function define_admin_hooks()
    {

        $plugin_admin = new Webdevhelper_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

    }


    private function create_master_settings()
    {
        //Adding settings
        $plugin_settings = new Webdevhelper_Settings($this->get_plugin_name(), $this->get_version());
        $plugin_settings->setup_page('Webdev Helper');
        $plugin_settings->add_option('Developer Name', 'text');
        $plugin_settings->add_option('Developer Address', 'textarea');
        $this->loader->add_action('admin_init', $plugin_settings, 'init_settings');
        $this->loader->add_action('admin_menu', $plugin_settings, 'add_setting_page');
    }

    private function define_public_hooks()
    {

        $plugin_public = new Webdevhelper_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    }

    public function run()
    {
        $this->loader->run();
    }

    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    public function get_loader()
    {
        return $this->loader;
    }

    public function get_version()
    {
        return $this->version;
    }

}
