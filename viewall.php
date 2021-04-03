<?php
	session_start();
	require_once __DIR__ . "/vendor/autoload.php";
	$page_title = "Admin Dashboard";

	//To prevent admin home page from loading by a session restore
	if (!(isset($_SESSION["admin_id"]) && $_SESSION["admin_pass"] != '')) 
	{
	 header ("Location:index.php");
	}
?>
<html>
	<body class="a">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
		<link href='https://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet'>
		<div>
			<ul>
				<li><p><a href='about.php'>About GSA</a></p></li>
				<li><p><a href='admin_dashboard.php'>All Tasks</a></p></li>
				<li><p><a class='active' href='viewall.php'>View All Patient Profiles</a></p></li>
				<li><p><a href='signout.php'>Sign Out</a></p></li>
			</ul>
		</div>

<?php
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$collection = $client->gsa->patients;
	$cursor = $collection->find();
	if(empty($cursor))
		echo "No patients";
	else
	{
		$data ="<table class='paleBlueRows' ;";
		$data.="<thead>";
		$data.="<tr>";
		$data.="<th>Patient ID</th>";
		$data.="<th>Name</th>";
		$data.="<th>Date of Birth</th>";
		$data.="<th>Email ID</th>";
		$data.="<th>Mobile Number</th>";
		$data.="<th>Gender</th>";
		$data.="<th>Nationality</th>";
		$data.="<th>Blood Group</th>";
		$data.="</tr>";
		$data.="</thead>";
		$data.="<tbody>";
		foreach($cursor as $document)
		{
			$data.="<tr>";
			$data.="<td>" .$document["_id"]."</td>";
			$data.="<td>" .$document["name"]."</td>";
			$data.="<td>" .$document["dob"]."</td>";
			$data.="<td>" .$document["email"]."</td>";
			$data.="<td>" .$document["mobno"]."</td>";
			$data.="<td>" .$document["gender"]."</td>";
			$data.="<td>" .$document["nationality"]."</td>";
			$data.="<td>" .$document["bloodGroup"]."</td>";
			$data.="</tr>";
		}
		$data.="</tbody>";
		$data.="</table>";
		echo $data;
	}
 ?>
</body>
</html>
