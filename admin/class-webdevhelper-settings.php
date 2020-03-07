<?php

class Webdevhelper_Settings
{
    private $plugin_name;
    private $version;


    private $page = array(
        'title' => '',
        'slug' => 'default_pagename',
    );

    private $settings;
    private $setting_section;


    private $options;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function setup_page($pagename)
    {
        $clean_pagename = $this->_clean_varname($pagename, $this->page['slug']);
        $this->page['title'] = $pagename;
        $this->page['slug'] = $clean_pagename;
        $this->settings = $clean_pagename . '_settings';
        $this->setting_section = $clean_pagename . '_setting_section';
    }

    public function add_option($option_name, $type, $description = '', $group_name = false)
    {
        $option_id = $this->page['slug'] . '_' . $this->_clean_varname($option_name);
        if (!$group_name)
            $group_name = $this->page['slug'] . '_group';
        if (!$description)
            $description = "Setting will be provided with name: <code>" . $option_id."</code>";
        $this->options[] = array(
            'id' => $option_id,
            'title' => $option_name,
            'type' => $type,
            'description' => $description,
            'group_name' => $this->_clean_varname($group_name),
        );
    }

    private function _get_groups()
    {
        return array_column($this->options, 'group_name');
    }

    public function init_settings()
    {
        //Register new section
        add_settings_section($this->setting_section, 'General Settings', false, $this->page['slug']);

        //Multiple setting fields
        foreach ($this->options as $option) {
            register_setting($option['group_name'], $option['id'], array('type' => $option['type']));
            add_settings_field($option['id'], $option['title'], array($this, 'render_field'), $this->page['slug'], $this->setting_section, $option);
        }


    }

    private function _clean_varname($variablename, $defult_name = false)
    {
        if (!$defult_name)
            $defult_name = $this->plugin_name;
        $variablename = strtolower($variablename);
        $variablename = str_replace(" ", "_", $variablename);
        $variablename = preg_replace('/[^A-Za-z0-9_\-]/', '', $variablename);
        if (preg_match('/^([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)$/', $variablename))
            return $variablename;
        else
            return $defult_name;
    }

    function add_setting_page()
    {
        add_options_page($this->page['title'] . ' Settings', $this->page['title'], 'manage_options', $this->page['slug'], array($this, 'page_layout'));
    }

    public function page_layout()
    {

        // Check required user capability
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        // Admin Page Layout
        echo '<div class="wrap">';
        echo '<h1>' . get_admin_page_title() . '</h1>';
        echo '<form action="options.php" method="post">';

        $groups = $this->_get_groups();
        foreach ($groups as $group)
            settings_fields($group);
        do_settings_sections($this->page['slug']);
        submit_button();

        echo '</form>';
        echo '</div>';

    }

    function render_field($args)
    {
        $value = get_option($args['id']);
        switch ($args['type']) {
            case 'textarea':
                echo '<textarea name="' . $args['id'] . '" class="regular-text" >' . esc_attr($value) . '</textarea>';
                echo '<p class="description">' . $args['description'] . '</p>';
                break;
            default :
                echo '<input type="text" name="' . $args['id'] . '" class="regular-text" placeholder="' . '' . '" value="' . esc_attr($value) . '">';
                echo '<p class="description">' . $args['description'] . '</p>';
                break;
        }

    }

}