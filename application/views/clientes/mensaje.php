<?php
$cliente = $this->clientes_model->obtener('clientes', ['id' => $datos['cliente_id']]);
echo "<input type='hidden' id='cliente_id' value='$cliente->id' />";
?>

<div class="modal-header">
    <h5 class="modal-title">Nuevo mensaje para <?php echo $cliente->nombres; ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <form class="row">
        <div class="col-12 col-md-12 col-lg-12 form-group">
            <label for="nuevo_mensaje" class="form-label">Mensaje <b class="text-danger">*</b></label>
            <textarea class="form-control form-control-lg" id="nuevo_mensaje" rows="10"></textarea>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-primary" onClick="javascript:enviarMensajeCorreo()">Enviar</button>
</div>

<script type="text/javascript">
    enviarMensajeCorreo = async () => {
        const clienteId = $('#cliente_id').val()
        let camposObligatorios = [$('#nuevo_mensaje')]

        // Se validan los datos obligatorios
        if (!validarCamposObligatorios(camposObligatorios)) return false

        let datos = {
            id: clienteId,
            mensaje: $('#nuevo_mensaje').val()
        }

        // Se realiza el envio del correo con el mensaje
        enviarEmail('mensaje', datos)
        mostrarNotificacion('exito', 'El mensaje se ha enviado correctamente', 10000) 
    }
</script>