<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	
	<?php
		if (!isset($page_title))
		{
			$page_title = "AquariumGuru";
		}
	?>
	
	<title><?php echo $page_title?></title>
	<meta name="description" content="AquariumGuru.com is a comprehensive resource for all things aquarium related.">
	<meta name="keywords" content="aquarium,aquariums,fish,freshwater fish,saltwater fish">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	
	<link rel="stylesheet" href="<?php echo base_url();?>stylesheets/base.css">
	<link rel="stylesheet" href="<?php echo base_url();?>stylesheets/skeleton.css">
	<link rel="stylesheet" href="<?php echo base_url();?>stylesheets/layout.css">
	<link rel="stylesheet" href="<?php echo base_url();?>stylesheets/styles.css">
	<link rel="stylesheet" href="<?php echo base_url();?>js/swipebox-master/src/css/swipebox.min.css">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
</head>
<body>
	<div class="container">

	<?php
		// determine what the current navigation tab should be. Default is the homepage
		$page_fish_profiles = "";
		$page_home = "";
		
		if (isset($current_nav_page))
		{
			if ($current_nav_page == "home")
			{
				$page_home = "current_page_item";
			}
			else
			{
				if ($current_nav_page == "fish-profiles")
				{
					$page_fish_profiles = "current_page_item";
				}
			}
		}
		else
		{
			$page_home = "current_page_item";
		}
	?>
	
	<div id="header" class="sixteen columns">
		<div class="one-third column" id="logo">
			<h1><a href="http://aquariumguru.com">AquariumGuru</a></h1>
		</div>
		<div class="two-third column" id="menu">
			<ul>
				<li class="first <?php echo $page_home?>"><a href="/">Homepage</a></li>
				<li class="<?php echo $page_fish_profiles?>"><a href="/fish-profiles">Fish Profiles</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Blog</a></li>
				<li class="last"><a href="#">Contact</a></li>
			</ul>
		</div>
	</div>

	<div class="sixteen columns" style="text-align:center">
		<div id="alert_box"">
		</div>
	</div>


