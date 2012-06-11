<?php
/*
	Section: WC Breadcrumbs
	Author: Mike Jolley
	Author URI: http://mikejolley.com
	Description: WooCommerce Breadcrumbs
	Class Name: PageLinesWCBreadcrumbs
	Workswith: product_archive, product
	Failswith: pagelines_special_pages()
	Version: 1.0
*/

/**
 * Product navigation Section
 */
class PageLinesWCBreadcrumbs extends PageLinesSection {
	
	/**
	 * Section template.
	 */
	function section_template() { 
		if ( function_exists('woocommerce_breadcrumb') ) 
			woocommerce_breadcrumb();
	}
}
