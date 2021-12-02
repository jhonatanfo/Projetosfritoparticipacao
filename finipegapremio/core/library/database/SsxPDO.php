<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
defined("SSX") or die;

class SsxPDO
{
	/**
	 * Conexão com o banco de Dados
	 * @var PDO
	 */
	public $con;
	
	/**
	 * Classe em contrução
	 * @param SsxHosts $host
	 */
	public function __construct(SsxHosts $host)
	{
		if(!$host)
			die(SSX_ERROR_DB_02);
			
		$this->openConnection($host);
	}
	
	private function openConnection(SsxHosts $host)
	{
		try
		{
			$this->con = new PDO("mysql:host=" . $host->host . ";dbname=" . $host->database, $host->user, $host->pass);
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		}catch(PDOException $e)
		{
			die("SSXPDO: Não foi possível conectar. <br />" . $e->getMessage());
		}
	}
}