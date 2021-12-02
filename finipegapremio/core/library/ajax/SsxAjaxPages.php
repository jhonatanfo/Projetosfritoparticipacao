<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

class SsxAjaxPages extends SsxAjaxElement
{
	
	public function generateslug($data)
	{
		$SsxPages = new SsxPages();
		
		$slug = $this->ssx->utils->generateSlug($data['title']);
		
		$check = $SsxPages->getBySlug($slug);
		
		if($check)
		{
			$key = 1;
			$found = false;
			while(!$found)
			{
				if(!$SsxPages->getBySlug($slug."-".$key))
				{
					$found = true;
				}else{
					$key++;
				}
			}
			
			return array('slug'=>$slug."-".$key);
		}
		return array('slug'=>$slug);
	}
}