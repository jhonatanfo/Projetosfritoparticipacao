<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

class SsxPages extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_pages";
	
	public $fields = array(
		'id',
		'created_by',
		'date_created',
		'modified_by',
		'date_modified',
		'title',
		'slug',
		'content',
		'status'
	);
	
	public function SsxPages()
	{
		parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	public function delete($id)
	{
		return parent::definityDelete($id);
	}
	
	public function getBySlug($slug)
	{
		return parent::filterData(array('slug'=>$slug), true);
	}
	
	public function getBySlugPublished($slug)
	{
		return parent::filterData(array('slug'=>$slug,'status'=>1), true);
	}
	
	public static function getPage()
	{
		global $Ssx;
		
		$permission = SsxConfig::get(SsxConfig::SSX_PAGES_ALLOW);
		if(!$permission)
			return false;
		
		$param = $Ssx->themes->get_param(0);
		if($param == "pages")
			$param = $Ssx->themes->get_param(1);
			
		
		$SsxPages = new SsxPages();
		
		$page = $SsxPages->getBySlugPublished($param);
		if($page)
		{
			$Ssx->themes->set_theme_title($page['title']." |",false, true);
			return $page['content'];
		}
		return false;
	}
}