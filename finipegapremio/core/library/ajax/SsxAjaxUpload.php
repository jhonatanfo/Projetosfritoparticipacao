<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */


class SsxAjaxUpload extends SsxAjaxElement
{
	public function uploadFile()
	{	$dir = null;
		if($dir === null){
			$dir = 'files/uploads/';
		}
		
		$imageData = $_FILES['ssx_upload_item'];
		
		$SsxUpload = new SsxUpload(PROJECTPATH . $dir,false);
		
		$fileName = $SsxUpload->uploadImage($imageData);
		
		if($fileName)
		{
			return array(
				'success'=>true,
				'file_url'=> $this->siteurl(false). $dir .$fileName
			);
		}
		return array('success'=>false);
	}
}