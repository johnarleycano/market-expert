<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author: 	John Arley Cano Salinas
 * Fecha: 		6 de septiembre de 2022
 * Programa:  	Market Experts | Módulo de Sesión
 *            	Gestiona la sesión y roles de los usuarios
 *              del sistema
 * Email: 		johnarleycano@hotmail.com
 */
class Sesion extends MY_Controller {
    /**
     * Función constructora de la clase. Se hereda el mismo constructor 
     * de la clase para evitar sobreescribirlo y de esa manera 
     * conservar el funcionamiento de controlador.
     */
    function __construct() {
        parent::__construct();

        // Carga de modelos
        $this->load->model(['configuracion_model']);
    }

    public function index()
	{
        $this->data['datos'] = [
            'titulo' => 'Sesión',
            'subtitulo' => 'Iniciar',
            'descripcion' => 'Login de la aplicación',
        ];
        $this->data['contenido_principal'] = 'sesion/index';
        $this->load->view('core/template', $this->data);
	}

    function cerrar()
	{
		// Se destruye la sesión actual
        $this->session->sess_destroy();

        // Se redirige hacia el controlador de sesión
        redirect(site_url('sesion'));
	}

    function iniciar()
	{
        // Se obtienen los datos que llegan por POST
        $datos = json_decode($this->input->post('datos'), true);

		// Se consultan los datos del usuario
		$usuario = $this->configuracion_model->obtener('usuario', ['id' => $datos['id']]);

        // Se arma un arreglo con los datos de sesion que va a mantener
		$datos = [
			'usuario_id' => $usuario->id,
			'estado' => $usuario->activo,
			'nombres' => $usuario->nombres,
			'apellidos' => $usuario->apellidos,
			'administrador' => $usuario->administrador,
			// 'perfil' => $usuario->perfil,
		];

        // Se inicia la sesión
        $this->session->set_userdata($datos);

		// Se cargan los datos a la sesión
        print json_encode($this->session->userdata());
	}

    function obtener_datos()
    {
        // Se obtienen los datos que llegan por POST
        $datos = json_decode($this->input->post('datos'), true);

        switch($datos['tipo']) {
            case 'usuario':
                $nombre_usuario = $datos['login'];
                $clave = $datos['clave'];
                $clave_encriptada = $this->gestionar_clave('encriptacion', $nombre_usuario, $clave);

                $resultado = $this->configuracion_model->obtener('usuario', ['login' => $nombre_usuario, 'clave' => $clave_encriptada]);
            break;
        }

        print json_encode($resultado);
    }
}
/* Fin del archivo Sesion.php */
/* Ubicación: ./application/controllers/Sesion.php */