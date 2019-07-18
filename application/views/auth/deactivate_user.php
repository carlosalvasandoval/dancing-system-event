<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <h3 class="text-center"><?php echo lang('deactivate_heading');?></h3>
    <p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
    <form action="<?php echo base_url('auth/deactivate/'.$user->id); ?>" method="post">
    	<?php echo form_hidden($csrf); ?>
  		<?php echo form_hidden(array('id'=>$user->id)); ?>
		<input type="hidden" name="confirm" value="yes"/>

      	<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<a href="<?php echo base_url('auth'); ?>" class="btn btn-danger btn-block">CANCELAR</a>
				</div>
				<div class="col-md-6">
					<button type="submit" class="btn btn-success btn-block">ACEPTAR</button>
				</div>
			</div>
      	</div>       
    </form>
  </div>
</div>

