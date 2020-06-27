<?php

class Webdevhelper_Admin extends Webdevhelper_Abstruct {

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . '-style', plugin_dir_url( __FILE__ ) . 'css/webdevhelper-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name . '-script', plugin_dir_url( __FILE__ ) . 'js/webdevhelper-admin.js', array( 'jquery' ), $this->version, true );
	}

	public function show_admin_notice() {

	}

}
