<?php


global $Ssx;


$PeopleBadges = new PeopleBadges();
$Badges = new Badges();

$id = get_request('id','GET');

$allBadges = $Badges->getAll('date_created', 'DESC');

$Ssx->themes->assign('badges', $allBadges);

$people_badge = $PeopleBadges->getBadgesCompare($id);

if(isset($_POST['save']) && $_POST['save']){
	
	$people_new_badges = get_request('badges', 'REQUEST');
	
	$array_delete = array_diff($people_badge,$people_new_badges);
	
	$array_insert = array_diff($people_new_badges, $people_badge);
	
	$total_delete = count($array_delete);
	
		for($i = 0; $i < $total_delete; $i++){
		
			$id_delete = $array_delete[$i]["badges_id"];
		
			$result_delete = $PeopleBadges->deletePeopleBadge($id, $id_delete);
		}
	
	$total_insert = count($people_new_badges);

		for($j = 0; $j <$total_insert; $j++){
		
			$data = array(
						'people_id'=>$id,
						'badges_id'=>$people_new_badges[$j]
						);			
						
			 $result = $PeopleBadges->save($data);
		
		}
	
	
}


