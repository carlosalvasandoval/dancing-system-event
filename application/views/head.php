<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo TITLE_SYSTEM; ?></title>
		<meta property="og:title" content="<?php echo (isset($graph))?$graph->title:TITLE_SYSTEM; ?>" />
		<meta property="og:image" content="<?php echo (isset($graph))?$graph->image:''; ?>" />
		<meta property="og:url" content="<?php echo (isset($graph))?$graph->url:base_url(); ?>" />
		<meta property="og:type" content="website" />

		<link href="<?php echo base_url('assets/lib/bootstrap-3.3.7/css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/lib/bootstrap-3.3.7/css/sticky-footer-navbar.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/lib/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/lib/jquery-toast-plugin/jquery.toast.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/lib/sweetalert2/dist/sweetalert2.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/lib/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>" rel="stylesheet">
		<?php foreach($lib_css as $css): ?>
		<link href="<?php echo base_url($css); ?>" rel="stylesheet">
		<?php endforeach; ?>
		<link href="<?php echo base_url('assets/css/main.css'); ?>" rel="stylesheet">
	</head>
	<body>
	<?php if(isset($fb_api)): ?>
	<div id="fb-root"></div>
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '2020222718019603',
	      xfbml      : true,
	      version    : 'v3.0'
	    });
	    FB.AppEvents.logPageView();
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "https://connect.facebook.net/es_LA/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>
	<?php endif; ?>
  	<nav class="navbar navbar-default">
		<div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="<?php echo base_url('/'); ?>"><?php echo TITLE_SYSTEM; ?></a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav navbar-right">
		    	<?php if(!$this->ion_auth->logged_in()): ?>
		        <li>
		        	<a href="<?php echo base_url("auth") ?>">
		        		<i class="fa fa-sign-in"></i> Login
		        	</a>
		        </li>
		      	<?php else: ?>
						<li>
		      		<a href="<?php echo base_url("concursos") ?>">
		      			<i class="fa fa-tasks"></i> Concursos
		      		</a>
		      	</li>
		      	<?php 
		      			if($this->ion_auth->is_admin()):
		      	?>		 
		      	<li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-lock"></i> Seguridad <span class="caret"></span></a>
		          <ul class="dropdown-menu">
		            <li class="hide">
		            	<a href="<?php echo base_url("roles") ?>">Roles</a>
		            </li>
		            <li>
		            	<a href="<?php echo base_url("auth") ?>">Usuarios</a>
		            </li>
		          </ul>
		        </li>
		      	<?php endif;?>
						<li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		          	<i class="fa fa-user"></i> <?php echo $user_logged->first_name." ".$user_logged->last_name; ?> <span class="caret"></span>
		          </a>
		          <ul class="dropdown-menu">
		            <li>
		            	<a href="<?php echo base_url("auth/change_password") ?>">Cambiar clave</a>
		            </li>
		            <li>
		            	<a href="<?php echo base_url("auth/logout") ?>">Salir</a>
		            </li>
		          </ul>
		        </li>
		      	<?php endif; ?>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		<div class="container-fluid" id="contend">
			<div class="row">
				<div class="col-md-12">
					<?php if(!empty($message) && !empty($message["text"])): ?>
				    <div class="alert alert-<?php echo $message['type']?>"><strong><?php echo $message['text']; ?></strong></div>
				    <?php endif; ?>