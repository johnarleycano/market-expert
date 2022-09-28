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
		'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_user' => 'johnarleycano',
        'smtp_pass' => 'icohttchuidoheoh',
        'smtp_port' => 465,
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n",
        'crlf' => "\r\n",
        'wordwrap' => TRUE
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

    var $nombre = 'Market Expert';

    /**
     * Envío de correo electrónico
     * previamente formateado
     */
    function enviar_mensaje($asunto, $cuerpo, $destinatarios = array()){
    	// Si estamos en la app local
    	if (ENVIRONMENT == "development") {
    		// Cargamos la configuración local para enviar con Gmail
			$this->email->initialize($this->configuracion_local);

			// Destinatarios
			$usuarios = ["johnarleycano@hotmail.com"];
    	} else {
    		//cargamos la configuración local para enviar con gmail
			$this->email->initialize($this->configuracion_web);
			
			// Destinatarios
			$usuarios = $destinatarios;
    	}

    	// Correo del sistema
		$correo_sistema = 'info@market-expert.net';
	    
		// Preparando el mensaje
		$this->email->from($correo_sistema, $this->nombre); // Cabecera
		$this->email->to($usuarios); // Destinatarios
		$this->email->subject($asunto); // Asunto

        // Se organiza la plantilla
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
/* Fin del archivo Email_model.php */
/* Ubicación: ./application/models/Email_model.php */