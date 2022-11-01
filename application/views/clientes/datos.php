<?php 
$opciones = [
    'contador'=> $datos['contador'],
];
if($datos['busqueda']) $opciones['busqueda'] = $datos['busqueda'];
if(isset($datos['id_clasificacion'])) $opciones['id_clasificacion'] = $datos['id_clasificacion'];

$registros = $this->clientes_model->obtener('clientes', $opciones);
if(count($registros) == 0) echo '<li class="list-group-item">No se encontraron clientes.</li>';

foreach($registros as $cliente) {
    $color_registro = ($cliente->registro_web == "1") ? "info" : "" ;
    $nombre_registro = ($cliente->registro_web == "1") ? "Registrado por la página web" : "" ; 
?>
    <div class="row">
        <div class="col-12 col-md-10 col-lg-10">
            <h4 class="card-title puntero" onClick="javascript:cargarInterfaz('clientes/detalle', 'contenedor_modal', {id: <?php echo $cliente->id; ?>}, 'modal')">
                <?php echo $cliente->nombres; ?> <span class="card-description"><?php echo $cliente->ultima_clasificacion; ?></span>
            </h4>
            <p class="card-description">
                <?php
                echo "<i class='puntero menu-icon mdi mdi-earth' title='País'></i>&nbsp;$cliente->pais";
                echo "<i class='puntero menu-icon mdi mdi-phone' title='Teléfono'></i>&nbsp;$cliente->telefono";
                if($this->session->userdata('administrador')) echo "<i class='puntero menu-icon mdi mdi-mail' title='Correo electrónico'></i>&nbsp;$cliente->email";
                echo "<i class='puntero menu-icon mdi mdi-calendar' title='Fecha de creación'></i>&nbsp;$cliente->fecha_creacion";
                echo "<i class='puntero menu-icon mdi mdi-account' title='Usuario asignado'></i>&nbsp;$cliente->usuario_asignado";
                    
                echo "<br>
                    <span class='puntero' onClick='javascript:cargarInterfaz(`clientes/bitacora/index`, `contenedor_principal`, {cliente_id: $cliente->id})'><i class='menu-icon mdi mdi-library-books' title='Registros en bitácora'></i>&nbsp;$cliente->bitacoras - $cliente->descripcion_ultima_clasificacion</span>
                    <span class='badge bg-$color_registro'>$nombre_registro</span>
                ";
                ?>
            </p>
        </div>

        <?php if ($this->session->userdata('administrador') == '1') { ?>
            <div class="col-12 col-md-2 col-lg-2">
                <div class="d-flex align-items-center h-100">
                    <button type="button" class="btn btn-inverse-dark btn-icon btn-sm" title="Nuevo mensaje" onClick="javascript:cargarInterfaz('clientes/mensaje', 'contenedor_modal', {cliente_id: <?php echo $cliente->id; ?>}, 'modal')">
                        <i class="mdi mdi-message-text-outline"></i>
                    </button>
                </div>
            </div>
        <?php } ?>
    </div>

    <hr class="divisor">
<?php } ?>

<script type="text/javascript">
	$().ready(() => {
		let totalRegistros = parseInt("<?php echo count($registros); ?>")

		// Si no hay más datos o son menos del total configurado, se oculta el botón
		if(totalRegistros == 0 || totalRegistros < parseInt($('#cantidad_datos').val())) $("#btn_mostrar_mas").hide()
	})
</script>