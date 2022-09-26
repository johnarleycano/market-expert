<?php
if (isset($datos['id'])) {
    $cliente = $this->clientes_model->obtener('clientes', ['id' => $datos['id']]);
    echo "<input type='hidden' id='cliente_id' value='$cliente->id' />";
}
?>

<div class="modal-header">
    <h4 class="modal-title fw-bold">Cliente</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <form class="row">
        <div class="col-12">
            <label for="nombres" class="form-label">Nombres <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="nombres" value="<?php if (isset($cliente)) echo $cliente->nombres; ?>">
        </div>

        <div class="col-12">
            <label for="pais" class="form-label">País <b class="text-danger">*</b></label>
            <select id="pais" class="form-select form-select-sm">
                <option selected disabled>Seleccione</option>
                <?php foreach ($this->configuracion_model->obtener('paises') as $pais) { ?>
                    <option value="<?php echo $pais->id; ?>"><?php echo $pais->nombre; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-12">
            <label for="email" class="form-label">Correo electrónico <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="email" value="<?php if (isset($cliente)) echo $cliente->email; ?>">
        </div>

        <div class="col-12">
            <label for="telefono" class="form-label">Teléfono <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="telefono" value="<?php if (isset($cliente)) echo $cliente->telefono; ?>">
        </div>

        <div class="col-12">
            <label for="usuario_asignado" class="form-label">Usuario asignado <b class="text-danger">*</b></label>
            <select id="usuario_asignado" class="form-select form-select-sm">
                <option selected disabled>Seleccione</option>
                <?php foreach ($this->usuarios_model->obtener('usuarios') as $usuario) { ?>
                    <option value="<?php echo $usuario->id; ?>"><?php echo "$usuario->nombres $usuario->apellidos"; ?></option>
                <?php } ?>
            </select>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type='button' onClick='javascript:guardarCliente()' class='btn btn-success'>Guardar</button>
</div>

<?php if (isset($cliente)) { ?>
    <script type="text/javascript">
        $().ready(() => {
            $('#pais').val(<?php echo $cliente->pais_id; ?>)
            $('#usuario_asignado').val(<?php echo $cliente->usuario_asignado_id; ?>)
        })
    </script>
<?php } ?>

<script type="text/javascript">
    $().ready(() => {
        $("#pais").select2({
            dropdownParent: $('.modal .modal-body'),
            width: '100%',
            theme: 'bootstrap-5'
        })
    })
</script>

