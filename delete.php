<?php
	session_start();
	require_once __DIR__ . "/vendor/autoload.php";
	$page_title = "Delete A Patient";

//To prevent admin home page from loading by a session restore
/*if (!(isset($_SESSION["admin_login"]) && $_SESSION["admin_login"] != '')) 
{
 header ("Location:mainpage.html");
}*/
?>
<html>
	<head>
		<meta charset="utf-8"/>
	</head>
	
	<body class="a">
<!--		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />	
		<link href='https://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet'>	-->
		<div id="content">
			<ul>
				<li><p><a href="index.php">Home</a></p></li>
				<li><p><a href="about.php">About GSA</a></p></li>
				<li><p><a class="active" href="delete.php">Delete A Patient Profile</a></p></li>
				<li><p><a href="viewall.php">View All Patient Profiles</a></p></li>
				<li><p><a href="signout.php">Sign Out</a></p></li>
			</ul>
		</div>

		<span style="position: relative; top:30pt; left:260pt;">
			<div id="del">
				<span style="position: relative; top:20pt; left:60pt;">
					<h3>Enter Patient ID to delete:</h3>
					<form action="" method="post">
						<p>ID: <input type="text" name="id1" required="required"> </p>
						<br />
						<input type="submit" name="submit1" value="Submit">
					</form>
				</span>
			</div>
		</span>

<?php
	if(isset($_POST["submit1"]))
	{
		$client = new MongoDB\Client("mongodb://localhost:27017");
		$collection = $client->gsa->patients;
		$e=test_input($_POST["id1"]);
		$document = $collection->findOne( ['_id' => $e] );
		$name=$document["name"];
		if($document == NULL)
		{
			echo "\nNo such Patient.";
			echo "name here".$name;
		}
		else
		{
			echo "deleted";
			$res=$collection->remove(array('name' => new MongoID('0')));
			echo "name here".$name;
		}
	}
	
	function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	}

?>
</body>

</html>
