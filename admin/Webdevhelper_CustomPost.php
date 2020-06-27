<?php

class Webdevhelper_CustomPost extends Webdevhelper_Abstruct {

	private $taxonomy;
	private $post_type;

	public function create_cate( $name, $post_type = false ) {
		$this->taxonomy[] = [
			'name'      => $name,
			'slug'      => sanitize_title( $name ),
			'post_type' => ( $post_type ) ? $post_type : $this->post_type,
			'config'    => [ 'hierarchical' => true ]
		];
	}

	public function create_tag( $name, $post_type = false ) {
		$this->taxonomy[] = [
			'name'      => $name,
			'slug'      => sanitize_title( $name ),
			'post_type' => ( $post_type ) ? $post_type : $this->post_type,
			'config'    => [ 'hierarchical' => false ]
		];
	}

	public function set_post_type( $post_type ) {
		$this->post_type = $post_type;
	}

	public function register_taxonomy() {
		foreach ( $this->taxonomy as $taxonomy ) {
			$this->_register_taxonomy( $taxonomy['name'], $taxonomy['slug'], $taxonomy['post_type'], $taxonomy['config'] );
		}
	}

	private function _register_taxonomy( $name, $slug, $post_type, $config ) {
		$labels = array(
			'name'                       => _x( $name, 'Taxonomy General Name', $this->text_domain ),
			'singular_name'              => _x( $name, 'Taxonomy Singular Name', $this->text_domain ),
			'menu_name'                  => __( $name, $this->text_domain ),
			'all_items'                  => __( 'All ' . $name, $this->text_domain ),
			'parent_item'                => __( 'Parent ' . $name, $this->text_domain ),
			'parent_item_colon'          => __( 'Parent ' . $name . ':', $this->text_domain ),
			'new_item_name'              => __( 'New ' . $name, $this->text_domain ),
			'add_new_item'               => __( 'Add New ' . $name, $this->text_domain ),
			'edit_item'                  => __( 'Edit ' . $name, $this->text_domain ),
			'update_item'                => __( 'Update ' . $name, $this->text_domain ),
			'view_item'                  => __( 'View ' . $name, $this->text_domain ),
			'separate_items_with_commas' => __( 'Separate ' . $name . ' with commas', $this->text_domain ),
			'add_or_remove_items'        => __( 'Add or remove ' . $name, $this->text_domain ),
			'choose_from_most_used'      => __( 'Choose from the most used', $this->text_domain ),
			'popular_items'              => __( 'Popular ' . $name, $this->text_domain ),
			'search_items'               => __( 'Search ' . $name, $this->text_domain ),
			'not_found'                  => __( 'Not Found', $this->text_domain ),
			'no_terms'                   => __( 'No ' . $name, $this->text_domain ),
			'items_list'                 => __( 'Items list', $this->text_domain ),
			'items_list_navigation'      => __( 'Items list navigation', $this->text_domain ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => true,
		);
		register_taxonomy( $slug, $post_type, array_replace( $args, $config ) );
	}

	/**
	 * Todo:Register Post type
	 */
	private function _register_post_type(){

	}


}