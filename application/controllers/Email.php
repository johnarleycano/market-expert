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
		$this->load->model(array("email_model","clientes_model"));
		$this->load->library(array('email'));
	}//Fin construct()

	function enviar(){
		
        // Datos recibidos por post
        $datos = json_decode($this->input->post('datos'), true);
        $tipo = json_decode($this->input->post('tipo'), true);

		// Suiche
		switch ($tipo) {
			case 'cliente':
				// $nombres = $datos['nombres'];
				// $pais = $datos['pais_id'];
				// $email = $datos['email'];
				// $telefono = $datos['telefono'];
				// $observaciones = $datos['observaciones'];

				$email = '';
				// Asunto
				$asunto = "Usuario creado";

				// Cuerpo del mensaje
				$mensaje1 = "Se creo el usuario en la página market experts con los siguientes datos:<br><br>";

				$mensaje2 = "<b>Se creo el usuario correctamente </b><br>";
				// $mensaje2 .= "<hr>";
				// $mensaje2 .= "<b>Pais: </b>$pais<br>";
				// $mensaje2 .= "<b>Correo: </b>$email<br>";
				// $mensaje2 .= "<b>Telefono: </b>$telefono<br><br>";
				// $mensaje2 .= "<hr>";
				// $mensaje2 .= "<b>Observaciones:</b>$observaciones<br><br>";

				$mensaje3 = "Market experts";
					
				// Si el entorno es de desarrollo
				if(ENVIRONMENT == "development") {
					$mensaje1 = "Market experts";

				}

				// Se envía el correo electrónico
				echo $this->email_model->enviar_mensaje($asunto, array($mensaje1, $mensaje2, $mensaje3),$email);
			break;
                 
        } // suiche
	}// enviar
} 
/* Fin del archivo email.php */
/* Ubicación: ./application/controllers/email.php */