<?php
/*
	Plugin Name: WooCommerce for PageLines
	Plugin URI: http://www.pagelines.com
	Author: Mike Jolley
	Author URI: http://mikejolley.com
	Description: Refines and configures the popular WooCommerce plugin for seamless integration into PageLines. 
	PageLines: true
	Version: 1.0

	Based on https://github.com/pagelines/pagelines-jigoshop by bearded-avenger.

	Copyright: © 2009-2012 Mike Jolley.
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Localisation
 **/
load_plugin_textdomain('wc_pagelines', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * WC Pagelines Class
 **/
class WC_Pagelines {
	
	/**
	 * Construct
	 */
	function __construct() {

		$this->base_url = sprintf( '%s/%s', WP_PLUGIN_URL,  basename( dirname( __FILE__ ) ) );
		$this->base_dir = sprintf( '%s/%s', WP_PLUGIN_DIR,  basename( dirname( __FILE__ ) ) );
		
		if ( is_admin() ) {
			add_filter( 'postsmeta_settings_array', array( &$this, 'woocommerce_meta' ), 10, 1 );
			add_filter( 'pl_cpt_dragdrop', array( &$this, 'woocommerce_templates' ), 1, 3 );
		} 
		
		add_filter( 'the_sub_templates', array( &$this, 'woocommerce_the_sub_templates'), 10, 2 );
		add_filter( 'pagelines_sections_dirs', array( &$this, 'woocommerce_pagelines_sections_dirs') );	
		
		//add_filter( 'pagelines_lesscode', array( &$this, 'woocommerce_less' ), 10, 1 );
		//add_action( 'wp_print_styles', array( &$this, 'head_css' ) );
		add_action( 'template_redirect', array( &$this, 'woocommerce_integration' ) );			
		add_action( 'init', array(&$this, 'init'), 10 );
	}
	
	/**
	 * Init the integration
	 **/
	function init() {
		global $woocommerce;
		
		if ( ! class_exists( 'woocommerce' ) ) return;
		
		// Prevent woocommerce templates being loaded
		remove_filter( 'template_include', array( &$woocommerce, 'template_loader' ) );
		
		// Remove related products (we have them in a section)
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		
		// Remove upsells (we have them in a section)
		remove_action('woocommerce_after_single_product', 'woocommerce_upsell_display');
	}
	
	/**
	 * Set default sections for products
	 **/
	function woocommerce_the_sub_templates( $map, $t ) {
	
		$map['product_archive']['sections'] = ( $t == 'main' ) ? array( 'PageLinesWCBreadcrumbs', 'PageLinesProductLoop', 'PageLinesProductPagination' ) : array( 'PageLinesProductContent' );
		
		$map['product']['sections'] = ( $t == 'main' ) ? array( 'PageLinesWCBreadcrumbs', 'PageLinesProductLoop', 'PageLinesShareBar', 'PageLinesRelatedProducts', 'PageLinesUpsells' ) : array( 'PageLinesProductContent' );
	
		return $map;
	}
	
	/**
	 * Make PageLines look for our custom sections
	 **/
	function woocommerce_pagelines_sections_dirs( $dirs ) {
	
		$dirs['woocommerce'] = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/';
		
		return $dirs;	
	}

	/**
	 *	Disable templates for product variations (which are not visible)
	 */	
	function woocommerce_templates( $dragdrop, $public_post_type, $area ) {
		
		if ( 'product_variation' == $public_post_type )
			return false;
			
		return $dragdrop;
	}
	
	/**
	 *	Add integration to store page
	 */
	function woocommerce_integration() {
		if ( is_archive() )
			new PageLinesIntegration( 'product_archive' );
	}
	
	/**
	 *	Add tab to Special Meta
	 */
	function woocommerce_meta( $d ) {
		global $metapanel_options;

		$meta = array(
			'product_archive' => array(
				'metapanel' => $metapanel_options->posts_metapanel( 'product_archive', 'product_archive' ),
				'icon'		=> $this->base_url . '/icon.png'
			) 
		);
		
		$d = array_merge($d, $meta);

		return $d;
	}
	
	/**
	 *	Register our css and enqueue
	 
	function head_css() {
		$style = sprintf( '%s/%s', $this->base_url, 'css/style.css' );		
		wp_register_style( 'pl-woocommerce', $style );
		wp_enqueue_style( 'pl-woocommerce' );	
	}*/

	/**
	 *	Include the LESS css file
	 	
	function woocommerce_less( $less ) {
		$less .= pl_file_get_contents( sprintf( '%s/color.less', $this->base_dir ) );		
		return $less;
	}*/
	
}

// Construct class and store globally for overrides
$GLOBALS['WC_Pagelines'] = new WC_Pagelines;