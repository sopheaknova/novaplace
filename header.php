<?php
	/* get theme options for further processing */
	global $smof_data, $is_IE; 
?>
<!DOCTYPE html>
<!--[if IE 7]>                  <html class="ie7 no-js"  <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js"  <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">  <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	
    <title>
	<?php wp_title( '|', true, 'right' ); ?>
    </title>
   	
    <link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="shortcut icon" href="<?php echo ($smof_data['theme_favico'] == '') ? SP_BASE_URL.'favicon.ico' : $smof_data['theme_favico']; ?>" type="image/x-icon" /> 
    
    <?php
	if ($smof_data['share_post'])
		sp_og_image();  
	?>	
    
	<?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?>>

<div class="wrapper boxed-mode">
	
    <header id="header">
    	<div class="container clearfix">
    	<div class="logo">
        	<?php if( !is_singular() ) echo '<h1>'; else echo '<h2>'; ?>
            
            <a  href="<?php echo home_url() ?>/"  title="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>">
            	<?php if($smof_data['theme_logo'] == '') : ?>
                <img src="<?php echo $smof_data['theme_logo']; ?>" alt="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>" />
                <?php else: ?>
                <span><?php bloginfo( 'name' ); ?></span>
                <?php endif; ?>
			</a>
            
            <?php if( !is_singular() ) echo '</h1>'; else echo '</h2>'; ?>
        </div><!-- end .logo -->
                
        </div><!-- end .container -->
    </header>
    
    




