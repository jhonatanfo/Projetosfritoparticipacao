<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

 global $Ssx;
 
 $SsxUsers = new SsxUsers();
 
 
 
 $page = get_request('page', 'GET');
 $page = $Ssx->utils->setInt($page);
 $page--;
 $page = $page<1?0:$page;
 
 $limit = 20;
 
 $search = get_request("search_user", "POST");

if(isset($search) && $search){
	$args = array(
			"AND"=>array(
				array('field'=>'name','compare'=>'LIKE','value'=>"%".$search."%"),
				array('field'=>'deleted', 'compare'=>'=', 'value'=>0)
			)
	);
	

}else{
 
 $args = array(
 				'AND'=>array(
 						array('field'=>'deleted', 'compare'=>'=', 'value'=>0)
 				)
 			);
}

 $SsxUsers->addFilterListener('ssx_getall','ssx_get_table_logs');
 $all = $SsxUsers->getAll("date_created","DESC", $limit, $page, $args);
 $pagination = $SsxUsers->mountPagination($args, $limit);
 
 
 
 $Ssx->themes->assign('all', $all);
 $Ssx->themes->assign('pagination', $pagination);
 $Ssx->themes->assign('pagination_page', $page+1);
 $Ssx->themes->assign('user_deleted', get_request('user_deleted', 'GET'));