<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <h3 class="text-center">Validación <?php echo $pareja->nombre;?></h3>    
    <form  method="post">
        <div class="form-group">
          <div class="row">
            <div class="col-md-4">
              <div class="radio text-center">
                <label><input type="radio" name="estado_pareja" value="<?php echo PAREJA_VALIDACION_PENDIENTE; ?>" <?php if($pareja->estado_pareja == PAREJA_VALIDACION_PENDIENTE):?> checked <?php endif;?>> Pendiente</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="radio text-center">
                <label><input type="radio" name="estado_pareja" value="<?php echo PAREJA_RECHAZADA; ?>" <?php if($pareja->estado_pareja == PAREJA_RECHAZADA):?> checked <?php endif;?>> Rechazar</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="radio text-center">
                <label><input type="radio" name="estado_pareja" value="<?php echo PAREJA_VALIDADA; ?>" <?php if($pareja->estado_pareja == PAREJA_VALIDADA):?> checked <?php endif;?>> Validada</label>
              </div>
            </div>
          </div>
        </div>

      	<div class="form-group">
    			<div class="row">
    				<div class="col-md-6">
    					<a href="<?php echo base_url('parejas/index/'.$concurso_id); ?>" class="btn btn-danger btn-block">CANCELAR</a>
    				</div>
    				<div class="col-md-6">
    					<button type="submit" class="btn btn-success btn-block">ACEPTAR</button>
    				</div>
    			</div>
      	</div>       
    </form>
  </div>
</div>