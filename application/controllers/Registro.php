<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends MY_Controller {
    /**
     * Función constructora de la clase. Se hereda el mismo constructor 
     * de la clase para evitar sobreescribirlo y de esa manera 
     * conservar el funcionamiento de controlador.
     */
    function __construct() {
        parent::__construct();

        // Carga de modelos
        $this->load->model(['configuracion_model','clientes_model']);
    }

    public function index()
	{
        $this->data['datos'] = [
            'titulo' => 'Registro',
            'subtitulo' => 'Iniciar',
            'descripcion' => 'Registro de la aplicación',
        ];
        $this->data['contenido_principal'] = 'registro/index';
        $this->load->view('core/template', $this->data);
	}

    function crear()
    {
        $tipo = 'clientes';
        $datos = json_decode($this->input->post('datos'), true);
        $datos['fecha_creacion'] = date('Y-m-d H:i:s');
        unset($datos['tipo']);

        print json_encode(['resultado' => $this->clientes_model->crear($tipo,$datos)]);
    }
}/* Fin del archivo Registro.php */
/* Ubicación: ./application/controllers/Registro.php */