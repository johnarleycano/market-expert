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
            'clientes_model',
            'usuarios_model'
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

            case 'usuarios':
                $nombre_usuario = $datos['login'];
                $clave = $datos['clave'];
                $clave_encriptada = $this->gestionar_clave('encriptacion', $nombre_usuario, $clave);

                // Si no trae clave para cambiar
                if ($datos["clave"] == "0") {
                    // Se elimina el campo del arreglo
                    unset($datos["clave"]);
                }else{
                    // Se encripta la clave
                    $datos["clave"] = $clave_encriptada;

                    // Se cambia la clave en la sesión
                    $this->session->set_userdata('clave', $clave_encriptada);
                }
                $resultado = $this->usuarios_model->actualizar($tipo, $id, $datos);
            break;
        }

        print json_encode($resultado);
    }

    function cambiar_clasificacion_clientes()
    {
        // Se obtienen los datos que llegan por POST
        $datos = json_decode($this->input->post('datos'), true);

        $nuevas_clasificaciones = [];
        $usuarios_asignados = [];
        $respuesta = [];

        // Se obtienen los clientes con la clasificación anterior seleccionada
        $clientes = $this->clientes_model->obtener('clientes', ['id_clasificacion' => $datos['clasificacion_anterior']]);

        // Si hay clientes
        if ($clientes) {
            foreach ($clientes as $cliente) {
                // Se agrega la nueva clasificación
                array_push($nuevas_clasificaciones, [
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'cliente_id' => $cliente->id,
                    'cliente_bitacora_clasificacion_id' => $datos['clasificacion_nueva'],
                    'usuario_id' => $this->session->userdata('usuario_id')
                ]);

                array_push($usuarios_asignados, [
                    'id' => $cliente->id,
                    'usuario_asignado_id' => $datos['usuario_asignado']
                ]);
            }

            $respuesta['clasificaciones'] = $this->clientes_model->crear('clientes_bitacoras_clasificaciones', $nuevas_clasificaciones);
            $respuesta['clientes'] = $this->clientes_model->actualizar('asignar_usuarios_clientes', 'id', $usuarios_asignados);
        } else {
            $respuesta['clasificaciones'] = 0;
            $respuesta['clientes'] = 0;
        }

        print json_encode($respuesta);
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

            case 'usuarios':
                $nombre_usuario = $datos['login'];
                $clave = $datos['clave'];
                $clave_encriptada = $this->gestionar_clave('encriptacion', $nombre_usuario, $clave);
                $datos["clave"] = $clave_encriptada;

                unset($datos['usuario_id']);
                print json_encode(['resultado' => $this->usuarios_model->crear($tipo, $datos)]);
            break;
        }
    }
}
/* Fin del archivo Interfaces.php */
/* Ubicación: ./application/controllers/Interfaces.php */