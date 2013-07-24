<?php get_header(); ?>

<div id="content" class="clearfix">
	<div class="container clearfix">    
    <section id="main">
     
    <?php 
    if (have_posts()) : while (have_posts()) : the_post();
    
    	get_template_part('inc/loop/loop','sp_events');
	
	endwhile; endif; 
	?>
    
    </section><!-- end #main -->	
    
    <?php get_sidebar(); ?>
    
    </div><!-- end .container -->
</div><!-- end #content -->

<?php get_footer(); ?>
