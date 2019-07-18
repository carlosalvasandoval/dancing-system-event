<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <h3 class="text-center"><?php echo $title_form;?></h3>
    <form action="<?php echo base_url('concursos/save'); ?>" method="post">
      <input type="hidden" name="id" value="<?php echo ( (empty($concurso)) ? '' : $concurso->id ); ?>">
      <div class="col-md-12">
        <div class="form-group">
          <label for="nombre">Nombre: </label>
          <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo ( (empty($concurso)) ? set_value('nombre') : $concurso->nombre ); ?>">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="fecha_ini_inscripcion">Fecha Inscripción: </label>
          <input type="text" class="form-control" name="fecha_ini_inscripcion" id="fecha_ini_inscripcion" value="<?php echo ( (empty($concurso)) ? set_value('fecha_ini_inscripcion') : $concurso->fecha_ini_inscripcion ); ?>">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="fecha_fin_inscripcion">Fecha Cierre Inscripción: </label>
          <input type="text" class="form-control" name="fecha_fin_inscripcion" id="fecha_fin_inscripcion" value="<?php echo ( (empty($concurso)) ? set_value('fecha_fin_inscripcion') : $concurso->fecha_fin_inscripcion ); ?>">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="fecha_ini_votacion">Fecha Votación: </label>
          <input type="text" class="form-control" name="fecha_ini_votacion" id="fecha_ini_votacion" value="<?php echo ( (empty($concurso)) ? set_value('fecha_ini_votacion') : $concurso->fecha_ini_votacion ); ?>">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="fecha_fin_votacion">Fecha Cierre Votación: </label>
          <input type="text" class="form-control" name="fecha_fin_votacion" id="fecha_fin_votacion" value="<?php echo ( (empty($concurso)) ? set_value('fecha_fin_votacion') : $concurso->fecha_fin_votacion ); ?>">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="parejas_profesor">N° parejas por Profesor: </label>
          <input type="text" class="form-control" name="parejas_profesor" id="parejas_profesor" value="<?php echo ( (empty($concurso)) ? set_value('parejas_profesor') : $concurso->parejas_profesor ); ?>">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="parejas_profesor">Categoria: </label>
          <select name="categoria_id" id="categoria_id" class="form-control">
            <option value="">[SELECCIONE]</option>
            <?php foreach($categorias as $categoria): ?>
            <option value="<?php echo $categoria->id;?>" <?php if( ( !empty($concurso) && $concurso->categoria_id == $categoria->id ) || ( !empty($post_data) && $post_data["categoria_id"] == $categoria->id ) ):?> selected <?php endif;?> ><?php echo $categoria->nombre; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <a href="<?php echo base_url('concursos'); ?>" class="btn btn-danger btn-block">CANCELAR</a>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-success btn-block">GUARDAR</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>


