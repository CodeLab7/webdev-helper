<?php

class Webdevhelper_Public
{

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name . '-style', plugin_dir_url(__FILE__) . 'css/webdevhelper-public.css', array(), $this->version, 'all');

    }

    public function enqueue_scripts()
    {

        wp_enqueue_script($this->plugin_name . '-script', plugin_dir_url(__FILE__) . 'js/webdevhelper-public.js', array('jquery'), $this->version, true);

    }

}
