<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<meta name="viewport"
	content="width=device-width, initial-scale=1.0,  user-scalable=yes">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="css/sticky.css">

<!-- Optional theme -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link href='http://fonts.googleapis.com/css?family=Dosis:400'
	rel='stylesheet' type='text/css'>
<link href="http://fonts.googleapis.com/css?family=Roboto:100"
	rel='stylesheet' type='text/css'>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<title><?php echo $data['title']; ?></title>
</head>
<body>
	<nav id="myNavbar"
		class="navbar navbar-default navbar-inverse navbar-fixed-top"
		role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#navbarCollapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="">Jarisoft - URLShortener</a>
			</div>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#service">URL Shortening Service</a></li>
					<li><a href="#notes">Notes</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="jumbotron">
		<div class="container-fluid">
			<h1>URL - Shortening Service</h1>
			<p>
				This service provides you with a shortening sevice for your own
				domain. Please read the <a href="#notes">notes</a> before you are
				using this service. 
			</p>
			<p>If you are interested in the code of this project you can visit my <a class="btn btn-default" href="https://github.com/jarisoft/urlshortener">GitHub</a>
			</p>
			<p>
				Currently this service redirects <?php echo $data['countActiveShortURLs']; ?> URLs. 
			</p>
		</div>
	</div>
	<div class="container-fluid">
		
	<?php

if (! empty($events)) {
    foreach ($events as $key => $eventArray) {
        if ($key === 0) {
            ?>
           <div class="alert alert-danger alert-dismissible"
		role="alert">
			<?php
        } else 
            if ($key === 1) {
                ?>
			<div class="alert alert-info alert-dismissible" role="alert">
		<?php } else if ($key === 2) { ?>
		<div class="alert alert-warning alert-dismissible" role="alert">
		<?php } ?>
		<button type="button" class="close" data-dismiss="alert"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<ul>
		<?php
        
        foreach ($eventArray as $event) {
            echo "<li>" . $event->getEventMessage() . "</li>";
        }
        ?>
		</ul>
			</div>
            <?php
    }
}

?>