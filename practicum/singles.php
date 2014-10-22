<?php
	include_once('./daos/dbConnect.php');
	connect();
	include_once('./daos/groepDao.php');
	include_once('./daos/studentDao.php');
	include_once('./daos/pracDao.php');
	$pracId=33;
	$studIds= array(7758,7448,7825,7491,7885,7677,7420);
	$studIds= array(7359);
	//$studIds= array(586);
	foreach($studIds as $id){
		$info = getStudentInfo($id);
		print_r($info);
		echo '<br/>';
		//create group
		$groupId = makeNewGroup($pracId,$info['pracreeks']);
		//add student to group
		addStudentToGroep($id,$groupId);
		//send message
		zendBevestigingsMail($pracId,$id,array(),'');
	}

?>