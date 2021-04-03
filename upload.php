<?php
	session_start();
	require_once __DIR__ . "/vendor/autoload.php";
	$id=(int)$_SESSION["patient_id"];
//	$id=3;
	$chr = $_GET['chr'];
?>

<html>
	<head>
		<meta charset="utf-8"/>
	</head>

	<body class="a">
		<link rel="stylesheet" type="text/css" href="style.css" media="screen">
		<link href='https://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet'>
		<div id="content">
			<ul>
				<li><p><a href="about.html">About GSA</a></p></li>
				<li><p><a href="user_dashboard.php">All Tasks</a></p></li>
				<li><p><a href="profile.php">My Profile</a></p></li>
				<li><p><a href="signout.php">Sign Out</a></p></li>
			</ul>
		</div>
		<form method='post' action='' enctype='multipart/form-data'>
			<h5>Select your file for chromosome number <?php echo $chr;?></h5>
			<p class='one'>
			<input type='file' name='fileToUpload' /><br /><br />
			<input type='submit' name='submit' value='Upload'/>
			</p>
		</form>	
	</body>
</html>

<?php
	if(isset($_POST["submit"]))
	{
		if(!is_dir("/var/www/html/datasetuploads/".$id))
		{
			mkdir("/var/www/html/datasetuploads/".$id);
		}
		$target_dir = "/var/www/html/datasetuploads/".$id."/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		if (file_exists($target_file)) 
		{
			echo "<p>Sorry, file already exists.</p>";
			$uploadOk = 0;
		}
		if ($uploadOk == 0) 
		{
			echo "<p>Sorry, your file was not uploaded.</p>";
		} 
		else 
		{
			$file_basename = substr($target_file, 0, strripos($target_file, '.')); // get file extention
			$ext = end(explode(".", $_FILES["fileToUpload"]["name"]));
			$newfilename = "chr"."$chr".".fasta";
			echo $_FILES["fileToUpload"]["name"];
			echo "<br />";
			echo $newfilename;
			echo "<br />";
			$pp = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$newfilename);
			if ($pp) 
			{
				$client = new MongoDB\Client('mongodb://localhost:27017');
				$collection = $client->gsa->tasks;
				$comm = "python /var/www/html/split.py /var/www/html/datasetuploads/".$id."/chr".$chr.".fasta";
				$command = escapeshellcmd($comm);
				$output = shell_exec($command);
				
				echo "</p>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</p>";
				echo "<br />";
				
				exit;
			} 
			else 
			{
				echo "<p>Sorry, there was an error uploading your file.</p>";
			}
		}
	}
?>
