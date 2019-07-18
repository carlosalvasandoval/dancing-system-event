<div class="page-header">
  <h1><?php echo $concurso->nombre; ?> <small>Parejas</small></h1>
</div>
<?php if (!$fb_logged) : ?>
<a id="login_fb" href="<?php echo $this->facebook->login_url(); ?>" class="hide">Login FB</a>
<?php endif; ?>
<div class="col-md-12">
	<div class="row">
		<?php 
			foreach($parejas as $pareja):
		?>
		<div class="col-md-3">
	    <div class="thumbnail">
	      <img src="<?php echo base_url('assets/files/'.(($pareja->foto!=NULL)?$pareja->foto:'pareja.jpg')) ?>">
	      <div class="caption text-center">
	        <h3><?php echo $pareja->nombre; ?></h3>
	        <p>
	        	<?php echo $pareja->porcentaje; ?> %
	        	<div class="progress">
              		<div id="progress<?php echo $pareja->id;?>" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pareja->porcentaje; ?>%">                  
              		</div>
				</div>
						
			<button pareja_id="<?php echo $pareja->id; ?>" class="btn btn-sm btn-primary btn-like">
				<i class="fa fa-thumbs-o-up"></i> Me gusta <span id="votos<?php echo $pareja->id;?>"><?php echo $pareja->votos;?></span>
			</button>
            <div class="fb-share-button" data-href="<?php echo base_url('votaciones/votar/'.$pareja->id); ?>" data-layout="button_count" data-size="large" data-mobile-iframe="true">            	
            </div>
	        </p>
	      </div>
	    </div>
	  </div>
		<?php endforeach; ?>
	</div>
</div>
<script type="text/javascript">
	var concurso_id = <?php echo $concurso->id; ?>;
	<?php if($has_pareja_selected): ?>
	var pareja_id = -1;
	<?php endif; ?>
</script>