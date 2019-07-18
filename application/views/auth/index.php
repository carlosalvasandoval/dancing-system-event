<div class="panel panel-default">
  <div class="panel-heading">
  	USUARIOS
	</div>
  <div class="panel-body">
    <table id="tbl_usuarios" class="table table-striped table-bordered"">
    	<thead>
    		<tr>
    			<th>Nombre y Apellidos</th>
    			<th>Email</th>
          <th>Clave</th>
          <th>Rol</th>
          <th>Estado</th>
    			<th width="200" class="text-center">
            <div class="btn-group">
      				<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plus"></i> Crear usuario <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo base_url('auth/create_user/'.ADMIN); ?>">Administrador</a>
                </li>
                <li>
                  <a href="<?php echo base_url('auth/create_user/'.PROFESOR); ?>">Profesor</a>
                </li>
                <li>
                  <a href="<?php echo base_url('auth/create_user/'.RECEPCIONISTA); ?>">Recepcionista</a>
                </li>
              </ul>
            </div>
    			</th>
    		</tr>
    	</thead>
    	<tbody></tbody>
    </table>
  </div>
</div>

<div class="hide" id="state_user">
  <center>
    <a class='label label-success' href='#'>ACTIVO</a>
  </center>
</div>

<div class="hide" id="rol_user">
  <center>
    <span class='label label-primary'></span>
  </center>
</div>

<table class="hide">
  <tr>
    <td id="crud_buttons_usuarios">
      <center>
        <a href="" class="btn btn-warning edit">
          <i class="fa fa-pencil"></i> Editar
        </a>
      </center>
    </td>
  </tr>
</table>