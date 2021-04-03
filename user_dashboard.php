<?php
	session_start();
	require_once __DIR__ . "/vendor/autoload.php";
	$page_title = "User Dashboard";
	$id=(int)$_SESSION["patient_id"];
//	$id=3;
	//To prevent login by a session restore
	if (!(isset($_SESSION["patient_id"]) && $_SESSION["patient_pass"] != '')) 
	{
	 header ("Location:index.php");
	}

?>

<html>
	<head>
		<meta http-equiv="refresh" charset="utf-8" content="15"/>
	</head>
	
	<body class="a">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
		<link href='https://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet'>
		<div>
			<ul>
				<li><p><a href="about.php">About GSA</a></p></li>
				<li><p><a href="addquery.php">Add A Query</a></p></li>
				<li><p><a href="profile.php">My Profile</a></p></li>
				<li><p><a href="signout.php">Sign Out</a></p></li>
			</ul>
		</div>
	
		<?php
			$client = new MongoDB\Client("mongodb://localhost:27017");
			$collection = $client->gsa->tasks;
			$data ="<table class='paleBlueRows'>";
			$data.="<thead>";
			$data.="<tr>";
			$data.="<th>Task ID</th>";
			$data.="<th>Your File</th>";
			$data.="<th>Selected Disease</th>";
			$data.="<th>Status</th>";
			$data.="<th>Submission Time</th>";
			$data.="<th>Completion Time</th>";
			$data.="<th>Results</th>";
			$data.="</tr>";
			$data.="</thead>";
			$data.="<tbody>";
			$cursor=$collection->find(['patient_id' => $id]);
			
			$disclient = new MongoDB\Client("mongodb://localhost:27017");
			$discoll = $disclient->gsa->diseases;
			foreach($cursor as $document)
			{
				$docid = $document["seq1"].'_'.$document["seq2"].'.txt';
				$data.="<tr>";
				$data.="<td>" .$document["_id"]."</td>";
				$data.="<td>" .$document["seq1"]."</td>";
				$discursor = $discoll->find();
				foreach($discursor as $disdoc)
				{
					if($document["seq2"] == $disdoc['_id'])
					{
						$data.="<td>" .$disdoc["name"]."</td>";
					}
				}
				$data.="<td>" .$document["status"]."</td>";
				$data.="<td>" .$document["submit_time"]."</td>";
				$data.="<td>" .$document["completion_time"]."</td>";
				$data.="<td>" .$document["score"]."</td>";
				$data.="</tr>";
			}
			$data.="</tbody>";
			$data.="</table>";
			echo $data;	
		?>
	</body>
</html>
