<div class="panel panel-default">
  <div class="panel-heading">
  	CONCURSOS
	</div>
  <div class="panel-body">
    <input type="hidden" id="rol" value="<?php echo $user->rol_active; ?>">
    <table id="tbl_concursos" class="table table-striped table-bordered"">
    	<thead>
    		<tr>
    			<th>Nombre</th>
          <th>Categoria</th>
    			<th width="100">Fecha Inscripción</th>
          <th width="100">Fecha Cierre Inscripción</th>
          <th width="100">Fecha Votación</th>
          <th width="100">Fecha Cierre Votación</th>
          <?php if($user->rol_active==ADMIN): ?>
          <th width="100">Parejas por profesor</th>
    			<th width="560" class="text-center">
    				<a href="<?php echo base_url("concursos/save") ?>" class="btn btn-success">
    					<i class="fa fa-plus"></i> Registrar
    				</a>
    			</th>
          <?php else: ?>
          <th>Acciones</th>
          <?php endif; ?>
    		</tr>
    	</thead>
    	<tbody></tbody>
    </table>
  </div>
</div>

<table class="hide">
  <tr>
    <td id="crud_buttons_concursos">
      <center>
        <?php if($user->rol_active==ADMIN): ?>
        <a href="" class="btn btn-sm btn-success estadistica">
          <i class="fa fa-bar-chart"></i> Estadisticas
        </a>

        <a href="" class="btn btn-sm btn-primary recepcion">
          <i class="fa fa-users"></i> Recepcionista
        </a>

        <a href="" class="btn btn-sm btn-info teacher">
          <i class="fa fa-users"></i> Profesores
        </a>

        <a href="" class="btn btn-sm btn-default parejas">
          <i class="fa fa-users"></i> Parejas
        </a>

        <a href="" class="btn btn-sm btn-warning edit">
          <i class="fa fa-pencil"></i> Editar
        </a>

        <button type="button" class="btn btn-sm btn-danger delete">
          <i class="fa fa-trash"></i> Eliminar
        </button>
        <?php else: ?>
        <a href="" class="btn btn-sm btn-primary parejas">
          <i class="fa fa-users"></i> Parejas
        </a>
        <?php endif; ?>
      </center>
    </td>
  </tr>
</table>