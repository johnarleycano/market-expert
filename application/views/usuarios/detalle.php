<?php
if (isset($datos['id'])) {
    $usuario = $this->usuarios_model->obtener('usuarios', ['id' => $datos['id']]);
    echo "<input type='hidden' id='usuario_id' value='$usuario->id' />";
}
?>

<div class="modal-header">
    <h4 class="modal-title fw-bold">Usuario</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <form class="row">
        <div class="col-12">
            <label for="nombres" class="form-label">Nombres <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="nombres" value="<?php if (isset($usuario)) echo $usuario->nombres; ?>">
        </div>

        <div class="col-12">
            <label for="apellidos" class="form-label">Apellidos <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="apellidos" value="<?php if (isset($usuario)) echo $usuario->apellidos; ?>">
        </div>

        <div class="col-12">
            <label for="documento" class="form-label">Documento <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="documento" value="<?php if (isset($usuario)) echo $usuario->documento_numero; ?>">
        </div>

        <div class="col-12">
            <label for="email" class="form-label">Correo electrónico <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="email" value="<?php if (isset($usuario)) echo $usuario->email; ?>">
        </div>

        <div class="col-12">
            <label for="login" class="form-label">Nombre de usuario <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="login" value="<?php if (isset($usuario)) echo $usuario->login; ?>">
        </div>

        <div class="col-6">
            <label for="clave1" class="form-label">Clave <b class="text-danger">*</b></label>
            <input type="password" class="form-control" id="clave1">
        </div>

        <div class="col-6">
            <label for="clave2" class="form-label">Repita la clave <b class="text-danger">*</b></label>
            <input type="password" class="form-control" id="clave2">
        </div>

        <div class="col-12">
            <label for="estado" class="form-label">Estado <b class="text-danger">*</b></label>
            <select id="estado" class="form-select form-select-sm">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type='button' onClick='javascript:guardarUsuario()' class='btn btn-success'>Guardar</button>
</div>

<?php if (isset($usuario)) { ?>
    <script type="text/javascript">
        $().ready(() => {
            $('#estado').val(<?php echo $usuario->activo; ?>)
        })
    </script>
<?php } ?>

<script type="text/javascript">
    $().ready(() => {
        $("#estado").select2({
            dropdownParent: $('.modal .modal-body'),
            width: '100%',
            theme: 'bootstrap-5'
        })
    })
</script>