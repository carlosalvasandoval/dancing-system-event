<div id="modal_ver" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="nombre_pareja">Modal title</h4>
      </div>
	
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-8 col-md-offset-2">
				    <div class="thumbnail">
				      <img id="foto_pareja" src="" class="img-responsive">
				    </div>
				  </div>

					<?php for($i=0; $i<CANT_INTEGRANTES; $i++): ?>
				  <div class="col-sm-6">
				    <div class="thumbnail">
				      <img id="copia_dni_integrante<?php echo $i;?>" src="" class="img-responsive">
				      <div class="caption">
				        <h3 class="text-center" id="nombre_integrante<?php echo $i;?>"></h3>
				      </div>
				    </div>
				  </div>
					<?php endfor; ?>
				</div>
			</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>