<div class="row">
      <div class="col-md-4 col-md-offset-4">
            <h3 class="text-center"><?php echo lang('change_password_heading');?></h3>
            <form action="<?php echo base_url('auth/change_password'); ?>" method="post">
                  <?php echo form_input($user_id);?>
                  <div class="form-group">
                        <?php echo lang('change_password_old_password_label', 'old_password');?>
                        <input type="password" class="form-control" name="old" id="old" value="<?php echo set_value('old') ?>">
                  </div>

                  <div class="form-group">
                        <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label>
                        <input type="password" class="form-control" name="new" id="new" value="<?php echo set_value('new') ?>">
                  </div>

                  <div class="form-group">
                        <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?>
                        <input type="password" class="form-control" name="new_confirm" id="new_confirm" value="<?php echo set_value('new_confirm') ?>">
                  </div>

                  <div class="form-group">
                        <div class="row">
                              <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-success btn-block">GUARDAR</button>
                              </div>
                        </div>
                  </div>       
            </form>
      </div>
</div>
