<?php get_header(); 
	
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>

<div id="content" class="clearfix">
	<div class="container clearfix">    
	
	<header class="page-header">

		<?php if ( have_posts() ): ?>
		
				<h2 class="title"><?php printf( __( 'Classification: %s', 'sptheme' ), '<span>' . $term->name . '</span>' ); ?></h2>

		<?php else: ?>
		
				<h2 class="title"><?php _e( 'Nothing Found', 'sptheme' ); ?></h2>

		<?php endif; ?>
				
		<?php
			$category_description = $term->description;
			if ( ! empty( $category_description ) )
			echo '<div class="clear"></div><div class="archive-meta">' . $category_description . '</div>';
		?>

	</header><!-- end .page-header -->
		
    <section id="main">
		<div class="listings">
		
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post();?>
    	
		<?php get_template_part('inc/loop/loop','sp_listing'); ?>
    
		<?php endwhile; ?>

		<?php // Pagination
			if(function_exists('wp_pagenavi'))
				wp_pagenavi();
			else 
				echo sp_pagination(); 
		?>
			
		<?php else: ?>
			<article id="post-0" class="post no-results not-found">
				<h3><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for...', 'sptheme' ); ?></h3>
			</article><!-- end .hentry -->
		<?php endif; ?>
		</div><!-- end .listings -->
	</section><!-- end #main -->
	</div><!-- end .container.clearfix -->    
</section><!-- end #content -->

<?php get_footer(); ?>
