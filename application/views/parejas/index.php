<div class="panel panel-default">
  <div class="panel-heading">
  	<?php echo $concurso->nombre; ?> | PAREJAS
	</div>
  <div class="panel-body">
    <input type="hidden" id="rol" value="<?php echo $rol; ?>">
    <table id="tbl_parejas" class="table table-striped table-bordered"">
    	<thead>
    		<tr>
    			<th>Nombre</th>
          <?php if($rol!=PROFESOR): ?>
          <th>Estado</th> 
          <th>Check In</th>
          <th>Fecha Checkin</th>
          <?php endif; ?>			
    			<th width="400" class="text-center">
            <?php if($rol!=RECEPCIONISTA): ?>
    				<a href="<?php echo base_url("parejas/save"); ?>" class="btn btn-success">
    					<i class="fa fa-plus"></i> Registrar
    				</a>
            <?php else: ?>
            Acciones
            <?php endif; ?>
    			</th>
    		</tr>
    	</thead>
    	<tbody></tbody>
    </table>
  </div>
</div>

<table class="hide">
  <tr>
    <td id="crud_buttons_parejas">
      <center>
        <?php if($rol==ADMIN): ?>
        <a href="" class="btn btn-info validar">
          <i class="fa fa-refresh"></i> Validar
        </a>
        <?php endif; 
        if( in_array($rol, array(ADMIN, RECEPCIONISTA)) ): ?>
        <button type="button" class="btn btn-primary ver">
          <i class="fa fa-eye"></i> Ver
        </button>
        <?php endif; 

        if($rol!=RECEPCIONISTA): ?>
        <a href="" class="btn btn-warning edit">
          <i class="fa fa-pencil"></i> Editar
        </a>

        <button type="button" class="btn btn-danger delete">
          <i class="fa fa-trash"></i> Eliminar
        </button>
        <?php endif; ?>
      </center>
    </td>
  </tr>
</table>

<?php if(in_array($rol, array(ADMIN, RECEPCIONISTA))): ?>
<div id="checkin" class="hide">
  <center>
      <input type="checkbox" class="checkin_dom" data-style="ios" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger"> 
  </center>
</div>

<div id="state_pareja" class="hide">
  <center><span class="label"></span></center>
</div>

<?php 
$this->load->view("parejas/modal_ver.php");
endif; ?>