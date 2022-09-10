<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author: 	John Arley Cano Salinas
 * Fecha: 		8 de septiembre de 2022
 * Programa:  	Market Experts | Módulo de interfaces
 *            	Carga de las interfaces desde el backend al frontend
 * Email: 		johnarleycano@hotmail.com
 */
class Interfaces extends MY_Controller {
    function __construct() {
        parent::__construct();

        // // Roles
        // require('application/config/keycloak_roles.php');
        // $this->jwt = $this->verificar_sesion([Roles::ACCEDER]);

        $this->load->model([
            'clientes_model'
        ]);
    }

    function index() {
        // Si no es una petición Ajax, redirecciona al inicio
        if(!$this->input->is_ajax_request()) redirect('');
        
        // Captura de datos vía POST
        $datos = $this->input->post('datos');
        $this->data['datos'] = $datos;

        if($this->input->post('tipo') == 'modal') {
            $this->data['contenido_modal'] = $this->input->post('vista');
            $this->load->view('core/modal', $this->data);
        } else {
            $this->load->view($this->input->post('vista'), $this->data);
        }
    }

    function actualizar()
    {
        // Se obtienen los datos que llegan por POST
        $datos = json_decode($this->input->post('datos'), true);
        
        $id = $datos['id'];
        $tipo = $datos['tipo'];

        unset($datos['tipo']);
        unset($datos['id']);

        switch($tipo) {
            case 'clientes':
                $resultado = $this->clientes_model->actualizar($tipo, $id, $datos);
            break;
        }

        print json_encode($resultado);
    }

    function cargar_mas_datos()
    {
        // Si no es una petición Ajax, redirecciona al inicio
        if(!$this->input->is_ajax_request()) redirect('');

        $datos = $this->input->post('datos');
        $this->data['datos'] = $datos;
        $this->load->view("{$datos['vista']}/datos", $this->data);
    }

    function crear()
    {
        $datos = json_decode($this->input->post('datos'), true);
        $tipo = $datos['tipo'];
        $datos['fecha_creacion'] = date('Y-m-d H:i:s');
        $datos['usuario_id'] = $this->session->userdata('usuario_id');
        unset($datos['tipo']);
        unset($datos['id']);

        switch ($tipo) {
            case 'clientes':
                print json_encode(['resultado' => $this->clientes_model->crear($tipo, $datos)]);
            break;

            case 'clientes_bitacora':
                print json_encode(['resultado' => $this->clientes_model->crear($tipo, $datos)]);
            break;
        }
    }
}
/* Fin del archivo Interfaces.php */
/* Ubicación: ./application/controllers/Interfaces.php */