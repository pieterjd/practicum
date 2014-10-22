<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
	include_once('../daos/dbConnect.php');
	connect();
	include_once('../daos/groepDao.php');
	include_once('../daos/studentDao.php');
	include_once('../daos/pracDao.php');
?>
<head profile="http://gmpg.org/xfn/11">

	<title>Practicum Groep Overzicht</title>
	<link rel="stylesheet" type="text/css" href="./css/inschrijven.css" />
	<link rel="stylesheet" type="text/css" href="./css/ui.tabs.css" />
	<script src="./javascript/jquery-1.2.1.pack.js" type="text/javascript"></script>
<script src="./javascript/ui.tabs.js" type="text/javascript"></script>


</head>

<body>
<?php
	$query="select id,groep,reeks from prac_student";
	$result=mysql_query($query);
	while($row=mysql_fetch_array($result)){
		$pracreeks=$row[1].$row[2];
		$id=$row[0];
		echo "id $id -> $pracreeks";
		$insert="update prac_student set pracreeks='$pracreeks' where id=$id";
		mysql_query($insert);
		echo "$insert";
		echo "<br/>";
	}

?>
</body>
</html>