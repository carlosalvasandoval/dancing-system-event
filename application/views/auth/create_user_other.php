<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <h3 class="text-center"><?php echo $title_form;?></h3>
    <form action="<?php echo base_url('auth/create_user/'.$rol.'/'.$id); ?>" method="post">
      <div class="col-md-6">
        <div class="form-group">
          <label for="first_name">Nombres: </label>
          <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo ( (!isset($user)) ? set_value('first_name') : $user->first_name ); ?>">
        </div>        
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="last_name">Apellidos: </label>
          <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo ( (!isset($user)) ? set_value('last_name') : $user->last_name ); ?>">
        </div>        
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" class="form-control" name="email" id="email" value="<?php echo ( (!isset($user)) ? set_value('email') : $user->email ); ?>">
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <a href="<?php echo base_url('auth'); ?>" class="btn btn-danger btn-block">CANCELAR</a>
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


