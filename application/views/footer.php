				</div>
			</div>
		</div>
		<footer class="footer">
			<div class="container">
			<p class="text-muted">© 2018 todos los derechos reservados </p>
			</div>
		</footer>

		<div id="loader">
			<span><i class="fa fa-refresh fa-spin"></i> Procensando....</span>
		</div>
		<script> var url_aplication='<?php echo base_url();?>'; </script>
		<script src="<?php echo base_url('assets/lib/moment.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/lib/jquery-2.2.4.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/lib/bootstrap-3.3.7/js/bootstrap.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/lib/jquery-toast-plugin/jquery.toast.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/lib/sweetalert2/dist/sweetalert2.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/lib/datatables.net-bs/js/jquery.dataTables.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/lib/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/lib/jquery.numeric.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/functions.js'); ?>"></script>
		<?php foreach($lib_js as $js): ?>
		<script src="<?php echo base_url($js); ?>"></script>
		<?php endforeach; ?>
		<?php include_action_script() ?>
	</body>
</html>