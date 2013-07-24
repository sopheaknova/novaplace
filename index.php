<?php get_header(); ?>

<?php echo sp_map_homepage(); ?>

<div id="content" class="clearfix">
	<div class="container clearfix">    
    <section id="main">
    
    <h2><?php _e('Business Listing', 'sptheme'); ?></h2>
    <?php echo sp_show_cp_posttype('sp_listing', 5); ?>
    
    <h2><?php _e('Events', 'sptheme'); ?></h2>
    <?php echo sp_show_cp_posttype('sp_events', 5); ?>
    
    </section><!-- end #main -->	
    </div><!-- end .container -->
</div><!-- end #content -->

<?php get_footer(); ?>