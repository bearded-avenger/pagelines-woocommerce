<?php
/*
	Section: ProductPagination
	Author: Mike Jolley
	Author URI: http://mikejolley.com
	Description: Product Pagination - A numerical product navigation. (Supports WP-PageNavi)
	Class Name: PageLinesProductPagination
	Workswith: product_archive
	Failswith: pagelines_special_pages()
	Version: 1.0
*/

/**
 * Product navigation Section
 */
class PageLinesProductPagination extends PageLinesSection {
	
	/**
	 * Section template.
	 */
	function section_template() { 
		do_action( 'woocommerce_pagination' );
	}
}
