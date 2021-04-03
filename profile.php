<?php
	session_start();
	require_once __DIR__ . "/vendor/autoload.php";
	$page_title = "User Profile";
	//To prevent login by a session restore
	if (!(isset($_SESSION["patient_id"]) && $_SESSION["patient_pass"] != '')) 
	{
	 header ("Location:index.php");
	}
?>

<link rel="stylesheet" href="style.css" type="text/css" media="screen" />	
<link href='https://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet'>	

<body class="a">
	<div>
		<ul>
			<li><p><a href="about.php">About GSA</a></p></li>
			<li><p><a href="user_dashboard.php">All Tasks</a></p></li>
			<li><p><a href="addquery.php">Add A Query</a></p></li>
			<li><p><a href="signout.php">Sign Out</a></p></li>
		</ul>
		<h2>Your Information</h2>
	</div>
</body>


<?php
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$collection = $client->gsa->patients;
	$id = (int)$_SESSION["patient_id"];
//	$id=3;
	$document = $collection->findOne( ['_id' => $id] );
	if(empty($document))
		echo "Could not locate your profile";
	else
	{
		$data ="<table class='paleBlueRows' ;";
		$data.="<tbody>";

		$data.="<tr>";
		$data.="<td>Name</td>";
		$data.="<td>" .$document["name"]."</td>";
		$data.="</tr>";

		$data.="<tr>";
		$data.="<td>Date of Birth</td>";
		$data.="<td>" .$document["dob"]."</td>";
		$data.="</tr>";

		$data.="<tr>";
		$data.="<td>Email ID</td>";
		$data.="<td>" .$document["email"]."</td>";
		$data.="</tr>";

		$data.="<tr>";
		$data.="<td>Mobile Number</td>";
		$data.="<td>" .$document["mobno"]."</td>";
		$data.="</tr>";

		$data.="<tr>";
		$data.="<td>Gender</td>";
		$data.="<td>" .$document["gender"]."</td>";
		$data.="</tr>";

		$data.="<tr>";
		$data.="<td>Nationality</td>";
		$data.="<td>" .$document["nationality"]."</td>";
		$data.="</tr>";

		$data.="<tr>";
		$data.="<td>Blood Group</td>";
		$data.="<td>" .$document["bloodGroup"]."</td>";
		$data.="</tr>";

		$data.="</tbody>";
		$data.="</table>";
		echo $data;
	}
	
	echo "<br /><br />";
	//filestoupload
	$data ="<table class='paleBlueRows'>";
	$data.="<thead>";
	$data.="<tr>";
	$data.="<th>Chromosome Number</th>";
	$data.="<th>Exists?</th>";
	$data.="<th>Upload/Update</th>";
	$data.="</tr>";
	$data.="</thead>";
	$data.="<tbody>";
	for($i=1; $i<24; $i++)
	{
		$data.="<tr>";
		$data.="<td>".$i."</td>";
		$target_file = "/var/www/html/datasetuploads/".$id."/chr".$i.".fasta";
		if (file_exists($target_file)) 
		{
			$data.="<td>Yes</td>";
		}
		else
			$data.="<td>No</td>";
		$url="upload.php?chr=".$i;
		$data.='<td> <a target = "_blank" href='.$url.'>Choose</a> </td>';
		$data.="</tr>";
	}
	$data.="</tbody>";
	$data.="</table>";
	echo $data;
?>
