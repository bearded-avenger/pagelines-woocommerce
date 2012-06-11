<?php
/*
	Section: RelatedProducts
	Author: Mike Jolley
	Author URI: http://mikejolley.com
	Description: Related Products
	Class Name: PageLinesRelatedProducts
	Workswith: product
	Version: 1.0
*/

/**
 * Related Products Section
 */
class PageLinesRelatedProducts extends PageLinesSection {
		
	/**
	 * Section template.
	 */
	function section_template() { 

		?>
		<div class="post-footer">
			<div class="post-footer-pad">
			
				<?php woocommerce_output_related_products(); ?>
			
				<div class="clear"></div>
			</div>
		</div><?php
		
	}

}
