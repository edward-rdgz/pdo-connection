<?php

require_once('connection.php');

class functions extends connection {
	
	public function show($sql) { // SIRVE PARA MOSTRAR REGISTROS GENERICOS
		try {
			$this->connect(); // CONECTA
			$res = $this->link->query($sql); // CONSULTA
			while($row = $res->fetch(PDO::FETCH_ASSOC)) { // RECORRE TODOS LOS REGISTROS
				$rows[] = $row; // ALMACENA LOS REGISTROS
			}
			$res->closeCursor(); // LIBERA MEMORIA
			$this->disconnect(); // DESCONECTA
			return $rows; // REGRESA O ENVIA LOS REGISTROS
		} catch(Exception $e) {
			echo "!Error¡: ".$e->getMessage(); // MESAJE DE ERROR
			continue; // CONTINUA EN CASO DE ERROR PARA NO DETENER LA APP
		}
	}
	
	public function generateXML($sql, $labelname, $filename) { // SIRVE PARA CREAR ARCHIVOS XML GENERICOS
		try {
			$src = $this->show($sql); // REGISTROS SQL
			$dataXML = '<?xml version="1.0" encoding="UTF-8"?><'.$labelname.'>'; // COMIENZO DEL ARCHIVO XML
			foreach($src as $data => $element) { // RECORRE
				$dataXML .= '<data>'; // ETIQUETA
				foreach($element as $tag => $value) { // RECORRE
					$dataXML .= '<'.$tag.'>'.$value.'</'.$tag.'>'; // ETIQUETAS DEL ARCHIVO XML
				}
				$dataXML .= '</data>';
			}
			$dataXML .= '</'.$labelname.'>'; // FIN DEL ARCHIVO XML
			file_put_contents($filename.'.xml', $dataXML); // CREACION DEL ARCHIVO XML
		} catch(Exception $e) {
			echo "!Error¡: ".$e->getMessage(); // MENSAJE DE ERROR
		}
	}
	
	public function email() {
		$to = "sergio199468@gmail.com";
		$folio = "YYHI7-GE";
		$email = "transito_municipal@segob.com.mx";
		
		$subject = "Notificación de transito"; // ASUNTO
		$header  = "From: ".$email." \r\n";
		$header .= "X-Mailer: PHP/".phpversion()." \r\n";
		$header .= "Mime-Version: 1.0 \r\n";
		$header .= "Content-Type: text/plain"; // ENCABEZADO CONCATENADO
		$msg = "El vehiculo con serie ".$folio." ha sido multado"."\r\n";
		$msg .= "Correo Oficial Transito Municipal: ".$email."\r\n";
		if(mail($to, $subject, utf8_decode($msg), $header)) { // VALIDACIÓN DEL CORREO
			echo "correcto";

		}
	}
	
}

?>