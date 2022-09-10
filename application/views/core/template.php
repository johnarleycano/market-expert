<!DOCTYPE html>
<html lang="es">
	<input type="hidden" id="environment" value="<?php echo ENVIRONMENT; ?>">

	<head>
		<?php $this->load->view('core/header'); ?>
	</head>

	<body>
		<div id="contenedor_modal"></div>

		<input type="hidden" id="cantidad_datos" value="<?php echo $this->config->item('cantidad_datos'); ?>">
		<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
		<input type="hidden" id="site_url" value="<?php echo site_url(); ?>">

		<!-- Si ya inició sesión -->
		<?php if($this->session->userdata('usuario_id')) { ?>
			<div class="container-scroller">
				<!-- Menú superior -->
				<?php $this->load->view('core/menu_superior'); ?>

				<div class="container-fluid page-body-wrapper">
					<?php
					// Configurador de temas
					$this->load->view('core/colores');

					// Menú lateral
					$this->load->view('core/menu_lateral');
					?>

					<div class="main-panel">
						<!-- Contenido principal -->
						<div class="content-wrapper" id="contenedor_principal">
							<?php $this->load->view($contenido_principal); ?>
						</div>

						<!-- Pié de página -->
						<?php $this->load->view('core/footer'); ?>
					</div>
				</div>
			</div>
		<?php } else {
			$this->load->view($contenido_principal);
		} ?>
		
		<script src="<?php echo base_url(); ?>vendors/js/vendor.bundle.base.js"></script>
		<script src="<?php echo base_url(); ?>vendors/chart.js/Chart.min.js"></script>
		<script src="<?php echo base_url(); ?>vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo base_url(); ?>vendors/progressbar.js/progressbar.min.js"></script>
		<script src="<?php echo base_url(); ?>vendors/jquery-file-upload/jquery.uploadfile.min.js"></script>
		<script src="<?php echo base_url(); ?>vendors/select2/select2.min.js"></script>
		<script src="<?php echo base_url(); ?>js/off-canvas.js"></script>
		<script src="<?php echo base_url(); ?>js/hoverable-collapse.js"></script>
		<script src="<?php echo base_url(); ?>js/template.js"></script>
		<script src="<?php echo base_url(); ?>js/settings.js"></script>
		<script src="<?php echo base_url(); ?>js/todolist.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.cookie.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>js/dashboard.js"></script>
		<script src="<?php echo base_url(); ?>js/Chart.roundedBarCharts.js"></script>
		<script src="<?php echo base_url(); ?>js/timeago.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>js/timeago.es.js" type="text/javascript"></script>
	</body>
</html>