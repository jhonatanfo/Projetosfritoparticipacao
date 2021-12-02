<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

defined("SSX") or die;

class SsxAjax
{
	private $data = array();

	private $function;
	private $output;
	private $callback;

	private $returnData;
	private $errors;

	public function __construct($_data, $_function,$_callback, $_output)
	{
		if(is_array($_data))
			$this->data = $_data;

		$this->function = $_function;
		$this->callback = $_callback;
		$this->output = $_output;

		$this->executeAction();
	}

	public function importAjaxFile($class_prefix)
	{
		if(!$class_prefix)
		  return;

		if(file_exists(LOCALPATH . "control/ajax/".$class_prefix.".php"))
		{
			require_once(LOCALPATH . "control/ajax/".$class_prefix.".php");
			return true;
		}else if(file_exists(LOCALPATH . "../control/ajax/".$class_prefix.".php"))
		{
			require_once(LOCALPATH . "../control/ajax/".$class_prefix.".php");
			return true;
		}else if(file_exists(COREPATH . "library/ajax/".$class_prefix.".php"))
		{
			require_once(COREPATH . "library/ajax/".$class_prefix.".php");
			return true;
		}else{
			$this->errors[] = SSX_AJAX_ERROR_01;
		}
		return false;
	}

	private function executeAction()
	{
		if(!$this->function)
		{
			$this->errors[] = SSX_AJAX_ERROR_04;
			return;
		}

		$data_pAjax = explode("_", $this->function);

		if(count($data_pAjax) < 2)
		{
			$this->errors[] = SSX_AJAX_ERROR_04;
			return;
		}

		$class_prefix = reset($data_pAjax);

		$loaded = $this->importAjaxFile($class_prefix);

		unset($data_pAjax[0]);

		$function_name = implode("_", $data_pAjax);

		if($loaded)
		{
			$result = "";
			if(class_exists($class_prefix)){

				$obj = new $class_prefix;
				if($obj && method_exists($obj,$function_name) && is_subclass_of($obj, 'SsxAjaxElement'))
				{
					$result = call_user_func(array($obj, $function_name),$this->data);
					$this->returnData = $result;
					unset($obj);
				}else{
					// var_dump($obj , method_exists($obj,$function_name), is_subclass_of($obj, 'SsxAjaxElement'),$function_name);
					// die();
					$this->errors[] = SSX_AJAX_ERROR_03;
				}
				return;
			}else{
				$this->errors[] = SSX_AJAX_ERROR_02;
			}
		}
	}

	public function returnCall()
	{
		$callback = $this->callback;
		$output = $this->output;

		$data_to_return = array();

		$data_to_return['errors'] = $this->errors;

		if(is_string($this->returnData))
			$data_to_return['result'] = utf8_encode($this->returnData);
		else
			$data_to_return['result'] = $this->returnData;

		$data_to_return['callback'] = $callback;

		if($output == 'json')
		{
			define_json();

			global $Ssx;
			$json_string = $Ssx->utils->jsonReturn($data_to_return);

			print $json_string;
		}else{
			define_xml();

			$encoding = 'UTF-8';

			if(defined('SSX_ENCODING'))
				$encoding = constant('SSX_ENCODING');

			print '<?xml version="1.0" encoding="'.$encoding.'"?>';
			print $this->returnData;
		}
	}
}
