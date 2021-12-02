<?php

class ContatoModel extends Model{
	
	public $table   = 'fn_contato';
	public $idField = 'id_fini_contato';


	public function validateFields(){
		if(count($this->getArrayData())){
			$errorsFields = [];
			$dataValues = $this->getArrayData();
			foreach ($dataValues as $key => &$value) {
				if($value == ""){
					$errorsFields[] = $key;
				}	
				if($key == "cpf" && !validaCpf(preg_replace('/[^0-9]/i', '',$value))){
					$errorsFields[] = "cpf inválido";
				}
				if($key == "email" && !validaEmail($value)){
					$errorsFields[] = "email inválido";
				}
			}				
			return count($errorsFields) == 0 ? false : $errorsFields;  
		}
		return false;
	}
	

	public static function sendEmail($contato){
		$SsxMail = new SsxMail();
		$dados_template = $contato->getArrayData();
		$body = $SsxMail->emailRenderer("contato.mail",$dados_template,false);
		$mail = new PHPMailer();
		$mail->CharSet   = PHPMAILER_CHARSET;
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = PHPMAILER_HOST;
		$mail->SMTPDebug  = PHPMAILER_DEBUG;                     // enables SMTP debug information (for testing)
		$mail->SMTPSecure = PHPMAILER_SMTPSECURE;                 // sets the prefix to the servier
		$mail->SMTPAuth = PHPMAILER_SMTPAUTH;
		$mail->Port       = PHPMAILER_PORT;                   // set the SMTP port for the GMAIL server
		$mail->Username   = PHPMAILER_USERNAME;
		$mail->Password   = PHPMAILER_PASSWORD;
		$mail->SetFrom(EMAILCONTATO,NOMECONTATO);// Mandado Por
		$mail->Subject    = ASSUNTOCONTATO;
		//$mail->AltBody    = ""; // optional, comment out and test
		$mail->MsgHTML($body); // mandar o corpo da mensagem
		$mail->AddAddress(EMAILCONTATO,NOMECONTATO); //Setar email que vai ser enviado a mensagem
		if(!$mail->Send()){
			return false;
		}else{
			return true;
		}
	}
	
}
