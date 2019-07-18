<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <h3 class="text-center">ACCESO</h3>
    <form action="<?php echo base_url('auth/login'); ?>" method="post">
      <div class="form-group">
        <label for="identify">Usuario</label>
        <input type="text" class="form-control" name="identity" id="identify" placeholder="Ingrese su usuario" required>
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese su password">
      </div>
        
      <button type="submit" class="btn btn-success btn-block">INGRESAR</button>
    </form>
  </div>
</div>

    