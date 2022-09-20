<div class="modal-header">
    <h4 class="modal-title fw-bold">Crear registro</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <form class="row">
        <div class="col-12">
            <label for="clasificacion" class="form-label">Clasificación</label>
            <select id="clasificacion" class="form-select form-select-sm">
                <option selected disabled>Seleccione</option>
                <?php foreach ($this->configuracion_model->obtener('clientes_bitacora_clasificaciones') as $clasificacion) { ?>
                    <option value="<?php echo $clasificacion->id; ?>"><?php echo $clasificacion->nombre; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-12">
            <label for="descripcion" class="form-label">Observación</label>
            <textarea class="form-control form-control-lg" id="descripcion" rows="6"></textarea>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type='button' onClick='javascript:guardarBitacora()' class='btn btn-success'>Guardar</button>
</div>