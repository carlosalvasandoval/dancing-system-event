<div class="panel panel-default">
  <div class="panel-heading">
  	ROLES
	</div>
  <div class="panel-body">
    <table id="tbl_roles" class="table table-striped table-bordered"">
    	<thead>
    		<tr>
    			<th>Nombre</th>
    			<th>Descripción</th>
    			<th width="200" class="text-center">
    				<a href="<?php echo base_url("auth/create_group") ?>" class="btn btn-success">
    					<i class="fa fa-plus"></i> Registrar
    				</a>
    			</th>
    		</tr>
    	</thead>
    	<tbody></tbody>
    </table>
  </div>
</div>

<table class="hide">
  <tr>
    <td id="crud_buttons_roles">
      <center>
        <a href="" class="btn btn-warning edit">
          <i class="fa fa-pencil"></i> Editar
        </a>
      </center>
    </td>
  </tr>
</table>