<?php
	// Setup globals
	// @todo: Get these out of template
	global $wp_query;

	// Setup image width and height variables
	// @todo: Investigate if these are still needed here
	$image_width  = get_option( 'single_view_image_width' );
	$image_height = get_option( 'single_view_image_height' );
?>
<section id="content">


<div class="container_12">
	<div class="grid_12">	
	<?php
		do_action( 'wpsc_top_of_products_page' );
	?>
</div>
</div>
	<div class="single_product_display group">
<?php
		/**
		 * Start the product loop here.
		 * This is single products view, so there should be only one
		 */

		while ( wpsc_have_products() ) : wpsc_the_product(); ?>
				<div class="container_12">
					<div class="grid_12">
					<div class="imagecol">
					<?php if ( wpsc_the_product_thumbnail() ) : ?>
								<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo esc_url( wpsc_the_product_image() ); ?>">
									<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(); ?>"/>
								</a>
								<div class="prod-gallery">
									<?php sb_get_images_for_product(wpsc_the_product_id()); ?>
								</div>
								<?php
								if ( function_exists( 'gold_shpcrt_display_gallery' ) )
									echo gold_shpcrt_display_gallery( wpsc_the_product_id() );
								?>
						<?php else: ?>
									<a href="<?php echo esc_url( wpsc_the_product_permalink() ); ?>">
									<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="<?php echo get_option('product_image_width'); ?>" height="<?php echo get_option('product_image_height'); ?>" />
									</a>
						<?php endif; ?>
					</div><!--close imagecol-->

					<div class="productcol">
							
						<div class="proddesc">
						<?php wpsc_output_breadcrumbs(array('crumb-separator'    => ' &nbsp;/&nbsp;  ',)); ?>	
							<h2><?php echo wpsc_the_product_title(); ?></h2>
							
							<?php do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post); ?>
							
							

							<div class="wpsc_product_price">
									
									<?php if(wpsc_product_is_donation()) : ?>
										<label for="donation_price_<?php echo wpsc_the_product_id(); ?>"><?php _e('Donation', 'wpsc'); ?>: </label>
										<input type="text" id="donation_price_<?php echo wpsc_the_product_id(); ?>" name="donation_price" value="<?php echo wpsc_calculate_price(wpsc_the_product_id()); ?>" size="6" />

									<?php else : ?>
										<?php if(wpsc_product_on_special()) : ?>
											<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><span class="price_old"><?php _e('Old Price', 'wpsc'); ?>:</span> <span class="oldprice" id="old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo curSimble(wpsc_product_normal_price()); ?></span></p>
										<?php endif; ?>
										<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"> <span id='product_price_<?php echo wpsc_the_product_id(); ?>' class="currentprice pricedisplay"><span class="price_price"><?php _e('Price', 'wpsc'); ?>:</span><?php echo curSimble(wpsc_the_product_price()); ?></span></p>
										 <?php if(wpsc_product_on_special()) : ?>
											<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><span class="yousave"><?php _e('You save', 'wpsc'); ?>:</span><span class="yousave" id="yousave_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_currency_display(wpsc_you_save('type=amount'), array('display_as_html'=>false)); ?>! (<?php echo wpsc_you_save(); ?>%)</span></p>
										<?php endif;  ?>
										
										<!-- multi currency code -->
										<?php if(wpsc_product_has_multicurrency()) : ?>
		                                	<?php echo wpsc_display_product_multicurrency(); ?>
	                                    <?php endif; ?>
										
										<?php if(wpsc_show_pnp()) : ?>
											<p class="pricedisplay"><span class="price_shipping"><?php _e('Shipping', 'wpsc'); ?>:</span> <span class="pp_price"><?php echo wpsc_product_postage_and_packaging(); ?></span></p>
										<?php endif; ?>							
									<?php endif; ?>
								</div><!--close wpsc_product_price-->


							<div class="product_description">
								<?php echo wpsc_the_product_description(); ?>
							</div><!--close product_description -->
							<?php echo wpsc_product_rater(); ?>
							<?php if( wpsc_show_stock_availability() ): ?>
										<?php if(wpsc_product_has_stock()) : ?>
											<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="in_stock"><?php _e('Product in stock', 'wpsc'); ?></div>
										<?php else: ?>
											<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="out_of_stock"><?php _e('Product not in stock', 'wpsc'); ?></div>
										<?php endif; ?>
									<?php endif; ?>
							
							<?php  do_action( 'wpsc_product_addons', wpsc_the_product_id() ); ?>		
							
							<?php // echo do_shortcode('[fbcomments][fbcomments url="http://3doordigital.com/wordpress/plugins/facebook-comments/" width="375" count="off" num="3" countmsg="wonderful comments!"]'); ?>


							


							<?php
							/**
							 * Custom meta HTML and loop
							 */
							?>
	                        <?php /* if (wpsc_have_custom_meta()) : ?>
							<div class="custom_meta">
								<?php while ( wpsc_have_custom_meta() ) : wpsc_the_custom_meta(); ?>
									<?php if (stripos(wpsc_custom_meta_name(),'g:') !== FALSE) continue; ?>
									<strong><?php echo wpsc_custom_meta_name(); ?>: </strong><?php echo wpsc_custom_meta_value(); ?><br />
								<?php endwhile; ?>
							</div><!--close custom_meta-->
	                        <?php endif; ?>
							<?php
							/**
							 * Form data
							 */
							?>

							<?php 	
									
									if(wpsc_show_fb_like()): ?>
				                        <div class="FB_like">
				                        <iframe src="https://www.facebook.com/plugins/like.php?href=<?php echo wpsc_the_product_permalink(); ?>&amp;layout=standard&amp;show_faces=true&amp;width=435&amp;action=like&amp;font=arial&amp;colorscheme=light" frameborder="0"></iframe>
				                        </div><!--close FB_like-->
			                        <?php endif; ?>
			                        
			                        <!--sharethis-->
									<?php if ( get_option( 'wpsc_share_this' ) == 1 ): ?>
										<div class="st_sharethis" displayText="ShareThis"></div>
									<?php endif; ?>
									<!--end sharethis-->
			                        
			                        <?php if(function_exists('ctsocial_icons_template')): ?>
										<div class="s_share"><div class="s_inner"><?php _e('Share: ', 'lookshop'); ?></div><?php echo ctsocial_icons_template(); ?></div>
									<?php endif; ?>
							</div>
							
							
							<div id="single-right">
								
							<?php if (wpsc_also_bought( wpsc_the_product_id() )) : ?> 
								<div id="also-bought" >
									<?php echo wpsc_also_bought( wpsc_the_product_id() ); ?> 
									<div class="shade"><div class="shade_in"><div class="shade_bg"></div></div></div>
								</div> 
								<br/>
							<?php endif; ?>
							
							<div class="single_options">
									<?php if(wpsc_product_has_supplied_file() || wpsc_product_has_supplied_file() || wpsc_have_variation_groups() || wpsc_has_multi_adding() || wpsc_product_is_customisable() ) : ?><div class="title"><?php _e('Options:', 'lookshop');  ?></div><?php endif; ?>
									<form class="product_form" enctype="multipart/form-data" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="1" id="product_<?php echo wpsc_the_product_id(); ?>">
										<?php do_action ( 'wpsc_product_form_fields_begin' ); ?>
										<?php if ( wpsc_product_has_personal_text() ) : ?>
											<fieldset class="custom_text">
												<legend><?php _e( 'Personalize Your Product', 'wpsc' ); ?></legend>
												<p><?php _e( 'Complete this form to include a personalized message with your purchase.', 'wpsc' ); ?></p>
												<textarea cols='15' rows='5' name="custom_text"></textarea>
											</fieldset>
										<?php endif; ?>
									
										<?php if ( wpsc_product_has_supplied_file() ) : ?>

											<fieldset class="custom_file">
												<legend><?php _e( 'Upload a File', 'wpsc' ); ?></legend>
												<p><?php _e( 'Select a file from your computer to include with this purchase.', 'wpsc' ); ?></p>
												<input type="file" name="custom_file" size="10" />
											</fieldset>
										<?php endif; ?>	
									<?php /** the variation group HTML and loop */?>
			                        <?php if (wpsc_have_variation_groups()) { ?>
			                        <!--<fieldset><legend><?php _e('Product Options', 'wpsc'); ?></legend>-->
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
									<?php } ?>
									<?php /** the variation group HTML and loop ends here */?>

										<?php
										/**
										 * Quantity options - MUST be enabled in Admin Settings
										 */
										?>
										<?php if(wpsc_has_multi_adding()): ?>
			                            	
			                            	<fieldset><legend><?php _e('Quantity', 'wpsc'); ?></legend>
											<div class="wpsc_quantity_update">
											<div class="inp_field">
												<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" />
											</div>

											
			                                
			                                <div class="qtyupdown">
			                                	<a class="down"></a>
			                                	<a class="up"></a>
			                                </div>

			                                <input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
											<input type="hidden" name="wpsc_update_quantity" value="true" />
			                                
			                                </div><!--close wpsc_quantity_update-->
			                                <script>
			                                	jQuery('.down').click(function(){
			                                		jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').fadeOut('fast', function () {
			                                			item = (jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').val() - 0);
			                                			
			                                			item = item - 1;
			                                			
			                                			if (item < 1) item = 1;

			                                			jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').val(item);
			                                			jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').fadeIn('fast');
			                                		});
			                                	});

			                                	jQuery('.up').click(function(){
			                                		jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').fadeOut('fast', function () {
			                                			item = (jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').val() - 0);
			                                			item = item + 1;
			                                			
			                                			jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').val(item);
			                                			jQuery('#wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>').fadeIn('fast');
			                                		});
			                                	});

			                                </script>

			                                </fieldset>




										<?php endif ;?>
										
										
										<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
										<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />					
										<?php if( wpsc_product_is_customisable() ) : ?>
											<input type="hidden" value="true" name="is_customisable"/>
										<?php endif; ?>
								
										<?php
										/**
										 * Cart Options
										 */
										?>

										<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
											<?php if(wpsc_product_has_stock()) : ?>
												<div class="wpsc_buy_button_container">
														<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
														<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
														<button class="wpsc_buy_button" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'wpsc' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')" />
															<span><?php _e( 'Buy Now', 'wpsc' )?></span>
														</button>
														<?php else: ?>
													<button type="submit" value="" name="Buy" class="wpsc_buy_button reverse" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/>
														<span><?php _e('Add To Cart', 'wpsc'); ?></span>
													</button>
														<?php endif; ?>
													<div class="wpsc_loading_animation">
														<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
														<?php _e('Updating cart...', 'wpsc'); ?>
													</div><!--close wpsc_loading_animation-->
												</div><!--close wpsc_buy_button_container-->
											<?php else : ?>
												<p class="soldout"><?php _e('This product has sold out.', 'wpsc'); ?></p>
											<?php endif ; ?>
										<?php endif ; ?>
										<?php do_action ( 'wpsc_product_form_fields_end' ); ?>
									</form><!--close product_form-->
								
									<?php
										if ( (get_option( 'hide_addtocart_button' ) == 0 ) && ( get_option( 'addtocart_or_buynow' ) == '1' ) )
											echo wpsc_buy_now_button( wpsc_the_product_id() );
									?>
										
								
									<div class="shade"><div class="shade_in"><div class="shade_bg"></div></div></div>
								</div><!--close productcol-->
								</div>
								
								<form onsubmit="submitform(this);return false;" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_extra_<?php echo wpsc_the_product_id(); ?>">
									<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="prodid"/>
									<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="item"/>
								</form>
								
								
								
									</div>
								</div>	
							</div>
						
								







					

		</div><!--close single_product_display-->
		</section>
		

<section>
		<div class="container_12">
			<?php if ( wpsc_the_product_additional_description() ) : ?>
				<div class="grid_4">
						<h2 class="top-20"><?php _e('Product Information', 'lookshop');?></h2>
						<div class="single_additional_description">
							<p><?php echo do_shortcode(wpsc_the_product_additional_description()); ?></p>
						</div><!--close single_additional_description-->
						
					
				</div>
			<?php endif; ?>	
			<div class="grid_<?php if ( wpsc_the_product_additional_description() ) : ?>8<?php else: ?>12<?php endif; ?>">
				<?php echo do_shortcode('[fbcomments]'); ?>
				<?php  echo wpsc_product_comments(); ?>
			</div>
		</div>

</section>
<section class="product_foot">	
<div class="container_12">
	<div class="grid_12">
		<?php  do_action( 'wpsc_product_addon_after_descr', wpsc_the_product_id() ); ?>

<?php endwhile;

    do_action( 'wpsc_theme_footer' ); ?>
</div>
</div>
</section>
