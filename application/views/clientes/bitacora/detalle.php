<div class="modal-header">
    <h4 class="modal-title fw-bold">Crear registro</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <form class="row">
        <div class="col-12">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control form-control-lg" id="descripcion" rows="6"></textarea>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type='button' onClick='javascript:guardarBitacora()' class='btn btn-success'>Guardar</button>
</div>