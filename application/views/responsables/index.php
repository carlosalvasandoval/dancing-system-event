<div class="panel panel-default">
  <div class="panel-heading">
  	<?php echo $title_view ?>
    <a href="<?php echo base_url('concursos'); ?>" class="btn btn-primary pull-right btn-sm">Regresar</a>
	</div>
  <div class="panel-body">
    <form action="<?php echo base_url("responsables/save"); ?>" method="post">
      <input type="hidden" id="rol" name="rol" value="<?php echo $rol;?>">
      <input type="hidden" id="concurso_id" name="concurso_id" value="<?php echo $concurso_id;?>">
      <div class="row">
        <div class="col-md-8">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon3">Asignar <?php echo $rol_name; ?></span>
            <select class="form-control select2" id="user_id" name="user_id" required>
              <option value="">[SELECCIONE]</option>
              <?php foreach($desasignados as $desasignado): ?>
              <option value="<?php echo $desasignado->id; ?>"><?php echo $desasignado->full_name; ?></option>
              <?php endforeach; ?>
            </select>
            <span class="input-group-btn">
              <button class="btn btn-success"><i class="fa fa-plus"></i> Asignar</button>
            </span>
          </div>
        </div>        
      </div>
    </form>

    <hr>
    <table id="tbl_responsables" class="table table-striped table-bordered"">
    	<thead>
    		<tr>
    			<th>Nombre(s) y Apellidos</th>
    			<th>Email</th>
    			<th width="100" class="text-center">
    				Acción
    			</th>
    		</tr>
    	</thead>
    	<tbody></tbody>
    </table>
  </div>
</div>

<table class="hide">
  <tr>
    <td id="crud_buttons_responsables">
      <center>
        <a href="" class="btn btn-sm btn-danger delete">
          <i class="fa fa-remove"></i> Desasignar
        </a>
      </center>
    </td>
  </tr>
</table>