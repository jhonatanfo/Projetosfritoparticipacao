<?php

class UsuarioModel extends Model{	 	

	private static $connection;

	public  $idField = "id_fini_usuario";
	public  $table   = "fn_usuario";
	public $logTimestampOnUpdate = true;

	
	public static $order_fields = Array(
							'id_fini_usuario' => "ID",
							'nome' => "Nome",
							'sobrenome' => "Sobrenome",
							'cpf' => "Cpf",
							'telefone' => "Telefone",
							'rg' => "Rg",
							'email' => "Email",
							'cep' => "Cep",
							'logradouro' => "Endereço",
							'bairro' => "Bairro",
							'cidade' => "Cidade",
							'uf' => "Estado",
							'termos' => "Termos",
							'newsletter' => "Newsletter",
							'data_criacao' => "Data Cadastro",
							'tot_not' => "Total NF",
						);	

	public static $find_fields = Array(
							'id_fini_usuario' => "ID",
							'nome' => "Nome",
							'sobrenome' => "Sobrenome",
							'rg' => "Rg",
							'cpf' => "Cpf",
							'telefone' => "Telefone",
							'email' => "Email",
							'cep' => "Cep",
							'logradouro' => "Endereço",
							'bairro' => "Bairro",
							'cidade' => "Cidade",
							'uf' => "Estado",
							'termos' => "Termos",
							'newsletter' => "Newsletter",
							'data_criacao' => "Data Cadastro",
						);

	public 	$hasNext  = true;
	public 	$isNext   = false;
	public 	$rowCount = 0;
	

	public function validateFields($alterar_dados=false){
		if(count($this->getArrayData())){
			$errorsFields = [];
			$notRequiredFields = array(
										'telefone','complemento','newsletter','conf_senha','facebook_login','google_login','senha'
									   );
			if($alterar_dados){
				array_push($notRequiredFields,'cpf');
			}
			$dataValues = $this->getArrayData();
			foreach ($dataValues as $key => &$value) {
				if(!in_array($key,$notRequiredFields) &&  $value == ""){
					switch ($key) {
						case 'data_nascimento':
							$key = 'data nascimento';
							break;
						case 'logradouro':
							$key = 'endereço';
							break;
						case 'uf':
							$key = 'estado';
							break;
						case 'numero':
							$key = 'número';
							break;
						case 'conf_senha':
							$key = 'Confirma Senha';
							break;
						default:
							break;
					}
					$errorsFields[] = $key;
				}
				if($key == "email" && !validaEmail($value) || $key == "email" && UsuarioModel::where('email',$value) ){
					$errorsFields[] = "email inválido";
				}
				if($key == "cpf" && !validaCpf(preg_replace('/[^0-9]/i', '',$value)) || $key == "cpf" && UsuarioModel::where('cpf',$value)){
					if($alterar_dados==false){
						$errorsFields[] = "cpf inválido";			
					}					
				}
				if($key == "data_nascimento" && geraIdade(POST::field('data_nascimento')) < 15){ // IMPORTANTE. IDADE MÍNIMA PARA PARTICIPAÇÃO 15 ANOS.
					$errorsFields[] = "data nascimento inválida!";
				}
				if($key == "senha" && $value != $dataValues['conf_senha']){
					$errorsFields[] = "senha(s) divergentes!";	
				}
			}			
			return count($errorsFields) == 0 ? true : $errorsFields;
		}
		return false;
	}	

	public static function authenticateLogin($login, $senha){
		if($login && $senha){
			$class = get_called_class();
			$self  = new $class();
			$senha = self::generatePassword($login,$senha);
			$sql = sprintf("SELECT 
							id_fini_usuario as id 
							FROM %s 
							WHERE (cpf = '%s' AND senha = '%s') OR (cpf = '%s' AND senha_tmp = '%s')",
							$self->table,
							$login,$senha,
							$login,$senha);
			$dbn = DatabaseConnection::getInstance();
			$result = $dbn->query($sql);
			$usuario = $result->fetchObject($class);			
			if($usuario){
				return self::startSessionLogin($usuario->id);
			}else{
				return false;
			}
		}
		return false;
	}

	public static function startSessionLogin($id){
		if(!session_id()){
			session_start();
		}
		$_SESSION['userId'] = $id;
		return true;
	}

	public static function getSessionLogin(){
		if(!session_id()){
			session_start();
		}
		if(isset($_SESSION['userId'])){
			return array('userId'=>$_SESSION['userId']);
		}	
		return false;	
	}

	public static function dropSessionLogin($usuario){
		if(!session_id()){
			session_start();
		}
		if(GoogleModel::getToken() || GoogleModel::getLogin()){
			GoogleModel::logout();
		}
		if(FacebookModel::getToken() || FacebookModel::getLogin()){
			FacebookModel::logout();
		}
		if(isset($_SESSION['userId'])){
			unset($_SESSION['userId']);
			return true;
		}

		return false;
	}

	public static function hasSessionLoginFromSocialNetworkActive(){
		return GoogleModel::getLogin() || FacebookModel::getLogin() ? true : false;
	}

	public static function generatePassword($login,$senha){
		return md5($login.md5($senha));
	}

	public static function replaceFields($usuarios){
		if(is_array($usuarios)){
			foreach ($usuarios as &$usuario) {
				$totalNf = NotaFiscalModel::where('id_rel_usuario',$usuario->{'id_fini_usuario'});
				$usuario->{'total_nf'} = is_array($totalNf) ? count($totalNf) : false;
				$usuario->{'data_nascimento'} = date_format(date_create($usuario->{'data_nascimento'}),'d/m/Y');
				$usuario->{'termos'} = $usuario->{'termos'} == "SIM" ? "Sim" : "Não";
				$usuario->{'newsletter'} = $usuario->{'newsletter'} == "SIM" ? "Sim" : "Não";
				$usuario->{'data_criacao'} = date_format(date_create($usuario->{'data_criacao'}),'d/m/Y H:i:s');
				$usuario->{'data_alteracao'} = $usuario->{'data_alteracao'} ?  date_format(date_create($usuario->{'data_alteracao'}),'d/m/Y H:i:s') : "--";
			}	
		}elseif(is_object($usuarios)){
			$usuario = $usuarios;
			$totalNf = NotaFiscalModel::where('id_rel_usuario',$usuario->{'id_fini_usuario'});
			$usuario->{'total_nf'} = is_array($totalNf) ? count($totalNf) : false;
			$usuario->{'data_nascimento'} = date_format(date_create($usuario->{'data_nascimento'}),'d/m/Y');
			$usuario->{'data_criacao'} = date_format(date_create($usuario->{'data_criacao'}),'d/m/Y H:i:s');
			$usuario->{'data_alteracao'} = $usuario->{'data_alteracao'} ?  date_format(date_create($usuario->{'data_alteracao'}),'d/m/Y H:i:s') : "--";
			$usuarios = $usuario;
		}else{
			return false;
		}

		return $usuarios;
	}	
	
	public static function search($limit = 30 ,$offset = 0,$orderBy="id_fini_usuario",$orderBySide="ASC",$where = null){
		
		$class = get_called_class();
		$self = new $class();
		
		$sql = sprintf("SELECT 
						*,
						DATE_FORMAT(data_nascimento,'%s')as data_nascimento,
						IF(termos = 'SIM','Sim','Não')as termos,
						IF(newsletter = 'SIM','Sim','Não')as newsletter,
						CAST( IF(nf.tot_not IS NULL,'0',nf.tot_not) AS UNSIGNED)as tot_not,
						DATE_FORMAT(data_criacao,'%s')as data_criacao,
						IF(data_alteracao IS NOT NULL, DATE_FORMAT(data_alteracao,'%s'),'--') as data_alteracao
						FROM %s as u
						LEFT JOIN (
							SELECT COUNT(*) AS tot_not,id_rel_usuario as id_u
							FROM fn_nota_fiscal
							GROUP BY id_rel_usuario
						) AS nf ON nf.id_u = u.id_fini_usuario
						%s
						%s",				
								'%d/%m/%Y',
								'%d/%m/%Y %H:%i:%s',
								'%d/%m/%Y %H:%i:%s',
								$self->table,
								$where       ? sprintf("WHERE %s", $where->get()) : "",
								$orderBy     ? sprintf("ORDER BY %s %s", $orderBy,$orderBySide) : "" 
						);
		
		$dbn = DatabaseConnection::getInstance();
			
		$q = $dbn->prepare($sql);
		$q->execute();
		$self->{'rowCount'} = $q->rowCount();

		if($limit){
			$sql = sprintf("%s %s %s",
									$sql,
									sprintf("LIMIT %s",  $limit),
									sprintf("OFFSET %s", $offset)
						   );
		}	
				
		$q = $dbn->prepare($sql);
		$q->execute();		
		$usuarios = $q->fetchAll(PDO::FETCH_CLASS,$class);
		$newUsuarios = [];
		if(is_array($usuarios)){
			foreach ($usuarios as &$usuario) {
				$usuario->{'id_usuario'} = $usuario->{'id_fini_usuario'};
				unset($usuario->{'id_u'});
				unset($usuario->{'senha'});
				unset($usuario->{'senha_tmp'});
				$newUsuarios[] = $usuario->getArrayData();
			}
		}

		if( ($limit+$offset) >= $self->{'rowCount'}){
			$self->{'hasNext'} = false;
		}

		if($offset >= 1){
			$self->{'isNext'} = true;
		}

		if(is_array($newUsuarios) && !empty($newUsuarios)){
	      return array(
	      				'success' => true,
            			'page'=>$offset,
            			'dados' => $newUsuarios,
            			'rowCount'=>$self->{'rowCount'},
            			'hasNext'=>$self->{'hasNext'},
            			'isNext'=>$self->{'isNext'}
          );
	    }else{
	    	return array(
	    				"success"=>false,
	    				'page'=>$offset,
	    				'dados'=>$newUsuarios,
	    				'rowCount'=>$self->{'rowCount'},
	    				'hasNext'=>$self->{'hasNext'},
	    				'isNext'=>$self->{'isNext'}
	    			);
	    }
	    
	}
	
	
	public static function orderFields(){
		$class = get_called_class();
		return $class::$order_fields;
	}

	public static function findFields(){
		$class = get_called_class();
		return $class::$find_fields;
	}

	public static function sendEmailForgotPassword($usuario){
		$usuario->{'link'} = SITEURL;
		$SsxMail = new SsxMail();
		$dados_template = $usuario->getArrayData();
		$body = $SsxMail->emailRenderer("esqueci-minha-senha.mail",$dados_template,false);
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
		$mail->AddAddress($usuario->{'email'},sprintf("%s %s",$usuario->{'nome'},$usuario->{'sobrenome'})); //Setar email que vai ser enviado a mensagem
		if(!$mail->Send()){
			return false;
		}else{
			return true;
		}
	}

	public static function generateTmpPasswordAndSaveAndSendEmail($usuario){
		$senha_tmp = substr(md5(rand(0, 1000000)), 0, 8);
		$usuario->{'senha_tmp'} = UsuarioModel::generatePassword($usuario->{'cpf'},$senha_tmp);
		$usuario->save();
		$usuario->{'senha_tmp'} = $senha_tmp;
		return UsuarioModel::sendEmailForgotPassword($usuario);
	}

	public static function checkIsGuestUser(UsuarioModel $usuario,$emailAmigo=null){
		if($emailAmigo){
			$amigo = AmigoUSuarioModel::where('email_amigo',$usuario->{'email'});
			if(is_array($amigo)){
				$amigo = $amigo[0];
				$amigo->{'id_amigo'} = $usuario->{'id_fini_usuario'};
				$amigo->{'status'} = 'AMIGO_SE_CADASTROU';
				if($amigo->save()){
					return " <br> Parabéns seu amigo pode ganhar um código que vale R$5,00 no Applicativo da Uber.";
				}
				return "";
			}
			return "";	
		}
		return "";
	}


	public static function exportarUsuarios(){

		$titleSheet = "Usuários";
		$header = array('Nome','Sobrenome','Email','CPF','Sexo','Data Nascimento','Telefone','Celular',
						'Cep','Endereço','Número','Complemento','Bairro','Cidade','UF',
						'Termos','Newsletter','Data Cadastro','Data Alteração','Total NF Cadastradas');
		$dados = UsuarioModel::allToRelatorio();
		foreach ($dados as &$dado) {
			$dado = $dado->getArrayData();
		}		
		$infoSheet = array(
						"creator" => "Promoção Partiu Viajar Com Grupy Kids",
						"lastModifiedBy" => "Promoção Partiu Viajar Com Grupy Kids",
						"title" => "Promoção Partiu Viajar Com Grupy Kids - Planilha Usuários",
						"subject" => "Planilha Usuários",
						"description" => "Planilha de relátorios dos cadastros de usuários.",
						"keywords" => "nazca viaja prêmio promoção",
						"category" => "Promoção",
						"filename" => "relatorio_usuarios_promocao_partiu_viaja_com_grupy_kids"
					   );

		Excel::renderSimpleSheet($titleSheet,$header,$dados,$infoSheet,$extension="xlsx");

	}

	public static function allToRelatorio(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT 
						nome,sobrenome,email,cpf,IF(sexo = 'masculino','M','F'),DATE_FORMAT(data_nascimento,'%s'),
						telefone,celular,
						cep,logradouro,numero,IF(complemento != '', complemento,'--'),bairro,cidade,
						uf,
						IF(termos = 'SIM','Sim','Não'),IF(newsletter = 'SIM','Sim','Não'),DATE_FORMAT(data_criacao,'%s'),
						IF(data_alteracao IS NOT NULL,DATE_FORMAT(data_alteracao,'%s') ,'--'),
						IF(nf.total IS NOT NULL,nf.total,0)
						FROM %s u
						LEFT JOIN (
							SELECT COUNT(*) AS total, 
							id_rel_usuario
							FROM fn_nota_fiscal
							GROUP BY id_rel_usuario
						) AS nf ON nf.id_rel_usuario = u.id_fini_usuario
						ORDER BY u.id_fini_usuario ASC",
						"%d/%m/%Y",
						"%d/%m/%Y %H:%i:%s",
						"%d/%m/%Y %H:%i:%s",
						$self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$usuarios = $result->fetchAll(PDO::FETCH_CLASS,$class);	
		return $usuarios ? $usuarios : false;
	}


	public static function getTotalByGender(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT COUNT(*) total,sexo FROM %s GROUP BY sexo ORDER BY sexo ASC", $self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$dados = array();
			foreach ($result as &$arr) {
				if(isset($arr['total']) && isset($arr['sexo'])){
					$dados[$arr['sexo']] = $arr['total'];
				}			
			}
			$result = $dados;
		}
		return $result ? $result : false;
	}

	public static function getTotalByState(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT COUNT(*) total,uf  FROM %s GROUP BY uf ORDER BY uf ASC", $self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$dados = array();
			foreach ($result as &$arr) {
				if(isset($arr['total']) && isset($arr['uf'])){
					$dados[$arr['uf']] = $arr['total'];
				}
			}
			$result = $dados;
		}
		return $result ? $result : false;	
	}

	public static function getTotalComSemNf(){
		$class = get_called_class();
		$self  = new $class();
		$usuarios = UsuarioModel::all();
		$result =  Array("Com nota fiscal"=>0,"Sem nota fiscal"=>0);	
		$total_com = 0;
		$total_sem = 0;
		foreach($usuarios as $usuario){
			if(NotaFiscalModel::where('id_rel_usuario',$usuario->{'id_fini_usuario'})){
				$result['Com nota fiscal']++;
			}
			if(!NotaFiscalModel::where('id_rel_usuario',$usuario->{'id_fini_usuario'})){
				$result['Sem nota fiscal']++;
			}
		}
		return $result;	
	}

	public static function getTotalByAge(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT 
						      CASE 
						        WHEN (DATEDIFF(CURRENT_DATE, data_nascimento)/365) >= 80 THEN '>=80'
						        WHEN (DATEDIFF(CURRENT_DATE, data_nascimento)/365) BETWEEN 70 AND 79 THEN '70-79'
						        WHEN (DATEDIFF(CURRENT_DATE, data_nascimento)/365) BETWEEN 60 AND 69 THEN '60-69'
						        WHEN (DATEDIFF(CURRENT_DATE, data_nascimento)/365) BETWEEN 50 AND 59 THEN '50-59'
						        WHEN (DATEDIFF(CURRENT_DATE, data_nascimento)/365) BETWEEN 40 AND 49 THEN '40-49'
						        WHEN (DATEDIFF(CURRENT_DATE, data_nascimento)/365) BETWEEN 30 AND 39 THEN '30-39'
						        WHEN (DATEDIFF(CURRENT_DATE, data_nascimento)/365) BETWEEN 20 AND 29 THEN '20-29'
						        WHEN (DATEDIFF(CURRENT_DATE, data_nascimento)/365) < 20 THEN '<=20'
						        ELSE '<=20'
						      END AS idade,
						      count(*)as total
						FROM fn_usuario
						GROUP BY idade
						ORDER BY total DESC", $self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$dados = array();
			foreach ($result as $arr) {
				if(isset($arr['total']) && isset($arr['idade'])){
					$dados[$arr['idade']] = $arr['total'];
				}
			}
			$result = $dados;
		}
		return $result ? $result : false;	
	}

	public static function getTotalByDate(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT COUNT(*)as total,DATE_FORMAT(data_criacao,'%s')as data 
						FROM `%s`
						GROUP BY DATE(data_criacao) 
						ORDER BY data_criacao ASC",
						$date_format='%d/%m/%Y',
						$self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		if(is_array($result) && !empty($result)){
			$dados = array(
							"datas"=>array(),
							"totais"=>array()
						  );
			foreach ($result as $arr) {
				if(isset($arr['total']) && isset($arr['data'])){
					$dados['datas'][] = $arr['data'];
					$dados['totais'][] = $arr['total'];
				}
			}
			$result = $dados;
		}
		return $result ? $result : false;	
	}	

	public static function getMediaCadastrosPorDia(){
		$class = get_called_class();
		$self  = new $class();
		$sql = sprintf("SELECT AVG(total)as media FROM(
							SELECT COUNT(*) total
							FROM fn_usuario
							GROUP BY DATE(data_criacao)
						) as q1",
						$self->table);
		$dbn = DatabaseConnection::getInstance();
		$result = $dbn->query($sql);
		$result = $result->fetch(PDO::FETCH_ASSOC);
		return $result ? round(floatval($result['media']),2) : 0;
	}

}