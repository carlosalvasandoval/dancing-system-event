<div class="panel panel-default">
  <div class="panel-heading">
  	<?php echo $concurso->nombre; ?> | ESTADISTICAS
	</div>
  <div class="panel-body">
    <table id="tbl_estadisticas" class="table table-striped table-bordered"">
    	<thead>
    		<tr>
    			<th>Nombre</th>
          <th>Integrantes</th>
          <th width="50">Votos</th>
          <th width="600" class="text-center">%</th>
    		</tr>
    	</thead>
    	<tbody>
        <?php foreach($parejas as $pareja): ?>
        <tr>
          <td><?php echo $pareja->nombre;?></td>
          <td><?php echo $pareja->integrantes;?></td>
          <td>
            <center><?php echo $pareja->votos; ?></center>
          </td>
          <td>
            <center>
              <?php echo $pareja->porcentaje; ?>
              <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pareja->porcentaje;?>%">                  
                </div>
              </div>
            </center>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>