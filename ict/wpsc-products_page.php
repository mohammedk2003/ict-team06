<?php
global $wp_query;	
$image_width = get_option('product_image_width');
/*
 * Most functions called in this page can be found in the wpsc_query.php file
 */
?>
<script>

var make_equal_height = function (element) {
            var $within     = jQuery(element),
                selector    = $within.attr('data-equal-height'),
                $children   = jQuery(selector, $within),
                tallest     = 0;
            
            $children.each( function() {
                var $this = jQuery(this);
                
                $this.css('min-height', ''); 
                var h = $this.height();

                if ( h > tallest ) {
                    tallest = h;
                }
            });
            
            $children.each( function() {
                jQuery(this).css('min-height', tallest + 'px'); 
            });

            

        };


</script>
<?php if (wpsc_is_in_category()): ?>

	<h1 class="top-40 category-title">
		<?php echo wpsc_category_name(); ?>
	</h1>

<?php else: ?>
	<h1 class="top-40 category-title"><?php _e('All Products', 'lookshop'); ?></h1>
<?php endif; ?>

<div id="default_products_page_container" class="wrap wpsc_container">

<?php wpsc_output_breadcrumbs(); ?>
	
	<?php do_action('wpsc_top_of_products_page'); // Plugin hook for adding things to the top of the products page, like the live search ?>
	<?php if(wpsc_display_categories()): ?>
	  <?php if(wpsc_category_grid_view()) :?>
			<div class="wpsc_categories wpsc_category_grid group">
				<?php wpsc_start_category_query(array('category_group'=> get_option('wpsc_default_category'), 'show_thumbnails'=> 1)); ?>
					<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_grid_item  <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>">
						<?php wpsc_print_category_image(get_option('category_image_width'),get_option('category_image_height')); ?>
					</a>
					<?php wpsc_print_subcategory("", ""); ?>
				<?php wpsc_end_category_query(); ?>
				
			</div><!--close wpsc_categories-->
	  <?php else:?>
			<ul class="wpsc_categories">
			
				<?php wpsc_start_category_query(array('category_group'=>get_option('wpsc_default_category'), 'show_thumbnails'=> get_option('show_category_thumbnails'))); ?>
						<li>
							<?php wpsc_print_category_image(get_option('category_image_width'), get_option('category_image_height')); ?>
							
							<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_link <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>"><?php wpsc_print_category_name(); ?></a>
							<?php if(wpsc_show_category_description()) :?>
								<?php wpsc_print_category_description("<div class='wpsc_subcategory'>", "</div>"); ?>				
							<?php endif;?>
							
							<?php wpsc_print_subcategory("<ul>", "</ul>"); ?>
						</li>
				<?php wpsc_end_category_query(); ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>
<?php // */ ?>
	
	<?php if(wpsc_display_products()): ?>
		
		<?php if(wpsc_is_in_category()) : ?>
			<div class="wpsc_category_details">
				<?php if(wpsc_show_category_thumbnails()) : ?>
					<img src="<?php echo wpsc_category_image(); ?>" alt="<?php echo wpsc_category_name(); ?>" />
				<?php endif; ?>
				
				<?php if(wpsc_show_category_description() &&  wpsc_category_description()) : ?>
					<?php echo wpsc_category_description(); ?>
				<?php endif; ?>
			</div><!--close wpsc_category_details-->
		<?php endif; ?>
		<?php if(wpsc_has_pages_top()) : ?>
			<div class="wpsc_page_numbers_top">
				<?php wpsc_pagination(); ?>
			</div><!--close wpsc_page_numbers_top-->
		<?php endif; ?>		
		
		<div class="view_switcher">
			<div class="grid <?php if (!isset($_COOKIE['listing_view'])) echo (get_option('default_view') == 'grid' ? ' active ' : '' ); else if ($_COOKIE['listing_view'] == 'grid') echo  ' active ' ?> "></div>
			<div class="list <?php if (!isset($_COOKIE['listing_view'])) echo (get_option('default_view') == 'list' ? ' active ' : '' ); else if ($_COOKIE['listing_view'] == 'list') echo ' active ' ?> "></div>
		</div>
		
		
		
		
		<?php if (defined('TI_IS_HOME') && (TI_IS_HOME == true)){ $delta = 1;  } else { $delta = 0;  } ?>

		<div class="wpsc_default_product_list <?php if (!isset($_COOKIE['listing_view'])) echo (get_option('default_view') == 'grid' ? ' grid ' : 'list' ); else echo $_COOKIE['listing_view'];  ?>" >
		<?php /** start the product loop here */  ?>
		<?php while (wpsc_have_products()) :  wpsc_the_product();?>
	
		<?php if(((get_option('grid_number_per_row') + $delta) > 0) && ((($wp_query->current_post ) % (get_option('grid_number_per_row') + $delta)) == 0)) :?>
		<div class="pr_line" data-equal-height='.default_product_display'>
		<?php endif; ?>	


<div class="default_product_display product_view_<?php echo wpsc_the_product_id(); ?> <?php echo wpsc_category_class(); ?> group 
	<?php if(((get_option('grid_number_per_row') + $delta) > 0) && ((($wp_query->current_post ) % (get_option('grid_number_per_row') + $delta)) == 0)) :?>
	 first
	<?php endif ; ?>">   

				<?php if(wpsc_show_thumbnails()) :?>
					<div class="imagecol" id="imagecol_<?php echo wpsc_the_product_id(); ?>">
						<?php if(wpsc_the_product_thumbnail()) :
						?>
							<a rel="<?php // echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo wpsc_the_product_image(); ?>">
								<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(); ?>"/>

							</a>
						<?php else: ?>
								<a href="<?php echo wpsc_the_product_permalink(); ?>">
								<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="<?php echo get_option('product_image_width'); ?>" height="<?php echo get_option('product_image_height'); ?>" />	
								</a>
						<?php endif; ?>
						<?php
						if(gold_cart_display_gallery()) :					
							echo gold_shpcrt_display_gallery(wpsc_the_product_id(), true);
						endif;
						?>	
					</div><!--close imagecol-->
				<?php endif; ?>
				
					<div class="productcol" style="margin-left:<?php echo $image_width + 20; ?>px;" >
						<h3 class="prodtitle entry-title">
							<?php if(get_option('hide_name_link') == 1) : ?>
								<?php echo wpsc_the_product_title(); ?>
							<?php else: ?> 
								<a class="wpsc_product_title" href="<?php echo wpsc_the_product_permalink(); ?>"><?php echo wpsc_the_product_title(); ?></a>
							<?php endif; ?>
						</h3>
						
						
						<?php							
							do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post);
							do_action('wpsc_product_addons', wpsc_the_product_id());
						?>
						
						
						<div class="wpsc_description">
							<?php if (function_exists('truncate')) : echo truncate(wpsc_the_product_description(), (int) get_option('words_trim_grid')); ?>
							<?php else: echo wpsc_the_product_description(); endif; ?>	
                        </div><!--close wpsc_description-->
                       
						<?php if(wpsc_the_product_additional_description() && (get_option('prod_moreinfo') == '')) : ?>
						<div class="additional_description_container">
							
								<img class="additional_description_button"  src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/icon_window_expand.gif" alt="Additional Description" /><a href="<?php echo wpsc_the_product_permalink(); ?>" class="additional_description_link"><?php _e('More Details', 'wpsc'); ?>
							</a>
							<div class="additional_description">
								<p><?php echo wpsc_the_product_additional_description(); ?></p>
							</div><!--close additional_description-->
						</div><!--close additional_description_container-->
						<?php endif; ?>
						
						<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
							<?php $action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
						<?php else: ?>
						<?php $action = htmlentities(wpsc_this_page_url(), ENT_QUOTES, 'UTF-8' ); ?>					
						<?php endif; ?>					
						<form class="product_form"  enctype="multipart/form-data" action="<?php echo $action; ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_<?php echo wpsc_the_product_id(); ?>" >
						<?php do_action ( 'wpsc_product_form_fields_begin' ); ?>
						<?php /** the variation group HTML and loop */?>
                        <?php if (wpsc_have_variation_groups()) { ?>
                        <?php if (get_option('prod_options') == 'yes') : ?>
                        
                        <fieldset><legend><?php _e('Product Options', 'wpsc'); ?></legend>
						<div class="wpsc_variation_forms">
                        	
							<?php while (wpsc_have_variation_groups()) : wpsc_the_variation_group(); ?>
								<label for="<?php echo wpsc_vargrp_form_id(); ?>"><?php echo wpsc_the_vargrp_name(); ?>:</label>
								<?php /** the variation HTML and loop */?>
								<select class="wpsc_select_variation" name="variation[<?php echo wpsc_vargrp_id(); ?>]" id="<?php echo wpsc_vargrp_form_id(); ?>">
								<?php while (wpsc_have_variations()) : wpsc_the_variation(); ?>
									<option value="<?php echo wpsc_the_variation_id(); ?>" <?php echo wpsc_the_variation_out_of_stock(); ?>><?php echo wpsc_the_variation_name(); ?></option>
								<?php endwhile; ?>
								</select>
							<?php endwhile; ?>
                          
						</div><!--close wpsc_variation_forms-->
                        </fieldset>
                        <?php endif; ?>
						<?php } ?>
						<?php /** the variation group HTML and loop ends here */?>
							
							

							<div class="wpsc_product_price">
								<?php if( wpsc_show_stock_availability() ): ?>
									<?php if(wpsc_product_has_stock()) : ?>
										<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="in_stock"><?php _e('Product in stock', 'wpsc'); ?></div>
									<?php else: ?>
										<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="out_of_stock"><?php _e('Product not in stock', 'wpsc'); ?></div>
									<?php endif; ?>
								<?php endif; ?>
								<?php if(wpsc_product_is_donation()) : ?>
									<label for="donation_price_<?php echo wpsc_the_product_id(); ?>"><?php _e('Donation', 'wpsc'); ?>: </label>
									<input type="text" id="donation_price_<?php echo wpsc_the_product_id(); ?>" name="donation_price" value="<?php echo wpsc_calculate_price(wpsc_the_product_id()); ?>" size="6" />

								<?php else : ?>
									<?php if(wpsc_product_on_special()) : ?>
										<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><span class="price_old"><?php _e('Old Price', 'wpsc'); ?>:</span> <span class="oldprice" id="old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo curSimble(wpsc_product_normal_price()); ?></span></p>
									<?php endif; ?>
									<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"> <span id='product_price_<?php echo wpsc_the_product_id(); ?>' class="currentprice pricedisplay"><span class="price_price"><?php _e('Price', 'wpsc'); ?>:</span><?php echo curSimble(wpsc_the_product_price()); ?></span></p>
									<?php /* <?php if(wpsc_product_on_special()) : ?>
										<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><?php _e('You save', 'wpsc'); ?>:</span> <span class="yousave" id="yousave_<?php echo wpsc_the_product_id(); ?>"><?php echo curSimble(wpsc_currency_display(wpsc_you_save('type=amount'), array('display_as_html'=>false))); ?>! (<?php echo wpsc_you_save(); ?>%)</span></p>
									<?php endif; */ ?>
									<!-- multi currency code -->
									<?php if(wpsc_product_has_multicurrency()) : ?>
	                                	<?php echo wpsc_display_product_multicurrency(); ?>
                                    <?php endif; ?>
									
									<?php if(wpsc_show_pnp()) : ?>
										<p class="pricedisplay"><span class="price_shipping"><?php _e('Shipping', 'wpsc'); ?>:</span> <span class="pp_price"><?php echo wpsc_product_postage_and_packaging(); ?></span></p>
									<?php endif; ?>							
								<?php endif; ?>
								<div class="clear"></div>
							</div><!--close wpsc_product_price-->
							
							<!-- THIS IS THE QUANTITY OPTION MUST BE ENABLED FROM ADMIN SETTINGS -->
							<?php if(wpsc_has_multi_adding()): ?>
							<?php if (!(wpsc_have_variation_groups() && (get_option('prod_options') == 'no'))) : ?>
                   			<div class="wpsc_quantity_update wpsc_quantity_update<?php echo wpsc_the_product_id(); ?>">
                                <?php /*<label for="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>"><?php _e('Quantity', 'wpsc'); ?>:</label>*/ ?>
					             	<div class="inp_field">
               							<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" />
               						</div>
               						
               						<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
									<input type="hidden" name="wpsc_update_quantity" value="true" />
               												<div class="qtyupdown">
               						                        	<a class="down"></a>
               						                        	<a class="up"></a>
               						                        </div>
               						 </div><!--close wpsc_quantity_update-->
               						<script>
                                          jQuery('.wpsc_quantity_update<?php echo wpsc_the_product_id(); ?> .down').click(function(){
                                          	
                                             jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').fadeOut('fast', function () {
                                                item = (jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').val() - 0);
                                                item = item - 1;
                                                if (item < 1) item = 1;
				                                jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').val(item);
                                                jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').fadeIn('fast');
                                             });
                                          });

                                          jQuery('.wpsc_quantity_update<?php echo wpsc_the_product_id(); ?> .up').click(function(){
                                          		
                                             jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').fadeOut('fast', function () {
                                                item = (jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').val() - 0);
                                                item = item + 1;
                                                
                                                jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').val(item);
                                                jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').fadeIn('fast');
                                             });
                                          });

                                         </script>
                			<?php endif ;?>
							<?php endif; ?>
							<input type="hidden" value="add_to_cart" name="wpsc_ajax_action"/>
							<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id"/>
					
							<!-- END OF QUANTITY OPTION -->
							<?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow') !='1')) : ?>
								<?php if(wpsc_product_has_stock()) : ?>
									
									<?php if (wpsc_have_variation_groups() && (get_option('prod_options') == 'no')) : ?>
                        
										<div class="wpsc_buy_button_container">
											<a class="button" href="<?php echo wpsc_the_product_permalink(); ?>"><span><?php _e('View', 'lookshop'); ?></span></a>
										</div>

									<?php else: ?>
									<div class="wpsc_buy_button_container">
											<div class="wpsc_loading_animation">
												<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
												<?php _e('Updating cart...', 'wpsc'); ?>
											</div><!--close wpsc_loading_animation-->
												<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
												<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
												<input class="wpsc_buy_button" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'wpsc' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')">
												<?php else: ?>
											<button type="submit" value="" name="Buy" class="button2 wpsc_buy_button " id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"><span><?php _e('Add To Cart', 'wpsc'); ?></span></button>
												<?php endif; ?>
										</div><!--close wpsc_buy_button_container-->
								<?php endif; ?>


								<?php endif ; ?>
							<?php endif ; ?>
							<div class="entry-utility wpsc_product_utility">
								<?php edit_post_link( __( 'Edit', 'wpsc' ), '<span class="edit-link">', '</span>' ); ?>
							</div>
							<?php do_action ( 'wpsc_product_form_fields_end' ); ?>
						</form><!--close product_form-->
						
						<?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow')=='1')) : ?>
							<?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
						<?php endif ; ?>
						
						<?php echo wpsc_product_rater(); ?>
						
						
					<?php // */ ?>
				</div><!--close productcol-->
			<?php if(wpsc_product_on_special()) : ?><span class="sale"><?php _e('Sale', 'wpsc'); ?></span><?php endif; ?>
			<div class="shade"><div class="shade_in"><div class="shade_bg"></div></div></div>

		</div><!--close default_product_display-->
			
			

			
			<?php if(((get_option('grid_number_per_row') + $delta) > 0) && ((($wp_query->current_post + 1) % (get_option('grid_number_per_row') + $delta)) == 0)) :?>
					<div class="clear"></div>
				</div>

				

			<?php endif; ?>


			
		<?php endwhile; ?>
		<?php /** end the product loop here */?>

		<script>

				jQuery('.default_product_display').hover(function(){
						jQuery(this).find('.shade').animate({bottom:'-3px', height:'3px'}, 200);
						jQuery(this).find('.shade').find('div').animate({bottom:'-3px', height:'3px'}, 200);
					}, 

				function(){

						jQuery(this).find('.shade').animate({bottom:'-5px', height:'5px'}, 200);
						jQuery(this).find('.shade').find('div').animate({bottom:'-5px', height:'5px'}, 200);
				});

				

		</script>	
		<script>
			
			function gridClick(){
				jQuery('.view_switcher').find('.grid').addClass('active');
				jQuery('.view_switcher').find('.list').removeClass('active');
				
				jQuery.cookie("listing_view", null);
				jQuery.cookie("listing_view", 'grid');

				jQuery('.wpsc_default_product_list').fadeOut('fast', function(){
					jQuery('.wpsc_default_product_list').removeClass('list');
					
					jQuery('.wpsc_default_product_list').addClass('grid');
					jQuery('.wpsc_default_product_list').fadeIn('fast', function () {
						make_equal_height(jQuery('.pr_line'));
					});
				});
				
			}

			jQuery('.view_switcher').find('.grid').click(gridClick);

			function listClick(){
				jQuery('.view_switcher').find('.list').addClass('active');
				jQuery.cookie("listing_view", null);
				jQuery.cookie("listing_view", 'list');
				jQuery('.view_switcher').find('.grid').removeClass('active');
				jQuery('.wpsc_default_product_list .pr_line .default_product_display').each(function(){ jQuery(this).removeAttr('style'); });
				
				jQuery('.wpsc_default_product_list').fadeOut('fast', function(){
					
					jQuery('.wpsc_default_product_list').removeClass('grid');
					jQuery('.wpsc_default_product_list').addClass('list');

					jQuery('.wpsc_default_product_list').fadeIn('fast');
				});
				
				
			}

			jQuery('.view_switcher').find('.list').click(listClick);

		</script>
		<script>

			var windowsize = jQuery(window).width();
    		 if (windowsize <= 1024) {
			    	listClick();
			    	
			    } else {
		
				    if(jQuery('.grid').size() != 0) make_equal_height(jQuery('.pr_line'));

				}

 		 </script>
		<div class="clear"></div>
		</div>
		<?php if(wpsc_product_count() == 0):?>
			<h3><?php  _e('There are no products in this group.', 'wpsc'); ?></h3>
		<?php endif ; ?>
	    <?php do_action( 'wpsc_theme_footer' ); ?> 	

		<?php if(wpsc_has_pages_bottom()) : ?>
			<div class="wpsc_page_numbers_bottom">
				<?php wpsc_pagination(); ?>
			</div><!--close wpsc_page_numbers_bottom-->
		<?php endif; ?>
	<?php endif; ?>
</div><!--close default_products_page_container-->
