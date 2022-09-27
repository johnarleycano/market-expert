<div class="page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0" id="registro">
        <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    <div class="brand-logo">
                        <img src="<?php echo base_url(); ?>images/logo.png" alt="logo">
                    </div>

                    <h4>Regístrese ahora</h4>
                    <form class="pt-3" id="form">
                        <div class="col-12">
                            <label for="nombre_cliente" class="form-label">Nombres <b class="text-danger">*</b></label>
                            <input type="text" class="form-control" id="nombre_cliente" placeholder="Nombre completo">
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
                            <input type="text" class="form-control" id="email" placeholder="Correo">
                        </div>
                        <div class="col-12">
                            <label for="telefono" class="form-label">Teléfono <b class="text-danger">*</b></label>
                            <input type="text" class="form-control" id="telefono" placeholder="Teléfono">
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label" for="observaciones">Observaciones</label>
                            <textarea id="observaciones" class="form-control" rows="5" placeholder="Observaciones"></textarea>
                        </div>
                        <div class="mt-3">
                            <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="REGISTRARSE">
                        </div>
                        <div class="mt-3">
                            <h6>¿Ya estás registrado?<a href="<?php echo site_url('sesion'); ?>" style="text-decoration:none"> Inicia sesión</a></h6>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $().ready(() => {
        $('form').submit(e => {
            e.preventDefault()

            let nombreCliente = $('#nombre_cliente')
            let pais = $('#pais')
            let email = $('#email')
            let telefono = $('#telefono')
            let observaciones = $('#observaciones')

            let campos = [
                nombreCliente,
                pais,
                email,
                telefono,
            ]
            
            // Validación de campos obligatorios
			if (!validarCamposObligatorios(campos)) return false

            let datos = {
                tipo: 'cliente',
                nombres: nombreCliente.val(),
                pais_id: pais.val(),
                email: email.val(),
                telefono: telefono.val(),
                observaciones: observaciones.val(),
                registro_web: 1,
            }

            // Se genera el registro
            promesa("<?php echo site_url('registro/crear'); ?>", datos)
            .then(cliente => {
                if(cliente) {
                    let formulario = document.getElementById('form');

                    promesa("<?php echo site_url('email/enviar'); ?>", datos)
                    mostrarNotificacion('exito', 'El registro se creó correctamente', 10000) 
                    formulario.reset();
                }
            }).catch(error => console.error(error)) 
        })
    })
</script>