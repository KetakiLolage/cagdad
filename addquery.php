<?php
	session_start();
	require_once __DIR__ . '/vendor/autoload.php';
	$page_title = "Add a Query";
	$id=(int)$_SESSION['patient_id'];
//	$id=3;
	//To prevent login by a session restore
	if (!(isset($_SESSION["patient_id"]) && $_SESSION["patient_pass"] != '')) 
	{
	 header ("Location:index.php");
	}

?>

<html>
	<head>
		<meta charset='utf-8'/>
	</head>

	<body class='a'>
	<link rel='stylesheet' type='text/css' href='style.css' media='screen'>
		<link href='https://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet'>	
		<div>
			<ul>

				<li><p><a href='about.php'>About GSA</a></p></li>
				<li><p><a href='user_dashboard.php'>Dashboard</a></p></li>
				<li><p><a href='profile.php'>My Profile</a></p></li>
				<li><p><a href="signout.php">Sign Out</a></p></li>
			</ul>
		</div>
		<div id="addquery">
		<form method='POST' action=''>	
			<span style='position: absolute; top: 100pt; left: 200pt;right:200pt;'>
				<h2>Please select diseases</h2>
				
				<?php
					$client = new MongoDB\Client('mongodb://localhost:27017');
					$collection = $client->gsa->diseases;
					$cursor=$collection->find();
					foreach($cursor as $document)
					{
						echo "<ul>\n";
	   					echo "<li><p><input type='checkbox' name='dis[]' value='".$document['name']."'/>".$document['name']."</p></li>";
						echo "</ul>\n";
					}
				?>
				
				<input type='submit' name='submitd' value='Add Query'>
			</span>
		</form>
		</div>
	</body>
</html>

<?php
	if(isset($_POST['submitd']))
	{
		if(!empty($_POST['dis']))
		{
			$client = new MongoDB\Client('mongodb://localhost:27017');
			$collection = $client->gsa->diseases;
			$tclient = new MongoDB\Client("mongodb://localhost:27017");
			$tcollection = $tclient->gsa->tasks;
			
			$files = array();
			foreach($_POST['dis'] as $selected)
			{
				$doc = $collection->findOne( ['name' => $selected ] );
				array_push($files, $doc['chromosome']);

				$seq1path="";	

				for($x=0; $x<32; $x=$x+1)
				{
					$seq1path = "\/var\/www\/html\/datasetuploads\/".$id."\/"."chr".$doc['chromosome']."_".$x.".fasta";
					$cnt = $tcollection->count();
					$insertOneResult = $tcollection->insertOne(["_id" => $cnt, "patient_id" => $id, "seq1" => $seq1path, "seq2" => $doc['_id'], "status" => "todo", "submit_time" => "-", "completion_time" => "-", "score" => "0"]);
					$seq1path="";
				}
			}
		?>
			<script type="text/javascript">window.alert('Please update the following files: <?php foreach($files as $f) echo $f.", "; ?>');</script>
			<?php
		}
	}
	
?>
