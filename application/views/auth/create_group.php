<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <h3 class="text-center"><?php echo lang('create_group_heading');?></h3>
    <p><?php echo lang('create_group_subheading');?></p>
    <form action="<?php echo base_url('auth/create_group'); ?>" method="post">
      <div class="form-group">
        <label for="identify">Nombre de Grupo: </label>
        <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Ingrese su grupo" required>
      </div>

      <div class="form-group">
        <label for="identify">Descripción:</label>
        <input type="text" class="form-control" name="description" id="description" placeholder="Ingrese la descripción del grupo" required>
      </div>

      <div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<a href="<?php echo base_url('roles'); ?>" class="btn btn-danger btn-block">CANCELAR</a>
					</div>
					<div class="col-md-6">
						<button type="submit" class="btn btn-success btn-block">GUARDAR</button>
					</div>
				</div>
      </div>       
    </form>
  </div>
</div>