<div class="card">
    <div class="card-body">
        <div id="datos">
            <?php $this->load->view('usuarios/datos', $this->data); ?>
        </div>

        <button class="btn btn-primary btn-block" onClick="javascript:cargarMasDatos('usuarios')" id="btn_mostrar_mas">Mostrar más</button>
    </div>
</div>