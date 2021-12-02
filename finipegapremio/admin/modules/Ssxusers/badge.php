<?php

global $Ssx;


$PeopleBadges = new PeopleBadges();
$Badges = new Badges();

$id = get_request('id','GET');


$allBadges = $Badges->getAll('date_created', 'DESC');


$Ssx->themes->assign('badges', $allBadges);

if(isset($_POST['save']) && $_POST['save']){
	
	$badges = get_request('badges', 'REQUEST');
	
	$total = count($badges);
	
		for($i = 0; $i <$total; $i++){
		
			$data = array(
						'people_id'=>$id,
						'badges_id'=>$badges[$i]
						);			
						
			 $result = $PeopleBadges->save($data);
		}
	
	
}

