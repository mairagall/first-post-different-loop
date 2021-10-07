function mg_custom_loop() {
	global $wp_query;
	$paged = get_query_var('paged'); // Adds pagination
	$cat_id = get_query_var('cat'); // Detects which cat is
			$loop = array(
			'category__in' => array($cat_id),
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish',		
			      'paged' => $paged,
	        );
	
			$query = new WP_Query( $loop );
			
			if ( $query->have_posts() ) :
			$count = 0; // Set up counter variable ?>
	<div class="custom-loop-wrap">
			<?php while ($query -> have_posts()) : $query -> the_post(); 
			$count++; // Increment the variable by 1 each time the loop executes
			if( $count<2 ) { // Select firt post ?> 
<div class="first-post">
	<article id="post-<?php the_ID(); ?>">
		<div class="left one-half first">
			<?php if ( has_post_thumbnail() ) { ?>
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'featured-wide', array(
					'class' => 'left',
					'alt'	=> get_the_title()
					) );
				?>
						</a>
				<?php }?>
			</div>
		<div class="one-half excerpt">
			<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
			<?php the_excerpt(); ?>
		</div>
	</article>
</div> 
<?php } else { // Rest of the posts ?> 
				<article id="post-<?php the_ID(); ?>" class="grid-item">
		<div class="featured-image">
			<?php if ( has_post_thumbnail() ) { ?>
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'featured-long', array(
					'class' => 'aligncenter',
					'alt'	=> get_the_title()
					) );
				?>
						</a>
				<?php }?>
			</div>
		<div class="summary">
			<a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
		</div>
	</article>
			<?php  }
	
	endwhile; ?>
	</div>
<?php endif;
	
	
	// Custom query loop pagination
	
	 $GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
        	the_posts_pagination(array(
            'mid_size' => 1,
            'prev_text' => __('Previous'),
            'next_text' => __('Next'),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page') . ' </span>',
        ));
	
	wp_reset_postdata();
}
add_action('genesis_loop', 'mg_custom_loop');
