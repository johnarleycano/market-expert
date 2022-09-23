<?php 
$opciones = [
    'contador'=> $datos['contador'],
];
if($datos['busqueda']) $opciones['busqueda'] = $datos['busqueda'];

$registros = $this->usuarios_model->obtener('usuarios', $opciones);

if(count($registros) == 0) echo '<li class="list-group-item">No se encontraron usuarios.</li>';

foreach($registros as $usuario) {
?>
    <h4 class="card-title puntero" onClick="javascript:cargarInterfaz('usuarios/detalle', 'contenedor_modal', {id: <?php echo $usuario->id; ?>}, 'modal')"><?php echo $usuario->nombres; ?> <?php echo $usuario->apellidos; ?></h4>
    <p class="card-description">
        <?php
        echo "
            <i class='puntero menu-icon mdi mdi-mail' title='Correo'></i>&nbsp;$usuario->email
            <i class='puntero menu-icon mdi mdi-calendar' title='Fecha'></i>&nbsp;$usuario->fecha_creacion
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