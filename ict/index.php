<?php get_header(); ?>
<section id="content">
	<div class="container_12">
	
	<?php if(get_option('isotope_blog') == 'yes'): ?>
	
		<div class="grid_12 cont_col">
			<div class="posts-title">
				<h2 class="category-title"><?php _e('Our Blog', 'lookshop'); ?></h2>
				<div class="filters">
					<div class="categories-filter">
						<?php 
							$args = array('orderby' => 'ASC');
							$cats = get_categories($args);

						?>
							<div class="cat-toggle"><span><?php _e('Cateories', 'lookshop'); ?></span></div>
							<ul>
							<li><a data="All"><?php _e('All', 'lookshop'); ?></a></li>
							<?php foreach($cats as $cat): ?>
								<li><a data="<?php echo 'cat-'.$cat->slug; ?>"><?php echo $cat->slug; ?></a></li>	
							<?php endforeach; ?>
						</ul>
						
					</div>
					<div class="tags-filter">
						<?php 
							$tags = get_the_tags();
						?>
						<div class="tag-toggle"><span><?php _e('Tags', 'lookshop'); ?></span></div>
						<ul>
							<li><a data="All"><?php _e('All', 'lookshop'); ?></a></li>
							<?php foreach($tags as $tag): ?>
								<li><a data="<?php echo 'tag-'.$tag->name; ?>"><?php echo $tag->name; ?></a></li>	
							<?php endforeach; ?>
						</ul>
						
						
					</div>
				</div>
			</div>
	
			
		<div id="posts" class="posts-isotope">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php
				$post_cats = get_the_category($post->ID);
				$post_tags = wp_get_post_tags($post->ID);
				/* Post */
			 ?>
			<div class="isotope-item All <?php foreach($post_cats as $cat) { echo  ' cat-'.$cat->slug; } foreach($post_tags as $tag) { echo ' tag-'.$tag->name; } ?> ">
			<article class="post">
									
									<?php if ( has_post_thumbnail()) : ?>
										<?php echo '<figure class="thumb">'; the_post_thumbnail(); echo '</figure>'; /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ ?>
									<?php endif; ?>
									<div class="post-indent">
									<div class="heading">
										<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark">
											<?php $title = the_title('','', false);  if ($title != '') echo $title; else echo "Article"; ?></a>
										</h2>
																				
									</div>

									<div class="post-meta">
											
										<?php _e('by','lookshop'); ?> <?php the_author_posts_link() ?> 
										<?php _e('at','lookshop'); ?> <?php the_time('F j, Y'); ?>
										<?php _e('in', 'lookshop'); ?> <?php the_category(', ') ?><br/>
										<?php if (the_tags(__('Tags: ','lookshop'), ', ', ' ')); ?>											
											
									</div><!--.postMeta-->

									
									<div class="post-content">
									
										<?php the_excerpt(__('Read more','lookshop'));?>
																				<div class="post-meta-comments">
												<?php comments_popup_link(__('','lookshop'), __('1','lookshop'), __('%','lookshop')); ?>
											</div>

									</div>

																						<div class="clear"></div>
									</div>
									<div class="shade"><div class="shade_in"><div class="shade_bg"></div></div></div>
									
								</article>
							</div>
		
			<?php endwhile; ?>
	</div>
	
	
	

<?php else: ?>
		<div class="no-results box">
			<p><strong><?php echo __('There has been an error.','lookshop'); ?></strong></p>
			<p><?php echo __('We apologize for any inconvenience, please','lookshop'); ?><a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"><?php echo __('return to the home page','lookshop'); ?></a> <?php echo __('or use the search form below.','lookshop'); ?></p>
			<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
		</div><!--noResults-->
	<?php endif; ?>
		
	<nav class="newer-older">
	    <div class="older">
	    		<?php next_posts_link(__('<span>&laquo; Older Entries</span>','lookshop')) ?>
	    </div><!--.older-->
	    <div class="newer">
	    		<?php previous_posts_link(__('<span>Newer Entries &raquo;</span>','lookshop')) ?>
	    </div><!--.older-->
	</nav><!--.oldernewer-->
	
</div>
<script>
jQuery(function(){
  jQuery('#posts.posts-isotope').isotope({
    // options
    itemSelector : '.isotope-item',

    layoutMode : 'masonry',

     masonry: {
    	columnWidth: 320
  	 },

  });
});


</script>
<script>
				

				/*jQuery('select.cats').change(function(){
					
					jQuery('#posts').isotope({ filter: '.cat-' + jQuery(this).children(":selected").html()});
				.categories-filter ul,  .tags-filter ul
				});*/
				jQuery('.categories-filter').toggle(
					function(){
						jQuery(this).find('ul').fadeIn('fast');	
					}, function(){
						jQuery(this).find('ul').fadeOut('fast');	
					}
				);

				jQuery('.tags-filter').toggle(
					function(){
						jQuery(this).find('ul').fadeIn(300);	
					}, function(){
						jQuery(this).find('ul').fadeOut(300);	
					}
				);

				jQuery('.categories-filter ul li').click(function(){
					jQuery('#posts').isotope({ filter: '.' + jQuery(this).find('a').attr('data')});
				});

				jQuery('.tags-filter ul li').click(function(){
					jQuery('#posts').isotope({ filter: '.' + jQuery(this).find('a').attr('data')});
				});

			</script>
			
	<?php else: ?>
	
	<div class="grid_9 cont_col posts-default" id="posts">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); /* New Condition*/?>

		<article>
			<?php if ( has_post_thumbnail()) : ?>
			    <?php echo '<figure class="thumb">'; the_post_thumbnail('default-thumb'); echo '</figure>'; /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ ?>
			<?php endif; ?>			
			<div class="post-inner">
				<h2>
			 		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark">
			    		<?php $title = the_title('','', false);  if ($title != '') echo $title; else echo "Article"; ?>
			 		</a>
			 	</h2>
				<div class="post-meta">
				    		<?php the_time('F j, Y'); ?><?php _e('at','lookshop'); ?> <?php the_time() ?>, <?php _e('by','lookshop'); ?> <?php the_author_posts_link() ?><?php _e(' in ', 'lookshop'); ?><?php the_category(', ') ?>
				    		<?php if (the_tags(__('Tags: ','lookshop'), ', ', ' ')); ?>
				</div><!--.postMeta-->
				<div class="post-content">
				    <?php the_excerpt(__('Read more','lookshop'));?>
				    <div class="post-meta-comments">
					<?php comments_popup_link(__('No Comments','lookshop'), __('1 Comment','lookshop'), __('% Comments','lookshop')); ?>
				</div>
				</div>
				
			</div>
			<div class="clear"></div>
			<div class="shade" style="bottom: -5px; height: 5px;"><div class="shade_in" style="bottom: -5px; height: 5px;"><div class="shade_bg" style="bottom: -5px; height: 5px;"></div></div></div>
		</article>
			
	<?php endwhile; else: ?>
		<div class="no-results box">
			<p><strong><?php echo __('There has been an error.','lookshop'); ?></strong></p>
			<p><?php echo __('We apologize for any inconvenience, please','lookshop'); ?><a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"><?php echo __('return to the home page','lookshop'); ?></a> <?php echo __('or use the search form below.','lookshop'); ?></p>
			<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
		</div><!--noResults-->
	<?php endif; ?>
		
	<nav class="newer-older">
			<div class="older">
					<?php next_posts_link(__('<span>&laquo; Older Entries</span>','lookshop')) ?>
			</div><!--.older-->
			<div class="newer">
					<?php previous_posts_link(__('<span>Newer Entries &raquo;</span>','lookshop')) ?>
			</div><!--.older-->
		</nav><!--.oldernewer-->
	
</div><!--#content-->
<div class="grid_3 side_col_right">
	<?php get_sidebar(); ?>
	<div class="shade"><div class="shade_in"><div class="shade_bg"></div></div></div>
</div>
		
	<?php endif;?>
		
		<div class="clear"></div>
	</div>
	<script>
		jQuery('.posts-default article').hover(function(){
			jQuery(this).find('.shade').animate({bottom:'-3px', height:'3px'}, 200);
			jQuery(this).find('.shade').find('div').animate({bottom:'-3px', height:'3px'}, 200);
		},
		function(){
			jQuery(this).find('.shade').animate({bottom:'-5px', height:'5px'}, 200);
			jQuery(this).find('.shade').find('div').animate({bottom:'-5px', height:'5px'}, 200);
		}); 
	</script>
</section>

<?php get_footer(); ?>
