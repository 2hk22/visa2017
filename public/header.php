<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package seed
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/oat.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
</head>

<?php $bodyClass = ''; if (is_active_sidebar( 'headbar' )) { $bodyClass = 'has-headbar'; } ?>

<body <?php body_class($bodyClass); ?>>
<?php
if ( is_front_page() ) { ?>
	<div class="page-wrapper">
		<div class="top-wrapper top-wrapper__bg1">

			<!-- Header -->
			<header class="header header__fixed">
				<div class="header-main">
					<div class="container">
						<!-- Navigation -->
						<nav class="navbar navbar-default fhmm" role="navigation">

							<div class="navbar-header">

							<ul class="nav__center">
								<li class="desktop"><a href="https://www.thailandgrandsale.co/about/">About Event</a></li>
								<li class="nav__center_logo"><a href="https://www.thailandgrandsale.co/"><img src="<?php echo get_template_directory_uri(); ?>/images/tgs.png" style="width: 100%" alt=""></a></li>
								<li class="desktop"><a href="https://www.thailandgrandsale.co/terms-and-conditions/">Term & Cont.</a></li> 
							</ul>

								<button type="button" class="navbar-toggle">
									<i class="fa fa-bars"></i>
								</button>

							</div><!-- end navbar-header -->
							<div class="visible-xs-block">
								<div id="main-nav" class="navbar-collapse collapse">
									<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'nav navbar-nav', 'container' => 'ul') ); ?>
								</div><!-- end #main-nav -->
							</div>

						</nav><!-- end navbar navbar-default fhmm -->
						<!-- Navigation / End -->
					</div>
				</div>

			</header>
<?php } else { ?>
	<div class="page-wrapper">
		<div class="top-wrapper top-wrapper__bg1" id="top">
			<!-- Header -->
			<header class="header header__fixed affix-none">
				<div class="header-main">
					<div class="container">
						<!-- Navigation -->
						<nav class="navbar navbar-default fhmm" role="navigation">

							<div class="navbar-header">

							<ul class="nav__center">
								<li class="desktop"><a href="https://www.thailandgrandsale.co/about/">About Event</a></li>
								<li class="nav__center_logo"><a href="https://www.thailandgrandsale.co/"><img src="<?php echo get_template_directory_uri(); ?>/images/tgs.png" style="width: 100%" alt=""></a></li>
								<li class="desktop"><a href="https://www.thailandgrandsale.co/terms-and-conditions/">Term & Cont.</a></li> 
							</ul>

								<button type="button" class="navbar-toggle">
									<i class="fa fa-bars"></i>
								</button>
	
							</div><!-- end navbar-header -->
							<div class="visible-xs-block">
								<div id="main-nav" class="desktop navbar-collapse collapse">
									<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'nav navbar-nav', 'container' => 'ul') ); ?>
								</div><!-- end #main-nav -->
							</div>

						</nav><!-- end navbar navbar-default fhmm -->
						<!-- Navigation / End -->
					</div>
				</div>
			</header>
			<!-- Header / End -->
		</div>
<?php } ?>