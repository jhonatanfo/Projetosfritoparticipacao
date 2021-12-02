<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

class SsxMail
{
	/**
	 * Objeto de envio de email da classe PHPMailer
	 * @var PHPMailer
	 */
	public $mail;
	
	public function __construct(){ $this->super(); }
	/**
	 * Metodo chamado pelos contrutores para instanciar o objeto PHPMailer
	 */
	public function super()
	{

		// require_once(RESOURCEPATH . "phpmailer/phpmailer.php");
		require_once(RESOURCEPATH . "phpmailerV5/PHPMailerAutoload.php");
		
		$this->mail = new PHPMailer();
	}
	
	/**
	 * Configura um envio de email simples
	 * Com conteúdo html
	 */
	public function isEmail()
	{
		$this->mail->IsHTML(true);
		$this->mail->IsMail();
	}
	
	/**
	 * Configura um envio de email apartir de dados smtp
	 * @param string $user
	 * @param string $pass
	 * @param string $host
	 * @param string $port
	 * @param string $con_prefix Options are "", "ssl" or "tls"
	 */
	public function isSmtp($user, $pass, $host, $port, $con_prefix="tls")
	{
		
		$this->mail->Username = $user;
		$this->mail->Password = $pass;
		$this->mail->Port = $port;
		$this->mail->Host = $host;
		
		$this->mail->IsSMTP();
		$this->mail->IsHTML(true);
		$this->mail->SMTPAuth = true;
		$this->mail->SMTPSecure = $con_prefix;
		
	}
	
	/**
	 * COnfigura um envio de email simples apartir de dados basicos como de quem (from) para quem (addresses)
	 * @param array $args
	 * @example 
	 * array(
	 * 		'from'=>array('email'=>'example@test.com', 'name'=>'example'),
	 * 		'subject'=>'Teste',
	 * 		'body'=>'<p>Olá email</p>',
	 * 		'addresses' => array(
	 * 			array('email' => 'example@test.com', 'name'=>'example'),
	 * 			array('email' => 'example2@test.com', 'name'=>'example2')
	 * 		)
	 * );
	 */
	public function SimpleSend($args)
	{
		/**
		 * configs
		 */
		$email_type = SsxConfig::get(SsxConfig::SSX_USE_STMP);
		if($email_type === "1")
		{
			$smtp_data = SsxConfig::get(SsxConfig::SSX_SMTP_DATA,'json');
			if($smtp_data)
			{
				$this->isSmtp($smtp_data['user'],$smtp_data['pass'],$smtp_data['host'], $smtp_data['port'],$smtp_data['prefix']);
			}
		}else{
			$this->isEmail();
		}
		
		if(is_array($args))
		{
			if(isset($args['from']) && $args['from'])
			{
				$fromData = $args['from'];
				if($fromData)
				{
					$this->mail->From = isset($fromData['email']) && $fromData['email']?$fromData['email']:"";
					$this->mail->FromName = isset($fromData['name']) && $fromData['name']?$fromData['name']:"";
				}
			}
			
			if(isset($args['subject']) && $args['subject'])
				$this->mail->Subject = $args['subject'];
		
			
			if(isset($args['body']) && $args['body'])
				$this->mail->Body = $args['body'];

				
			if(isset($args['address']) && $args['address'])
			{
				$addressData = $args['address'];
				if($addressData)
				{
					$this->mail->AddAddress(
						isset($addressData['email']) && $addressData['email']?$addressData['email']:"",
						isset($addressData['name']) && $addressData['name']?$addressData['name']:""
					);
				}
			}elseif(isset($args['addresses']) && $args['addresses'])
			{
				if(is_array($args['addresses']))
				{
					foreach($args['addresses'] as $address)
					{
						$this->mail->AddAddress($address['email'], $address['name']);
					}
				}
			}
		}
			
		if($this->mail->Send())
			return true;
		return false;
	}
	
	public function emailRenderer($file_name, $args=null, $setToBody=true)
	{
		if(!is_string($file_name))
			return false;

		$source = PROJECTPATH . "files/";
		
		if(!file_exists($source . $file_name))
			return false;
			
		$pointer = @fopen($source . $file_name, "r");
		if(!$pointer)
			return false;
			
		$content = "";
		while (!feof($pointer))
	    {
	        $content .= fgets($pointer, 4096);
	    }
	   
	    fclose($pointer);
	    
	    if($args && is_array($args))
	    {
	    	foreach($args as $variable => $value)
	    	{
	    		$rel = '(\\{\\$'.$variable.'\\})';
	    		$content = preg_replace("/".$rel."/is", $value, $content);
	    	}
	    }
	    
	    if($setToBody)
	    	$this->mail->Body = $content;
	    else
	    	return $content;
	}
	
	public function clear()
	{
		$this->mail->ClearAllRecipients();	
		$this->mail->ClearAttachments();
	}
}