<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
 global $Ssx;

 $SsxGroups = new SsxGroups();
 
 
 $page = get_request('page', 'GET');
 $page = $Ssx->utils->setInt($page);
 $page--;
 $page = $page<1?0:$page;
 
 $limit = 20;
 
 $args = array('AND'=>array(array('field'=>'deleted', 'compare'=>'=', 'value'=>0)));
 $SsxGroups->addFilterListener('ssx_getall','ssx_get_table_logs');
 $all = $SsxGroups->getAll("date_created","DESC", $limit, $page, $args);
 $pagination = $SsxGroups->mountPagination($args, $limit);
 
 $Ssx->themes->assign('all', $all);
 $Ssx->themes->assign('pagination', $pagination);
 $Ssx->themes->assign('pagination_page', $page+1);
 $Ssx->themes->assign('group_deleted', get_request('group_deleted', 'GET'));