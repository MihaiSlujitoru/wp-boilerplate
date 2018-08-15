<!DOCTYPE html> 
<html <?php language_attributes(); ?>>
<head> 
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1">
<meta name="format-detection" content="telephone=no">


<link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_template_directory_uri() ?>/favicon.ico" type="image/x-icon">

<?php 
	wp_get_archives('type=monthly&format=link');
	wp_enqueue_script("jquery");
	wp_head();
?>

</head>
<body <?php body_class(); ?>>
<a href="#skip-to-content" id="skip" class="visually-hidden" tabindex="1">Skip to Content</a>