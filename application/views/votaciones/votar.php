<div class="col-md-4 col-md-offset-4">
  <div class="thumbnail">
    <img src="<?php echo base_url('assets/files/'.(($pareja->foto!=NULL)?$pareja->foto:'pareja.jpg')) ?>">
    <div class="caption text-center">
      <h3><?php echo $pareja->nombre; ?></h3>
    </div>
  </div>
</div>