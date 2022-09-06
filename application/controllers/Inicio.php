<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author: 	John Arley Cano Salinas
 * Fecha: 		5 de septiembre de 2022
 * Programa:  	Market Experts | Módulo de Inicio
 *            	Gestión del inicio del sistema
 * Email: 		johnarleycano@hotmail.com
 */
class Inicio extends MY_Controller {
    /**
     * Función constructora de la clase. Se hereda el mismo constructor 
     * de la clase para evitar sobreescribirlo y de esa manera 
     * conservar el funcionamiento de controlador.
     */
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['datos'] = [
            'titulo' => 'Inicio',
            'subtitulo' => 'Gestión',
            'descripcion' => 'Interfaz inicial del sistema',
        ];
        $this->data['contenido_principal'] = 'inicio/index';
        $this->load->view('core/template', $this->data);
    }
}