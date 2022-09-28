<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

//Si se intenta hacer acceso indebido
if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

Class Email extends CI_Controller{
	/**
	 * Constructora de la clase
	 */
	function __construct() {
		parent::__construct();

		//Carga de modelos y librerías
		$this->load->model(array("email_model", "clientes_model"));
		$this->load->library(array('email'));
	}

	function enviar() {
        // Datos recibidos por post
        $id = $this->input->post('id');
        $tipo = $this->input->post('tipo');

		// Suiche
		switch ($tipo) {
			case 'registro_cliente':
				$cliente = $this->clientes_model->obtener('clientes', ['id' => $id]);

				// Asunto
				$asunto = "Registro exitoso";

				// Cuerpo del mensaje
				$mensaje1 = "Tu registro en Market Expert ha sido exitoso<br><br>";
				$mensaje2 = "<hr>";
				$mensaje3 = "Market expert";
					
				// Se envía el correo electrónico
				echo $this->email_model->enviar_mensaje($asunto, array($mensaje1, $mensaje2, $mensaje3), $cliente->email);
			break;
        }
	}
} 
/* Fin del archivo email.php */
/* Ubicación: ./application/controllers/email.php */