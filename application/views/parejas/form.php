<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <h3 class="text-center"><?php echo $title_form;?></h3>
    <form action="<?php echo base_url('parejas/save/'.$id); ?>" method="post" enctype="multipart/form-data" id="form_pareja">
      <div class="col-md-12">
        <div class="form-group">
          <label for="nombre_pareja">Nombre de la pareja: </label>
          <input type="text" class="form-control" name="nombre_pareja" id="nombre_pareja" value="<?php echo ( (!empty($post_data)) ? $post_data['nombre_pareja'] : ( (!empty($pareja))?$pareja->nombre : '' ) ); ?>">
        </div>
      </div>

      <?php if($user->rol_active==ADMIN): ?>
      <div class="col-md-6 col-md-offset-3">
        <div class="text-center">
          <label for="copia_dni">Foto de la pareja: </label>                  
        </div>
        <div id="foto" class="file fileinput <?php echo (!empty($pareja->foto))?'fileinput-exists':'fileinput-new'; ?>" data-provides="fileinput" style="width: 100%">
          <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%; height: 300px;">
            <?php if(!empty($pareja->foto)): ?>
            <img src="<?php echo base_url('assets/files/'.$pareja->foto); ?>">
            <?php endif; ?>
          </div>

          <div class="text-center">
            <span class="btn btn-success btn-file">
              <span class="fileinput-new"><i class="fa fa-photo"></i> Seleccionar Imagen</span>
              <span class="fileinput-exists"><i class="fa fa-refresh"></i> Cambiar Imagen</span>
              <input type="file" name="foto">
            </span>
            <a href="javascript:void(0)" class="btn btn-danger fileinput-exists delete_foto" data-dismiss="<?php echo (empty($pareja->foto))?'fileinput':'' ?>" pareja_id="<?php echo (!empty($pareja->foto))?$pareja->id:'' ?>"><i class="fa fa-trash"></i> Quitar Imagen</a>
          </div>
        </div>

        <br><br><br>
      </div>
      <?php endif; ?>  
      <?php for($i=0; $i<CANT_INTEGRANTES; $i++): ?>
      <div class="col-md-6">
        <fieldset class="scheduler-border">
          <legend class="scheduler-border">Integrante <?php echo ($i+1);?></legend>
          <div class="control-group">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="dni">DNI: </label>
                  <input type="text" class="form-control dni" maxlength="8" minlength="8" name="dni[]" value="<?php echo ( (!empty($post_data)) ? $post_data['dni'][$i] : ( (!empty($integrante))?$integrante[$i]->dni : '' ) ); ?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_nacimiento">Fecha de Nacimiento: </label>
                  <input type="text" class="form-control fecha_nacimiento" name="fecha_nacimiento[]" value="<?php echo ( (!empty($post_data)) ? $post_data['fecha_nacimiento'][$i] : ( (!empty($integrante))?$integrante[$i]->fecha_nacimiento : '' ) ); ?>">
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nombres">Nombre(s): </label>
                        <input type="text" class="form-control" name="nombres[]" value="<?php echo ( (!empty($post_data)) ? $post_data['nombres'][$i] : ( (!empty($integrante))?$integrante[$i]->nombres : '' ) ); ?>">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="apellidos">Apellidos: </label>
                        <input type="text" class="form-control" name="apellidos[]" value="<?php echo ( (!empty($post_data)) ? $post_data['apellidos'][$i] : ( (!empty($integrante))?$integrante[$i]->apellidos : '' ) ); ?>">
                      </div>
                    </div>                  
                </div>
              </div>              

              <div class="col-md-8 col-md-offset-2 text-center">
                <div>
                  <label for="copia_dni">Copia DNI: </label>                  
                </div>

                <div id="copia_dni<?php echo $i;?>" class="file fileinput <?php echo (!empty($integrante[$i]->copia_dni))?'fileinput-exists':'fileinput-new'; ?>" data-provides="fileinput" style="width: 100%">
                  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%; height: 300px;">
                    <?php if(!empty($integrante[$i]->copia_dni)): ?>
                    <img src="<?php echo base_url('assets/files/'.$integrante[$i]->copia_dni); ?>">
                    <?php endif; ?>
                  </div>

                  <div>
                    <span class="btn btn-success btn-file">
                      <span class="fileinput-new"><i class="fa fa-photo"></i> Seleccionar Imagen</span>
                      <span class="fileinput-exists"><i class="fa fa-refresh"></i> Cambiar Imagen</span>
                      <input type="file" name="copia_dni[]">
                    </span>
                    <a href="javascript:void(0)" class="btn btn-danger fileinput-exists delete_copia_dni" data-dismiss="<?php echo (empty($integrante[$i]->copia_dni))?'fileinput':'' ?>" integrante_id="<?php echo (!empty($integrante[$i]->copia_dni))?$integrante[$i]->id:'' ?>"><i class="fa fa-trash"></i> Quitar Imagen</a>
                  </div>
                </div>
              </div>      
            </div>
          </div>
        </fieldset>
      </div>
      <?php endfor; ?>

      <div class="col-md-8 col-md-offset-2 text-center">
        <hr>
        <div class="row">
          <div class="col-md-6">
            <a href="<?php echo base_url('parejas/index/'.$concurso_id); ?>" class="btn btn-danger btn-block">CANCELAR</a>            
          </div>

          <div class="col-md-6">
            <button class="btn btn-success btn-block">GUARDAR</button>            
          </div>
        </div>
      </div>      
    </form>
  </div>
</div>


