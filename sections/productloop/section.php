<?php
/*
	Section: ProductLoop
	Author: Mike Jolley
	Author URI: http://mikejolley.com
	Description: The Main Products Loop. Includes content and product information.
	Class Name: PageLinesProductLoop	
	Workswith: product, product_archive
	Version: 1.0
*/

/**
 * Main Products Loop Section
 */
class PageLinesProductLoop extends PageLinesSection {
		
	/**
	 * Section template.
	 */
	function section_template() { 
   
   		if ( is_archive() ) {
			
			// Post type archive
			?>
			<article class="product type-product hentry fpost">
				<div class="hentry-pad ">
					<div class="entry_wrap fix">
						<div class="entry_content">

							<?php
							if ( is_tax() ) {
								
								global $wp_query;

								$term = get_term_by( 'slug', get_query_var( $wp_query->query_vars['taxonomy'] ) , $wp_query->query_vars['taxonomy'] );
						
								?><h1 class="page-title"><?php echo wptexturize( $term->name ); ?></h1>
						
								<?php if ( $term->description ) : ?>
						
									<div class="term_description"><?php echo wpautop( wptexturize( $term->description ) ); ?></div>
						
								<?php endif;
		
							} else {
							
								if ( ! is_search() ) {
									$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
									$shop_page_title = apply_filters( 'the_title', ( get_option( 'woocommerce_shop_page_title' ) ) ? get_option( 'woocommerce_shop_page_title' ) : $shop_page->post_title );
									if ( is_object( $shop_page  ) )
										$shop_page_content = $shop_page->post_content;
								} else {
									$shop_page_title = __( 'Search Results:', 'woocommerce' ) . ' &ldquo;' . get_search_query() . '&rdquo;';
									if ( get_query_var( 'paged' ) ) $shop_page_title .= ' &mdash; ' . __( 'Page', 'woocommerce' ) . ' ' . get_query_var( 'paged' );
									$shop_page_content = '';
								}
						
								?><h1 class="page-title"><?php echo $shop_page_title ?></h1>
						
								<?php if ( ! empty( $shop_page_content  ) ) echo apply_filters( 'the_content', $shop_page_content );
							
							}
							?>
	
							<?php woocommerce_get_template_part( 'loop', 'shop'  ); ?>

						</div>
					</div>
				</div>
			</article>
			<?php
			
		} else {
			
			global $wp_query;
			
			if ( $wp_query->have_posts() ) while ( $wp_query->have_posts() ) : $wp_query->the_post();
			
			// Single
			?>
			<article class="product type-product hentry fpost">
				<div class="hentry-pad ">
					<div class="entry_wrap fix">
						<div class="entry_content">
							
							<?php do_action( 'woocommerce_before_single_product' ); ?>
							
							<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" class="product">
							
								<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
				
								<div class="summary" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				
									<?php do_action( 'woocommerce_single_product_summary' ); ?>
				
								</div>
				
								<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
							
							</div>
							
							<?php do_action( 'woocommerce_after_single_product' ); ?>
						
						</div>
					</div>
				</div>
			</article>
			<?php
			
			endwhile;
			
		}
		
	}

}
