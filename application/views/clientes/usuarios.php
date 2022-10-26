<div class="modal-header">
    <h5 class="modal-title">Asignación de usuario masiva</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <form class="row">
        <div class="col-12 col-md-6 col-lg-6 form-group m-0">
            <label for="clasificacion" class="form-label">Clasificación <b class="text-danger">*</b></label>
            <select id="clasificacion" class="form-select form-select-sm">
                <option value="">Seleccione</option>
                <?php foreach ($this->configuracion_model->obtener('clientes_bitacora_clasificaciones') as $clasificacion) { ?>
                    <option value="<?php echo $clasificacion->id; ?>"><?php echo $clasificacion->nombre; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-12 col-md-6 col-lg-6 form-group m-0">
            <label for="usuario_asignado" class="form-label">Usuarios <b class="text-danger">*</b></label>
            <select id="usuario_asignado" class="form-select form-select-sm">
                <option value="">Seleccione</option>
                <?php foreach ($this->usuarios_model->obtener('usuarios') as $usuario) { ?>
                    <option value="<?php echo $usuario->id; ?>"><?php echo "$usuario->nombres $usuario->apellidos"; ?></option>
                <?php } ?>
            </select>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" onClick="javascript:asignarUsuarios()">Cambiar</button>
</div>

<script type="text/javascript">
    asignarUsuarios = async () => {
        let camposObligatorios = [
            $('#clasificacion'),
            $('#usuario_asignado')
        ]

        // Se validan los datos obligatorios
        if (!validarCamposObligatorios(camposObligatorios)) return false

        let datos = {
            tipo: 'asignar_usuarios_clientes',
            clasificacion: $('#clasificacion').val(),
            usuario_asignado: $('#usuario_asignado').val()
        }

        // Se realiza el cambio de usuario asignado
        let respuesta = await consulta('asignacion_masiva', datos)

        // Al cambiar el usuario asignado
        if (parseInt(respuesta.resultado) > 0) {
            mostrarNotificacion('exito', 'Se actualizaron los datos correctamente', 5000)
            cerrarModal()
            listarClientes()
        } else {
            mostrarNotificacion('alerta', 'Debe seleccionar una clasificación que los clientes tengan asignada.', 10000)
        }
    }
</script>