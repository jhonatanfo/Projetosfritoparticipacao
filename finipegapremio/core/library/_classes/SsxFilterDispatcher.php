<?php
/**
 * 
 * Classe que cria forma de filtros para o sistema, para que o resultado de qualquer
 * ação possa ser interceptado
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

class SsxFilterDispatcher
{
	/**
	 * Todos os filtros do sistema ficarão armazenados aqui
	 * @var array
	 */
	private $ssx_filters = array();
	
	
	public function addFilterListener($filter, $Function)
	{
		if(!is_string($filter))
			return false;
			
		$data = array();
		if(is_callable($Function, true))
		{
			$data = array(
				'callback'=>$Function
			);
			
			if(!isset($this->ssx_filters[$filter]))
				$this->ssx_filters[$filter] = array();
							
			array_push($this->ssx_filters[$filter], $data);
		}else{
			return false;
		}
		return true;		
	}
	
	public function removeFilterListener($filter, $Function)
	{
		if(!is_string($filter))
			return false;
			
		if(count($this->ssx_filters) < 1)
			return false;
			
		$data = array();
		$callbackname = "";
		if(is_callable($Function, true, $callbackname))
		{
			if(isset($this->ssx_filters[$filter]))
			{
				foreach($this->ssx_filters[$filter] as $key => $callbacks)
				{
					$call = "";
					if(is_callable($callbacks['callback'], true, $call))
					{
						if($call == $callbackname)
						{
							unset($this->ssx_filters[$filter][$key]);
							return true;
						}
					}
				}
			}			
		}
		return false;
	}
	
	public function dispatchFilter($filter, $contentResult)
	{
		if(!is_string($filter))	
			return $contentResult;
			
		if(isset($this->ssx_filters[$filter]) && count($this->ssx_filters[$filter])>0)
		{
			foreach($this->ssx_filters[$filter] as $callbacks)
			{
				$contentResult = call_user_func($callbacks['callback'], $contentResult);
			}
		}

		return $contentResult;
	}
}