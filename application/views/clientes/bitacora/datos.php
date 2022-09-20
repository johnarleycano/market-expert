<?php
$opciones = [
    'contador'=> $datos['contador'],
    'cliente_id' => $datos['cliente_id']
];
if($datos['busqueda']) $opciones['busqueda'] = $datos['busqueda'];

$registros = $this->clientes_model->obtener('cliente_bitacora', $opciones);
if(count($registros) == 0) echo '<li class="list-group-item">No se encontraron registros para el cliente.</li>';

foreach($registros as $bitacora) {
?>
    <h4 class="card-title puntero"><?php echo $bitacora->clasificacion; ?></h4>
    <p class="card-description">
        <?php
        echo "
            <i class='puntero menu-icon mdi mdi-format-list-bulleted-type' title='Fecha'></i>&nbsp;$bitacora->descripcion
            <i class='puntero menu-icon mdi mdi-account' title='Fecha'></i>&nbsp;$bitacora->usuario
            <i class='puntero menu-icon mdi mdi-calendar' title='Fecha'></i>&nbsp;$bitacora->fecha_creacion
            <br>
        ";
        ?>
    </p>
    <hr class="divisor">
<?php } ?>

<script type="text/javascript">
	$().ready(() => {
		let totalRegistros = parseInt("<?php echo count($registros); ?>")

		// Si no hay más datos o son menos del total configurado, se oculta el botón
		if(totalRegistros == 0 || totalRegistros < parseInt($('#cantidad_datos').val())) $("#btn_mostrar_mas").hide()
	})
</script>