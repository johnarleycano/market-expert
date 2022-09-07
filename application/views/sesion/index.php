<div class="page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0" id="sesion">
        <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    <div class="brand-logo">
                        <img src="<?php echo base_url(); ?>images/logo.png" alt="logo">
                    </div>
                    
                    <h4>¿Hola! Bienvenido de nuevo</h4>
                    <h6 class="fw-light">Inicia sesión para comenzar</h6>
                    
                    <form class="pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="nombre_usuario" placeholder="Nombre de usuario">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-lg" id="clave" placeholder="Contraseña">
                        </div>
                        <div class="mt-3">
                            <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="INICIAR SESION">
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

            let nombreUsuario = $('#nombre_usuario')
            let clave = $('#clave')

            let campos = [
                nombreUsuario,
                clave,
            ]
            
            // Validación de campos obligatorios
			if (!validarCamposObligatorios(campos)) return false

            let datos = {
                tipo: 'usuario',
                login: $.trim(nombreUsuario.val()),
                clave: $.trim(clave.val()),
            }

            promesa("<?php echo site_url('sesion/obtener_datos'); ?>", datos)
            .then(usuario => {
                // Si no se encontró el usuario
                if(!usuario) {
                    mostrarNotificacion('alerta', 'El usuario y clave que has digitado no existen en la base de datos. Por favor verifica nuevamente o ponte en contacto con nuestro equipo', 10000)
                    return false
                }

                // Si el usuario está desactivado
                if(usuario.activo == 0) {
                    mostrarNotificacion('error', `El usuario ${nombreUsuario.val()} se encuentra desactivado. Por favor ponte en contacto con nuestro equipo`)
                    agregarLog(2, nombreUsuario.val())
                    return false
                }

                // Se genera el inicio de sesión
                promesa("<?php echo site_url('sesion/iniciar'); ?>", {id: usuario.id})
                .then(sesion => {
                    // Si tuvo éxito, se redirecciona
                    if(sesion) {
                        location.href = '<?php echo site_url(''); ?>'
                    }
                }).catch(error => console.error(error))
            }).catch(error => console.error(error))
        })
    })
</script>