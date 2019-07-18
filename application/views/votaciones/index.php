<div class="page-header">
  <h1>Concursos <small>Lista</small></h1>
</div>

<div class="col-md-12">
	<div class="list-group">
		<?php foreach($concursos as $concurso): ?>
		<a href="<?php echo base_url('votaciones/parejas/'.$concurso->id); ?>" class="list-group-item">
			<i><b><?php echo $concurso->nombre; ?></b></i>
			- <b>Fecha de Votaciones:</b> <span><?php echo set_datetime($concurso->fecha_ini_votacion); ?></span> 
			- <b>Fecha de Cierre Votaciones:</b> <span><?php echo set_datetime($concurso->fecha_fin_votacion); ?></span> </a>
		<?php endforeach; ?>
	</div>
</div>