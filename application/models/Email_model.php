<?php
/**
 * Modelo encargado de gestionar los correos electrónicos
 * 
 * @author 		       John Arley Cano Salinas -johnarleycano@hotmail.com
 */
Class Email_model extends CI_Model{
	/*
     * Variables globales de configuración del correo
     */
	var $configuracion_local = array(
		'mailtype' => 'html',
		'charset' => 'utf-8',
		'newline' => "\r\n"
	);

	var $configuracion_web = array(
		'protocol' => 'IMAP',
		'smtp_host' => 'market-expert.net',
		'smtp_port' => 993,
		'smtp_user' => 'info',
		'smtp_pass' => 'm3-1nf0*.',
		'mailtype' => 'html',
		'charset' => 'utf-8',
		'newline' => "\r\n"
	);

    var $nombre = 'Market Experts';

    /**
     * Envío de correo electrónico
     * previamente formateado
     */
    function enviar_mensaje($asunto, $cuerpo, $destinatarios = array(), $adjuntos = null){
    	// Arreglo de destinatarios con copia
    	//$correos_cc = array();

    	// Si estamos en la app local
    	if (ENVIRONMENT == "development") {
    		//cargamos la configuración local para enviar con gmail
			$this->email->initialize($this->configuracion_local);

			// Destinatarios
			$email = "";
    	} else {
    		//cargamos la configuración local para enviar con gmail
			$this->email->initialize($this->configuracion_web);
			
			// Copia oculta a John
			//$this->email->bcc(array('johnarleycano@hotmail.com'));
			
			// Destinatarios
			$email = $destinatarios;
			
			// Correos con copia a 
    		//array_push($correos_cc, '');
    	}

    	// Correo del sistema
		$correo_sistema = 'info@market-expert.net';
	    
		// Preparando el mensaje
		$this->email->from($correo_sistema, $this->nombre); // Cabecera
		$this->email->to($email); // Destinatarios
		$this->email->subject($asunto); // Asunto
		//$this->email->cc($correos_cc); // Copia 
		// $this->email->set_crlf("\r\n"); 

        //Se organiza la plantilla
		$mensaje = file_get_contents('application/views/email/plantilla.php');
        $mensaje = str_replace('{CUERPO1}', $cuerpo[0], $mensaje);
        $mensaje = str_replace('{CUERPO2}', $cuerpo[1], $mensaje);
        $mensaje = str_replace('{CUERPO3}', $cuerpo[2], $mensaje);
		
		// Se envía el mensaje
		$this->email->message($mensaje);

        // Envío del mensaje
		$this->email->send();
		return $this->email->print_debugger();
    }
}
/* Fin del archivo email_model.php */
/* Ubicación: ./application/models/email_model.php */