﻿<?php
/**
 * Header Template
 *
 * The header template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the top of the file. It is used mostly as an opening
 * wrapper, which is closed with the footer.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package Hybrid
 * @subpackage Template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php hybrid_document_title(); ?></title>

<?php wp_head(); ?>

</head>

<body class="<?php hybrid_body_class(); ?>">

<?php do_atomic( 'before_html' ); // hybrid_before_html ?>

<div id="body-container">
	<?php do_atomic( 'before_header' ); // hybrid_before_header ?>

	<div id="header-container">
        <div id="header-wrapper">
            
            <div id="header">

                <?php do_atomic( 'header' ); // hybrid_header ?>

            </div><!-- #header -->
            
                <?php do_atomic( 'after_header_inside' ); ?>
            
        </div><!-- #header-wrapper -->
	</div><!-- #header-container -->

	<?php do_atomic( 'after_header' ); // hybrid_after_header ?>

	<div id="container">

		<?php do_atomic( 'before_container' ); // hybrid_before_container ?>